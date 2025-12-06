<?php
    $server = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database ='sistemainventario';

    // 1. Validar ID
    if (!isset($_POST['id_venta'])) {
        die('Error: No se recibió ningún ID de venta.');
    }

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 2. INICIAR TRANSACCIÓN
        $con->beginTransaction();

        $id_venta = $_POST['id_venta'];

        // --- PASO A: RECUPERAR PRODUCTOS ANTES DE BORRAR ---
        // Necesitamos saber qué se vendió para devolverlo al estante
        $sql_select = "SELECT Productos_id_productos, cantidad FROM ventas_productos WHERE Ventas_id_ventas = :id";
        $stmt_select = $con->prepare($sql_select);
        $stmt_select->bindParam(':id', $id_venta);
        $stmt_select->execute();
        $productos_devueltos = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

        // --- PASO B: AUMENTAR STOCK (Devolución) ---
        $sql_stock = "UPDATE productos SET cantidad = cantidad + :cant WHERE id_productos = :id";
        $stmt_stock = $con->prepare($sql_stock);

        foreach($productos_devueltos as $prod) {
            $stmt_stock->bindValue(':cant', $prod['cantidad']);
            $stmt_stock->bindValue(':id', $prod['Productos_id_productos']);
            $stmt_stock->execute();
        }

        // --- PASO C: ELIMINAR DE LA TABLA HIJO ---
        $sql_vp = "DELETE FROM ventas_productos WHERE Ventas_id_ventas = :id";
        $stmt_vp = $con->prepare($sql_vp);
        $stmt_vp->bindParam(':id', $id_venta);
        $stmt_vp->execute();

        // --- PASO D: ELIMINAR DE LA TABLA PADRE ---
        $sql_v = "DELETE FROM ventas WHERE id_ventas = :id";
        $stmt_v = $con->prepare($sql_v); 
        $stmt_v->bindParam(':id', $id_venta);
        $stmt_v->execute();

        // 5. CONFIRMAR TRANSACCIÓN
        $con->commit();
        
        echo "Venta eliminada y stock restaurado correctamente.";

    } catch(PDOException $e) {
        // 6. REVERTIR TRANSACCIÓN
        $con->rollBack();
        die('Error al eliminar: ' . $e->getMessage());
    }
?>