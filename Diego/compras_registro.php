<?php
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='ventas';

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sql = "INSERT INTO compras VALUES (:id_compra, :id_articulo, :id_proveedor, :nom_articulo, :cantidad, :pre_unitario, :total, :fecha_compra)";
            $stmt = $con->prepare($sql);

            
            
            $stmt->bindParam(':id_compra', $_POST['id_compra']);
            $stmt->bindParam(':id_articulo', $_POST['id_articulo']);
            $stmt->bindParam(':id_proveedor', $_POST['id_proveedor']);
            $stmt->bindParam(':nom_articulo', $_POST['nom_articulo']);
            $stmt->bindParam(':cantidad', $_POST['cantidad']);
            $stmt->bindParam(':pre_unitario', $_POST['pre_unitario']);
            $stmt->bindParam(':total', $_POST['total']);
            $stmt->bindParam(':fecha_compra', $_POST['fecha_compra']);
            
            if ($stmt->execute()) {
                echo "Datos almacenados correctamente en la base de datos.";
            } else {
                echo "Error al almacenar los datos en la base de datos.";
            }
        }
    } catch(PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
?>