<?php
    $server = 'localhost:3306'; $username = 'root'; $password = ''; $database ='sistemainventario';
    header('Content-Type: application/json');
    
    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        // Tabla: provedores
        $stmt = $con->query("SELECT nombre FROM provedores ORDER BY nombre ASC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch(Exception $e) { echo json_encode([]); }
?>