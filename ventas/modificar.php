<?php
    // modificar.php (VENTAS)
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='sistemainventario';

    header('Content-Type: application/json');

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $json_input = file_get_contents('php://input');
        $data = json_decode($json_input, true); 

        $id_venta_a_modificar = $data['id_venta'] ?? null;
        $productos_carrito = $data['productos'];
        $nombre_cliente = $data['nombre_cliente'];
        $fecha_venta = $data['fecha_venta'];

        if (empty($productos_carrito) || empty($id_venta_a_modificar)) {
            echo json_encode(["error" => "Faltan datos."]);
            exit;
        }

        // 1. ID CLIENTE
        $sql_cliente = "SELECT id_clientes FROM clientes WHERE nombre = :nombre_cliente";
        $stmt_cliente = $con->prepare($sql_cliente);
        $stmt_cliente->bindParam(':nombre_cliente', $nombre_cliente);
        $stmt_cliente->execute();
        $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            echo json_encode(["error" => "El cliente no existe."]);
            exit;
        }
        $id_cliente = $cliente['id_clientes'];

        // 2. CALCULAR TOTALES
        $tasa_iva = 0.16; 
        $subtotal_final = 0;
        foreach ($productos_carrito as $producto) {
            $subtotal_final += $producto['precio'] * $producto['cantidad'];
        }
        $iva_calculado = $subtotal_final * $tasa_iva; 
        $total_calculado = $subtotal_final + $iva_calculado;

        // 3. TRANSACCIÓN
        $con->beginTransaction();
        try {
            // --- PASO A: REVERTIR STOCK (Devolver lo que se llevó antes) ---
            $sql_old = "SELECT Productos_id_productos, cantidad FROM ventas_productos WHERE Ventas_id_ventas = :id";
            $stmt_old = $con->prepare($sql_old);
            $stmt_old->execute([':id' => $id_venta_a_modificar]);
            $productos_viejos = $stmt_old->fetchAll(PDO::FETCH_ASSOC);

            $sql_sumar = "UPDATE productos SET cantidad = cantidad + :cant WHERE id_productos = :id";
            $stmt_sumar = $con->prepare($sql_sumar);

            foreach($productos_viejos as $viejo) {
                $stmt_sumar->execute([
                    ':cant' => $viejo['cantidad'],
                    ':id'   => $viejo['Productos_id_productos']
                ]);
            }

            // --- PASO B: BORRAR DETALLES VIEJOS ---
            $sql_delete = "DELETE FROM ventas_productos WHERE Ventas_id_ventas = :id_venta";
            $stmt_d = $con->prepare($sql_delete);
            $stmt_d->bindParam(':id_venta', $id_venta_a_modificar);
            $stmt_d->execute();
            
            // --- PASO C: ACTUALIZAR VENTA PADRE ---
            $sql_update = "UPDATE ventas SET Clientes_id_clientes = :id, iva = :iva, total = :total, fecha_venta = :fecha WHERE id_ventas = :id_venta";
            $stmt_u = $con->prepare($sql_update);
            $stmt_u->bindParam(':id', $id_cliente);
            $stmt_u->bindParam(':iva', $iva_calculado);
            $stmt_u->bindParam(':total', $total_calculado);
            $stmt_u->bindParam(':fecha', $fecha_venta);
            $stmt_u->bindParam(':id_venta', $id_venta_a_modificar);
            $stmt_u->execute();

            // --- PASO D: INSERTAR NUEVOS Y RESTAR STOCK ---
            $sql_vp = "INSERT INTO ventas_productos (Ventas_id_ventas, Productos_id_productos, cantidad, precio, subtotal) VALUES (:id_v, :id_p, :cant, :pre, :sub)";
            $stmt_vp = $con->prepare($sql_vp);

            $sql_restar = "UPDATE productos SET cantidad = cantidad - :cant WHERE id_productos = :id";
            $stmt_restar = $con->prepare($sql_restar);

            foreach ($productos_carrito as $producto) {
                $sub = $producto['cantidad'] * $producto['precio'];
                
                // Insertar
                $stmt_vp->bindValue(':id_v', $id_venta_a_modificar);
                $stmt_vp->bindValue(':id_p', $producto['id_articulo']);
                $stmt_vp->bindValue(':cant', $producto['cantidad']);
                $stmt_vp->bindValue(':pre', $producto['precio']);
                $stmt_vp->bindValue(':sub', $sub);
                $stmt_vp->execute();

                // Restar Stock
                $stmt_restar->bindValue(':cant', $producto['cantidad']);
                $stmt_restar->bindValue(':id', $producto['id_articulo']);
                $stmt_restar->execute();
            }

            $con->commit();
            echo json_encode(["status" => "success", "mensaje" => "Venta modificada y stock actualizado."]);

        } catch (Exception $e) {
            $con->rollBack();
            echo json_encode(["error" => $e->getMessage()]);
        }

    } catch(Exception $e) {
        echo json_encode(["error" => "Error conexión: " . $e->getMessage()]);
    }
?>