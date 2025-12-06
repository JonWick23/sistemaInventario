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
            echo json_encode(["error" => "No se recibió el ID de la venta"]);
            exit;
        }
        $id_venta = $_GET['id'];

        //DATOS DE LA VENTA (CLIENTE Y FECHA)
        $sql_venta = "SELECT v.fecha_venta, c.nombre as nombre_cliente 
                      FROM ventas v 
                      JOIN clientes c ON v.Clientes_id_clientes = c.id_clientes 
                      WHERE v.id_ventas = :id";
        $stmt = $con->prepare($sql_venta);
        $stmt->bindParam(':id', $id_venta);
        $stmt->execute();
        $venta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$venta) {
            echo json_encode(["error" => "Venta no encontrada"]);
            exit;
        }
        //OBTENER LOS PRODUCTOS DE ESA VENTA
        //sacar el NOMBRE del artículo
        $sql_productos = "SELECT vp.Productos_id_productos as id, p.nombre, vp.cantidad, vp.precio 
                          FROM ventas_productos vp
                          JOIN productos p ON vp.Productos_id_productos = p.id_productos
                          WHERE vp.Ventas_id_ventas = :id";
        $stmt_p = $con->prepare($sql_productos);
        $stmt_p->bindParam(':id', $id_venta);
        $stmt_p->execute();
        $productos = $stmt_p->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "venta" => $venta,
            "productos" => $productos
        ]);

    } catch(PDOException $e) {
        echo json_encode(["error" => "Error en BD: " . $e->getMessage()]);
    }
?>