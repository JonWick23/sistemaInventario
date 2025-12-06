<?php
    $server = 'localhost:3306'; $username = 'root'; $password = ''; $database ='sistemainventario';
    header('Content-Type: application/json');

    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Recibir variables de JS
        $por_pagina = 10; 
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $busqueda = $_GET['busqueda'] ?? '';
        
        if ($pagina < 1) $pagina = 1;
        $inicio = ($pagina - 1) * $por_pagina;

        //Construir la consulta BASE
        $sql = "SELECT v.id_ventas, v.Clientes_id_clientes as id_cliente, c.nombre as nombre_cliente, 
                       v.iva, v.total, v.fecha_venta, (v.total - v.iva) as subtotal
                FROM ventas v 
                JOIN clientes c ON v.Clientes_id_clientes = c.id_clientes ";
        
        // BUSCADOR
        if($busqueda != ''){
            $sql .= " WHERE v.id_ventas LIKE :busqueda OR c.nombre LIKE :busqueda ";
        }

        $sql .= " ORDER BY v.id_ventas DESC LIMIT :inicio, :por_pagina";

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