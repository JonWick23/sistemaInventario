<?php
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='sistemainventario'; // Tu BD en minúsculas

    // 1. Asegurarse de que se envió un id_venta
    if (!isset($_POST['id_venta'])) {
        die('Error: No se recibió ningún ID de venta.');
    }

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 2. INICIAR TRANSACCIÓN
        $con->beginTransaction();

        $id_venta = $_POST['id_venta'];

        // 3. ELIMINAR PRIMERO DE LA TABLA HIJO (ventas_productos)
        $sql_vp = "DELETE FROM ventas_productos WHERE Ventas_id_ventas = :id_venta";
        $stmt_vp = $con->prepare($sql_vp);
        $stmt_vp->bindParam(':id_venta', $id_venta);
        $stmt_vp->execute();

        // 4. ELIMINAR DESPUÉS DE LA TABLA PADRE (ventas)
        $sql_v = "DELETE FROM ventas WHERE id_ventas = :id_venta";
        $stmt_v = $con->prepare($sql_v); 
        $stmt_v->bindParam(':id_venta', $id_venta);
        $stmt_v->execute();

        // 5. CONFIRMAR TRANSACCIÓN
        $con->commit();
        
        echo "Venta eliminada correctamente.";

    } catch(PDOException $e) {
        // 6. REVERTIR TRANSACCIÓN (Si algo falló)
        $con->rollBack();
        die('Error al eliminar: ' . $e->getMessage());
    }
?>