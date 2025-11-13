<?php
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='sistemainventario'; // Nombre de tu BD (en minúsculas)

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // --- 1. LEER EL JSON ENVIADO POR JAVASCRIPT ---
        $json_input = file_get_contents('php://input');
        $data = json_decode($json_input, true); 

        // --- 2. OBTENER DATOS MAESTROS (La Venta) ---
        $nombre_cliente = $data['nombre_cliente'];
        $fecha_venta = $data['fecha_venta'];
        $iva_porcentaje = filter_var($data['iva'], FILTER_VALIDATE_FLOAT);
        $productos_carrito = $data['productos'];

        if (empty($productos_carrito)) {
            die("Error: No se enviaron productos en la venta.");
        }

        // --- 3. BUSCAR EL ID DEL CLIENTE ---
        $sql_cliente = "SELECT id_clientes FROM clientes WHERE nombre = :nombre_cliente";
        $stmt_cliente = $con->prepare($sql_cliente);
        $stmt_cliente->bindParam(':nombre_cliente', $nombre_cliente);
        $stmt_cliente->execute();
        $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);
        $id_cliente = $cliente['id_clientes'];

        // --- 4. CALCULAR TOTALES DESDE EL CARRITO ---
        $subtotal_final = 0;
        foreach ($productos_carrito as $producto) {
            $subtotal_final += $producto['precio'] * $producto['cantidad'];
        }
        $iva_calculado = $subtotal_final * $iva_porcentaje;
        $total_calculado = $subtotal_final + $iva_calculado;

        // --- 5. INICIAR TRANSACCIÓN (MUY IMPORTANTE) ---
        $con->beginTransaction();

        try {
            // --- 6. INSERTAR LA VENTA (Maestro) ---
            $sql_venta = "INSERT INTO ventas (Clientes_id_clientes, iva, total, fecha_venta) 
                          VALUES (:id_cliente, :iva, :total, :fecha_venta)";
            $stmt_venta = $con->prepare($sql_venta);
            $stmt_venta->bindParam(':id_cliente', $id_cliente);
            $stmt_venta->bindParam(':iva', $iva_calculado);
            $stmt_venta->bindParam(':total', $total_calculado);
            $stmt_venta->bindParam(':fecha_venta', $fecha_venta);
            $stmt_venta->execute();

            // --- 7. OBTENER EL ID DE LA VENTA QUE ACABAMOS DE CREAR ---
            $id_venta_creada = $con->lastInsertId();

            // --- 8. INSERTAR LOS PRODUCTOS (Detalle) ---
            $sql_vp = "INSERT INTO ventas_productos (Ventas_id_ventas, Productos_id_productos, cantidad, precio, subtotal) 
                       VALUES (:id_venta, :id_articulo, :cantidad, :pre_unitario, :subtotal)";
            $stmt_vp = $con->prepare($sql_vp);

            foreach ($productos_carrito as $producto) {
                $subtotal_producto = $producto['cantidad'] * $producto['precio'];
                
                $stmt_vp->bindParam(':id_venta', $id_venta_creada);
                $stmt_vp->bindParam(':id_articulo', $producto['id_articulo']);
                $stmt_vp->bindParam(':cantidad', $producto['cantidad']);
                $stmt_vp->bindParam(':pre_unitario', $producto['precio']);
                $stmt_vp->bindParam(':subtotal', $subtotal_producto);
                $stmt_vp->execute();
            }

            // --- 9. CONFIRMAR TRANSACCIÓN ---
            $con->commit();
            echo "Venta registrada correctamente.";

        } catch (PDOException $e_trans) {
            $con->rollBack();
            echo "Error al almacenar los datos: " . $e_trans->getMessage();
        }

    } catch(PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
?>