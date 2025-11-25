<?php
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='sistemainventario';

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // --- 1. LEER JSON ---
        $json_input = file_get_contents('php://input');
        $data = json_decode($json_input, true); 

        // --- 2. DATOS MAESTROS ---
        $nombre_cliente = $data['nombre_cliente'];
        $fecha_venta = $data['fecha_venta'];
        $iva_porcentaje = filter_var($data['iva'], FILTER_VALIDATE_FLOAT);
        $productos_carrito = $data['productos'];

        if (empty($productos_carrito)) {
            die("Error: No se enviaron productos.");
        }

        // --- 3. BUSCAR CLIENTE ---
        $sql_cliente = "SELECT id_clientes FROM clientes WHERE nombre = :nombre_cliente";
        $stmt_cliente = $con->prepare($sql_cliente);
        $stmt_cliente->bindParam(':nombre_cliente', $nombre_cliente);
        $stmt_cliente->execute();
        $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);
        
        if(!$cliente) {
            die("Error: El cliente '$nombre_cliente' no existe.");
        }
        $id_cliente = $cliente['id_clientes'];

        // --- 4. CALCULAR TOTALES ---
        $subtotal_final = 0;
        foreach ($productos_carrito as $producto) {
            $subtotal_final += $producto['precio'] * $producto['cantidad'];
        }
        $iva_calculado = $subtotal_final * $iva_porcentaje;
        $total_calculado = $subtotal_final + $iva_calculado;

        // --- 5. INICIAR TRANSACCIÓN ---
        $con->beginTransaction();

        try {
            // --- 6. INSERTAR VENTA (Maestro) ---
            $sql_venta = "INSERT INTO ventas (Clientes_id_clientes, iva, total, fecha_venta) 
                          VALUES (:id_cliente, :iva, :total, :fecha_venta)";
            $stmt_venta = $con->prepare($sql_venta);
            $stmt_venta->bindParam(':id_cliente', $id_cliente);
            $stmt_venta->bindParam(':iva', $iva_calculado);
            $stmt_venta->bindParam(':total', $total_calculado);
            $stmt_venta->bindParam(':fecha_venta', $fecha_venta);
            $stmt_venta->execute();

            $id_venta_creada = $con->lastInsertId();

            // --- 7. PREPARAR CONSULTAS DETALLE Y STOCK ---
            
            // A. Insertar detalle
            $sql_vp = "INSERT INTO ventas_productos (Ventas_id_ventas, Productos_id_productos, cantidad, precio, subtotal) 
                       VALUES (:id_venta, :id_articulo, :cantidad, :pre_unitario, :subtotal)";
            $stmt_vp = $con->prepare($sql_vp);

            // B. RESTAR STOCK (Lo nuevo)
            // Importante: Aquí usamos MENOS (-) porque sale mercancía
            $sql_stock = "UPDATE productos SET cantidad = cantidad - :cant WHERE id_productos = :id";
            $stmt_stock = $con->prepare($sql_stock);

            // --- 8. EJECUTAR BUCLE ---
            foreach ($productos_carrito as $producto) {
                $subtotal_producto = $producto['cantidad'] * $producto['precio'];
                
                // 1. Insertar en ventas_productos
                $stmt_vp->bindValue(':id_venta', $id_venta_creada);
                $stmt_vp->bindValue(':id_articulo', $producto['id_articulo']);
                $stmt_vp->bindValue(':cantidad', $producto['cantidad']);
                $stmt_vp->bindValue(':pre_unitario', $producto['precio']);
                $stmt_vp->bindValue(':subtotal', $subtotal_producto);
                $stmt_vp->execute();

                // 2. Restar del Inventario
                $stmt_stock->bindValue(':cant', $producto['cantidad']);
                $stmt_stock->bindValue(':id', $producto['id_articulo']);
                $stmt_stock->execute();
            }

            // --- 9. CONFIRMAR ---
            $con->commit();
            echo "Venta registrada y stock descontado correctamente.";

        } catch (PDOException $e_trans) {
            $con->rollBack();
            echo "Error al procesar la venta: " . $e_trans->getMessage();
        }

    } catch(PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
?>