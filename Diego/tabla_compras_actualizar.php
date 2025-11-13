<?php
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='ventas';

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);

        $sql = "SELECT * FROM compras ORDER BY id_compra DESC";
        
        $stmt = $con->query($sql);
        $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($compras);

    } catch(PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
?>