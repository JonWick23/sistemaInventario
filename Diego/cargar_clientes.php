<?php
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='sistemainventario';

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // (Asegúrate que tu tabla se llame 'Clientes')
        $sql = "SELECT id_clientes, nombre FROM Clientes WHERE estatus = 'Activo' ORDER BY nombre ASC";
        
        $stmt = $con->query($sql);
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($clientes);

    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>