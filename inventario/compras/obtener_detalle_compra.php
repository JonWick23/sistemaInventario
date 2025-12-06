<?php
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='sistemainventario';

    header('Content-Type: application/json');

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (!isset($_GET['id'])) {
            echo json_encode(["error" => "No se recibió el ID"]);
            exit;
        }
        $id_compra = $_GET['id'];

        // 1. DATOS DE LA COMPRA (MAESTRO)
        // Corregido: Tabla 'provedores' y 'Provedores_id_provedores'
        $sql_compra = "SELECT c.fecha as fecha_venta, p.nombre as nombre_proveedor 
                       FROM compras c 
                       JOIN provedores p ON c.Provedores_id_provedores = p.id_provedores 
                       WHERE c.id_compras = :id";
                       
        $stmt = $con->prepare($sql_compra);
        $stmt->bindParam(':id', $id_compra);
        $stmt->execute();
        $compra = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$compra) {
            echo json_encode(["error" => "Compra no encontrada"]);
            exit;
        }

        // 2. PRODUCTOS DE LA COMPRA (DETALLE)
        // Corregido: Tabla 'productos_compras' y columnas 'cantidad_pd_cp', 'precio_pd_cp'
        $sql_productos = "SELECT cp.Productos_id_productos as id, p.nombre, 
                                 cp.cantidad_pd_cp as cantidad, 
                                 cp.precio_pd_cp as precio 
                          FROM productos_compras cp
                          JOIN productos p ON cp.Productos_id_productos = p.id_productos
                          WHERE cp.Compras_id_compras = :id";
                          
        $stmt_p = $con->prepare($sql_productos);
        $stmt_p->bindParam(':id', $id_compra);
        $stmt_p->execute();
        $productos = $stmt_p->fetchAll(PDO::FETCH_ASSOC);

        // Enviamos 'venta' para que el JS lo reconozca sin cambios
        echo json_encode([
            "venta" => $compra, 
            "productos" => $productos
        ]);

    } catch(PDOException $e) {
        echo json_encode(["error" => "Error en BD: " . $e->getMessage()]);
    }
?>