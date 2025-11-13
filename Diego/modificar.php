<?php
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='ventas';

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // --- CORRECCIÓN ---
            // 1. Se elimina "id_venta = :id_venta" de la cláusula SET.
            $sql = "UPDATE ventas SET 
                        id_articulo = :id_articulo, 
                        id_cliente = :id_cliente, 
                        nombre_articulo = :nom_articulo, 
                        cantidad = :cantidad, 
                        precio_unitario = :pre_unitario, 
                        total = :total, 
                        fecha_venta = :fecha_venta 
                    WHERE 
                        id_venta = :id_venta"; // El ID solo va en el WHERE
            
            $stmt = $con->prepare($sql);

            // 2. Los parámetros se enlazan (bindParam)
            $stmt->bindParam(':id_venta', $_POST['id_venta']);
            $stmt->bindParam(':id_articulo', $_POST['id_articulo']);
            $stmt->bindParam(':id_cliente', $_POST['id_cliente']);
            $stmt->bindParam(':nom_articulo', $_POST['nom_articulo']);
            $stmt->bindParam(':cantidad', $_POST['cantidad']);
            $stmt->bindParam(':pre_unitario', $_POST['pre_unitario']);
            $stmt->bindParam(':total', $_POST['total']);
            $stmt->bindParam(':fecha_venta', $_POST['fecha_venta']);
            
            if ($stmt->execute()) {
                echo "Datos actualizados correctamente.";
            } else {
                echo "Error al actualizar los datos.";
            }
        }
    } catch(PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
?>