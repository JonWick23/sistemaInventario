<?php
    $server = 'localhost:3306'; $username = 'root'; $password = ''; $database ='sistemainventario';
    header('Content-Type: application/json');

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $json = json_decode(file_get_contents('php://input'), true); 
        $id_compra = $json['id_venta'] ?? null; 
        $productos = $json['productos'];
        $proveedor_nom = $json['nombre_proveedor'] ?? $json['nombre_cliente']; 
        $fecha = $json['fecha_venta']; 

        if (empty($productos) || empty($id_compra)) { echo json_encode(["error" => "Faltan datos."]); exit; }

        // Obtener ID Proveedor
        $stmt = $con->prepare("SELECT id_provedores FROM provedores WHERE nombre = :n");
        $stmt->execute([':n' => $proveedor_nom]);
        $id_prov = $stmt->fetchColumn();
        if (!$id_prov) { echo json_encode(["error" => "Proveedor no existe."]); exit; }

        // Totales
        $subtotal = 0;
        foreach ($productos as $p) $subtotal += $p['precio'] * $p['cantidad'];
        $iva = $subtotal * 0.16; $total = $subtotal + $iva;

        $con->beginTransaction();

        // --- 1. RESTAURAR STOCK (Restar lo que había antes) ---
        // Buscamos qué había guardado antes de borrarlo
        $stmt_old = $con->prepare("SELECT Productos_id_productos, cantidad_pd_cp FROM productos_compras WHERE Compras_id_compras = :id");
        $stmt_old->execute([':id' => $id_compra]);
        $old_products = $stmt_old->fetchAll(PDO::FETCH_ASSOC);

        $stmt_restar = $con->prepare("UPDATE productos SET cantidad = cantidad - :cant WHERE id_productos = :id");
        foreach($old_products as $old) {
            $stmt_restar->execute([':cant' => $old['cantidad_pd_cp'], ':id' => $old['Productos_id_productos']]);
        }

        // --- 2. BORRAR DETALLES VIEJOS ---
        $con->prepare("DELETE FROM productos_compras WHERE Compras_id_compras = ?")->execute([$id_compra]);
        
        // --- 3. ACTUALIZAR CABECERA ---
        $sql_up = "UPDATE compras SET Provedores_id_provedores=?, iva=?, total=?, fecha=? WHERE id_compras=?";
        $con->prepare($sql_up)->execute([$id_prov, $iva, $total, $fecha, $id_compra]);

        // --- 4. INSERTAR NUEVOS Y SUMAR STOCK ---
        $sql_in = "INSERT INTO productos_compras (Compras_id_compras, Productos_id_productos, cantidad_pd_cp, precio_pd_cp, subtotal) VALUES (?, ?, ?, ?, ?)";
        $stmt_in = $con->prepare($sql_in);
        
        $sql_sumar = "UPDATE productos SET cantidad = cantidad + :cant WHERE id_productos = :id";
        $stmt_sumar = $con->prepare($sql_sumar);

        foreach ($productos as $p) {
            $sub = $p['cantidad'] * $p['precio'];
            // Insertar
            $stmt_in->execute([$id_compra, $p['id_articulo'], $p['cantidad'], $p['precio'], $sub]);
            
            // Sumar Stock
            $stmt_sumar->execute([':cant' => $p['cantidad'], ':id' => $p['id_articulo']]);
        }

        $con->commit();
        echo json_encode(["status" => "success", "mensaje" => "Compra actualizada y stock ajustado."]);

    } catch (Exception $e) {
        if($con->inTransaction()) $con->rollBack();
        echo json_encode(["error" => "Error: " . $e->getMessage()]);
    }
?>