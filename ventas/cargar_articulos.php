<?php
    $server = 'localhost:3306'; 
    $username = 'root'; 
    $password = ''; 
    $database ='sistemainventario';

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Consulta para llenar el select de artículos (incluyendo precio)
        $stmt = $con->query("SELECT id_productos, nombre, precio_venta FROM productos ORDER BY nombre ASC");
        $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($articulos); // Envía los datos a JS

    } catch(Exception $e) { 
        echo json_encode([]); 
    }
?>