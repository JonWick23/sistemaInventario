<?php
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='sistemainventario';

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // --- 1. OBTENER Y CALCULAR DATOS ---
            $nombre_cliente = $_POST['nombre_cliente'];
            $nom_articulo = $_POST['nom_articulo'];
            $cantidad = filter_var($_POST['cantidad'], FILTER_VALIDATE_FLOAT);
            $fecha_venta = $_POST['fecha_venta'];
            $iva_porcentaje = filter_var($_POST['iva'], FILTER_VALIDATE_FLOAT); // Ej: 0.16

            // --- 2. BUSCAR CLIENTE Y PRODUCTO ---
            $sql_cliente = "SELECT id_clientes FROM clientes WHERE nombre = :nombre_cliente";
            $stmt_cliente = $con->prepare($sql_cliente);
            $stmt_cliente->bindParam(':nombre_cliente', $nombre_cliente);
            $stmt_cliente->execute();
            $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);
            $id_cliente = $cliente['id_clientes'];

            $sql_producto = "SELECT id_productos, precio_venta FROM productos WHERE nombre = :nom_articulo";
            $stmt_producto = $con->prepare($sql_producto);
            $stmt_producto->bindParam(':nom_articulo', $nom_articulo);
            $stmt_producto->execute();
            $producto = $stmt_producto->fetch(PDO::FETCH_ASSOC);
            $id_articulo = $producto['id_productos'];
            $precio_unitario = $producto['precio_venta'];

            // --- 3. CÁLCULOS CORRECTOS ---
            $subtotal = $cantidad * $precio_unitario;
            $iva_calculado = $subtotal * $iva_porcentaje;
            $total_calculado = $subtotal + $iva_calculado;

            // --- 4. INICIAR TRANSACCIÓN ---
            $con->beginTransaction();

            try {
                $sql_venta = "INSERT INTO ventas (Clientes_id_clientes, iva, total, fecha_venta) VALUES (:id_cliente, :iva, :total, :fecha_venta)";
                $stmt_venta = $con->prepare($sql_venta);
                $stmt_venta->bindParam(':id_cliente', $id_cliente);
                $stmt_venta->bindParam(':iva', $iva_calculado);
                $stmt_venta->bindParam(':total', $total_calculado);
                $stmt_venta->bindParam(':fecha_venta', $fecha_venta);
                $stmt_venta->execute();

                // --- 6. OBTENER EL ID DE LA VENTA CREADA ---
                $id_venta = $con->lastInsertId();

                // --- 7. INSERTAR EN LA TABLA 'ventas_productos' ---
                $sql_vp = "INSERT INTO ventas_productos (Ventas_id_ventas, Productos_id_productos, cantidad, precio, subtotal) VALUES (:id_venta, :id_articulo, :cantidad, :pre_unitario, :subtotal)";
                $stmt_vp = $con->prepare($sql_vp);
                $stmt_vp->bindParam(':id_venta', $id_venta);
                $stmt_vp->bindParam(':id_articulo', $id_articulo);
                $stmt_vp->bindParam(':cantidad', $cantidad);
                $stmt_vp->bindParam(':pre_unitario', $precio_unitario);
                $stmt_vp->bindParam(':subtotal', $subtotal);
                $stmt_vp->execute();

                // --- 8. CONFIRMAR TRANSACCIÓN ---
                $con->commit();
                echo "Datos almacenados correctamente en la base de datos.";

            } catch (PDOException $e_trans) {
                // Si algo falló en las inserciones, deshacer todo
                $con->rollBack();
                echo "Error al almacenar los datos: " . $e_trans->getMessage();
            }
        }
    } catch(PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
?>