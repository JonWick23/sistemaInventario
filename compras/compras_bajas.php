<?php
    $server = 'localhost:3306'; $username = 'root'; $password = ''; $database ='sistemainventario';

    $id_para_borrar = $_POST['id_compra'] ?? $_POST['id_venta'] ?? null;
    if (!$id_para_borrar) die('Error: No se recibió ID.');

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->beginTransaction();

        // --- PASO 1: RECUPERAR PRODUCTOS ANTES DE BORRAR ---
        // Necesitamos saber qué productos y qué cantidad había para restarlos
        $sql_select = "SELECT Productos_id_productos, cantidad_pd_cp FROM productos_compras WHERE Compras_id_compras = :id";
        $stmt_select = $con->prepare($sql_select);
        $stmt_select->bindParam(':id', $id_para_borrar);
        $stmt_select->execute();
        $productos_a_devolver = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

        // --- PASO 2: RESTAR STOCK (Devolver el inventario atrás) ---
        $sql_update = "UPDATE productos SET cantidad = cantidad - :cant WHERE id_productos = :id";
        $stmt_update = $con->prepare($sql_update);

        foreach($productos_a_devolver as $prod) {
            $stmt_update->bindValue(':cant', $prod['cantidad_pd_cp']);
            $stmt_update->bindValue(':id', $prod['Productos_id_productos']);
            $stmt_update->execute();
        }

        // --- PASO 3: BORRAR LOS DETALLES ---
        $sql_cp = "DELETE FROM productos_compras WHERE Compras_id_compras = :id";
        $stmt_cp = $con->prepare($sql_cp);
        $stmt_cp->bindParam(':id', $id_para_borrar);
        $stmt_cp->execute();

        // --- PASO 4: BORRAR LA CABECERA ---
        $sql_c = "DELETE FROM compras WHERE id_compras = :id";
        $stmt_c = $con->prepare($sql_c); 
        $stmt_c->bindParam(':id', $id_para_borrar);
        $stmt_c->execute();

        $con->commit();
        echo "Compra eliminada y stock actualizado correctamente.";

    } catch(PDOException $e) {
        $con->rollBack();
        die('Error: ' . $e->getMessage());
    }
?>