<?php
    $server = 'localhost:3306'; 
    $username = 'root'; 
    $password = ''; 
    $database ='sistemainventario';

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Consulta para llenar el select de clientes
        $stmt = $con->query("SELECT nombre FROM clientes ORDER BY nombre ASC");
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($clientes);

    } catch(Exception $e) { 
        echo json_encode([]); 
    }
?>