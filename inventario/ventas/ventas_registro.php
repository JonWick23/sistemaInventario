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

        //VALIDACIÓN DE STOCK MÍNIMO 
        $sql_check = "SELECT cantidad, nombre FROM productos WHERE id_productos = :id";
        $stmt_check = $con->prepare($sql_check);

        foreach ($productos_carrito as $prod) {
            $stmt_check->execute([':id' => $prod['id_articulo']]);
            $producto_db = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($producto_db) {
                $stock_actual = $producto_db['cantidad'];
                $cantidad_a_vender = $prod['cantidad'];
                $stock_restante = $stock_actual - $cantidad_a_vender;

                if ($stock_actual <= 10) {
                    die("Error: No se puede vender '{$producto_db['nombre']}'. Quedan 10 o menos unidades (Stock actual: $stock_actual).");
                }

                if ($stock_restante < 10) {
                     die("Error: No se puede vender '{$producto_db['nombre']}'. La venta dejaría el stock por debajo de 10 unidades.");
                }
            }
        }

        // CALCULAR TOTALES
        $subtotal_final = 0;
        foreach ($productos_carrito as $producto) {
            $subtotal_final += $producto['precio'] * $producto['cantidad'];
        }
        $iva_calculado = $subtotal_final * $iva_porcentaje;
        $total_calculado = $subtotal_final + $iva_calculado;

        // INICIAR TRANSACCIÓN 
        $con->beginTransaction();

        try {
            //INSERTAR VENTA (Maestro)
            $sql_venta = "INSERT INTO ventas (Clientes_id_clientes, iva, total, fecha_venta) 
                          VALUES (:id_cliente, :iva, :total, :fecha_venta)";
            $stmt_venta = $con->prepare($sql_venta);
            $stmt_venta->bindParam(':id_cliente', $id_cliente);
            $stmt_venta->bindParam(':iva', $iva_calculado);
            $stmt_venta->bindParam(':total', $total_calculado);
            $stmt_venta->bindParam(':fecha_venta', $fecha_venta);
            $stmt_venta->execute();

            $id_venta_creada = $con->lastInsertId();

            //CONSULTAS DETALLE Y STOCK

            $sql_vp = "INSERT INTO ventas_productos (Ventas_id_ventas, Productos_id_productos, cantidad, precio, subtotal) 
                       VALUES (:id_venta, :id_articulo, :cantidad, :pre_unitario, :subtotal)";
            $stmt_vp = $con->prepare($sql_vp);

            //RESTAR STOCK
            $sql_stock = "UPDATE productos SET cantidad = cantidad - :cant WHERE id_productos = :id";
            $stmt_stock = $con->prepare($sql_stock);

            //EJECUTAR BUCLE
            foreach ($productos_carrito as $producto) {
                $subtotal_producto = $producto['cantidad'] * $producto['precio'];
                
                //Insertar en ventas_productos
                $stmt_vp->bindValue(':id_venta', $id_venta_creada);
                $stmt_vp->bindValue(':id_articulo', $producto['id_articulo']);
                $stmt_vp->bindValue(':cantidad', $producto['cantidad']);
                $stmt_vp->bindValue(':pre_unitario', $producto['precio']);
                $stmt_vp->bindValue(':subtotal', $subtotal_producto);
                $stmt_vp->execute();

                //Restar del Inventario
                $stmt_stock->bindValue(':cant', $producto['cantidad']);
                $stmt_stock->bindValue(':id', $producto['id_articulo']);
                $stmt_stock->execute();
            }

            //CONFIRMAR 
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