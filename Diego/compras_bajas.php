<?php
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='ventas';

    // Asegurarse de que se envió un id_venta
    if (!isset($_POST['id_compra'])) {
        die('Error: No se recibió ningún ID de venta.');
    }

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM compras WHERE id_compra = :id_compra";
        $stmt = $con->prepare($sql);
        
        $stmt->bindParam(':id_compra', $_POST['id_compra']);
        
        if ($stmt->execute()) {
            // CORRECCIÓN: Mensaje de éxito
            echo "Datos eliminados correctamente en la base de datos.";
        } else {
            echo "Error al eliminar los datos en la base de datos.";
        }
        
    } catch(PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
?>