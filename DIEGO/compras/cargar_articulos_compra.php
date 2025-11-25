<?php
    $server = 'localhost:3306'; 
    $username = 'root'; 
    $password = ''; 
    $database ='sistemainventario';

    header('Content-Type: application/json');

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Verifica si tu columna se llama 'precio_compra' o solo 'precio'
        $sql = "SELECT id_productos, nombre, precio_compra FROM productos ORDER BY nombre ASC";
        
        $stmt = $con->query($sql);
        $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($articulos); 

    } catch(Exception $e) { 
        echo json_encode([]); 
    }
?>