<?php
    $server = 'localhost:3306'; $username = 'root'; $password = ''; $database ='sistemainventario';
    header('Content-Type: application/json');

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $por_pagina = 10; 
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $busqueda = $_GET['busqueda'] ?? ''; 
        
        if ($pagina < 1) $pagina = 1;
        $inicio = ($pagina - 1) * $por_pagina;

        // CORREGIDO: Tabla provedores y FK Provedores_id_provedores
        $sql = "SELECT cp.id_compras, cp.Provedores_id_provedores as id_proveedor, p.nombre as nombre_proveedor, 
                       cp.iva, cp.total, cp.fecha, (cp.total - cp.iva) as subtotal
                FROM compras cp 
                JOIN provedores p ON cp.Provedores_id_provedores = p.id_provedores ";
        
        if($busqueda != ''){
            $sql .= " WHERE cp.id_compras LIKE :busqueda OR p.nombre LIKE :busqueda ";
        }

        $sql .= " ORDER BY cp.id_compras DESC LIMIT :inicio, :por_pagina";

        $stmt = $con->prepare($sql);
        $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindValue(':por_pagina', $por_pagina, PDO::PARAM_INT);
        
        if($busqueda != '') {
            $stmt->bindValue(':busqueda', "%$busqueda%");
        }
        
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

    } catch(Exception $e) { echo json_encode(['error' => $e->getMessage()]); }
?>