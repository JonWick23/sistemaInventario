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
            $sql = "UPDATE compras SET 
                        id_articulo = :id_articulo, 
                        id_proveedor = :id_proveedor, 
                        nombre_articulo = :nom_articulo, 
                        cantidad = :cantidad, 
                        precio_unitario = :precio_unitario, 
                        total = :total, 
                        fecha_compra = :fecha_compra
                    WHERE 
                        id_compra = :id_compra"; // El ID solo va en el WHERE
            
            $stmt = $con->prepare($sql);

            // 2. Los parámetros se enlazan (bindParam)
            $stmt->bindParam(':id_compra', $_POST['id_compra']);
            $stmt->bindParam(':id_articulo', $_POST['id_articulo']);
            $stmt->bindParam(':id_proveedor', $_POST['id_proveedor']);
            $stmt->bindParam(':nom_articulo', $_POST['nom_articulo']);
            $stmt->bindParam(':cantidad', $_POST['cantidad']);
            $stmt->bindParam(':precio_unitario', $_POST['precio_unitario']);
            $stmt->bindParam(':total', $_POST['total']);
            $stmt->bindParam(':fecha_compra', $_POST['fecha_compra']);
            
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