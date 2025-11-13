<?php
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='sistemainventario';

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "
            SELECT 
                v.id_ventas,
                v.Clientes_id_clientes AS id_cliente,
                c.nombre AS nombre_cliente,
                SUM(vp.subtotal) AS subtotal,
                v.iva,
                v.total,
                v.fecha_venta 
            FROM 
                ventas AS v
            LEFT JOIN 
                clientes AS c ON v.Clientes_id_clientes = c.id_clientes
            LEFT JOIN 
                ventas_productos AS vp ON v.id_ventas = vp.Ventas_id_ventas
            GROUP BY
                v.id_ventas
            ORDER BY 
                v.id_ventas DESC
        ";
        
        $stmt = $con->query($sql);
        $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($ventas);

    } catch(PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
?>