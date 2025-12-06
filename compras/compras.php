<?php
    include ("menu.php");

    $server = 'localhost:3306'; $username = 'root'; $password = ''; $database ='sistemainventario';
    try {
        $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) { die("Error: " . $e->getMessage()); }

    //
    $busqueda = $_GET['buscar'] ?? ''; 
    $por_pagina = 10; 
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    if ($pagina < 1) $pagina = 1;
    $inicio = ($pagina - 1) * $por_pagina;

    $filtro = "";
    if($busqueda != ''){
        $filtro = " WHERE cp.id_compras LIKE :busqueda OR p.nombre LIKE :busqueda ";
    }

    // --- 3. CONSULTAS GLOBALES (TOTALES) ---
    
    // A. Total Registros Globales
    $sql_global_count = "SELECT COUNT(*) FROM compras";
    $stmt_gc = $con->query($sql_global_count);
    $total_global_registros = $stmt_gc->fetchColumn();

    // B. Total Unidades Globales (CORREGIDO: productos_compras y cantidad_pd_cp)
    $sql_global_units = "SELECT SUM(cantidad_pd_cp) FROM productos_compras";
    $stmt_gu = $con->query($sql_global_units);
    $total_global_unidades = $stmt_gu->fetchColumn() ?: 0;

    // C. Monto Total Global
    $sql_global_money = "SELECT SUM(total) FROM compras";
    $stmt_gm = $con->query($sql_global_money);
    $total_global_ingresos = $stmt_gm->fetchColumn() ?: 0;

    // D. Promedio Global
    $promedio_global = ($total_global_registros > 0) ? ($total_global_ingresos / $total_global_registros) : 0;


    // --- 4. CONSULTAS FILTRADAS (TABLA) ---
    
    // A. Contar filtrados
    $stmt_cf = $con->prepare("SELECT COUNT(*) FROM compras cp JOIN provedores p ON cp.Provedores_id_provedores = p.id_provedores $filtro");
    if($busqueda != '') $stmt_cf->bindValue(':busqueda', "%$busqueda%");
    $stmt_cf->execute();
    $total_registros_filtrados = $stmt_cf->fetchColumn();
    
    $total_paginas = ceil($total_registros_filtrados / $por_pagina) ?: 1;

    // B. Obtener datos filtrados
    $sql_data = "SELECT cp.id_compras, p.nombre as nombre_proveedor, cp.Provedores_id_provedores as id_proveedor,
                        cp.iva, cp.total, cp.fecha, 
                        (cp.total - cp.iva) as subtotal 
                 FROM compras cp 
                 JOIN provedores p ON cp.Provedores_id_provedores = p.id_provedores
                 $filtro 
                 ORDER BY cp.id_compras DESC 
                 LIMIT :inicio, :por_pagina";
    
    $stmt = $con->prepare($sql_data);
    $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
    $stmt->bindValue(':por_pagina', $por_pagina, PDO::PARAM_INT);
    if($busqueda != '') $stmt->bindValue(':busqueda', "%$busqueda%");
    $stmt->execute();
    $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compras</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="compras.css"> <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    
    <script>
        const PAGINA_ACTUAL = <?php echo $pagina; ?>;
        const BUSQUEDA_ACTUAL = "<?php echo $busqueda; ?>";
    </script>
</head>
<body>
    <div class="scroll"></div>

    <div class="informacion">
        <div class="cuadro1">
            <span class="icono-producto"><i class="fas fa-box"></i></span>
            <h2>Total de Compras</h2>
            <p><?php echo $total_global_registros; ?></p>
            <p><?php echo $total_global_unidades; ?> unidades compradas</p>
        </div>
        <div class="cuadro2">
            <span class="icono-dolar">$</span>
            <h2>Monto total</h2>
            <p>$<?php echo number_format($total_global_ingresos, 2); ?></p>
            <p>Valor total estimado</p>
        </div>
        <div class="cuadro3">
            <span class="icono-dolar"><i class="fas fa-chart-line"></i></span>
            <h2>Promedio</h2>
            <p>$<?php echo number_format($promedio_global, 2); ?></p>
            <p>Promedio por compra</p>
        </div>
    </div>

        <div><button id="btnAbrirFormulario">+ NUEVA COMPRA</button></div>

        <form action="compras.php" method="GET" class="buscar">
            <div class="input-box">
                <i class="fa-solid fa-magnifying-glass" style="padding:0 10px; color:#555;"></i>
                <input type="text" name="buscar" placeholder="Buscar proveedor o ID de compra..." value="<?php echo $busqueda; ?>">
                <button type="submit" class="btnBuscar">Buscar</button>
                <?php if($busqueda != ''): ?>
                    <a href="compras.php" class="eliminar">X</a>
                <?php endif; ?>
            </div>
        </form>


    <div id="modalOverlay" class="modal-overlay">
        <form id="formularioCompras"> 
            <span id="btnCerrarModal" class="cerrar-modal">&times;</span>
            
            <div class="campo"><label>PROVEEDOR:</label> <select id="nombre_proveedor" required></select></div>
            <div class="campo"><label>FECHA:</label> <input type="date" id="fecha_venta" name="fecha_venta" required></div>
            <div class="campo"><label>IVA:</label> <input type="number" id="iva" name="iva" step="0.01" value="0.16" readonly></div>
            <div class="campo"><label>ARTÍCULO:</label> <select id="nom_articulo"></select></div>
            <div class="campo"><label>CANTIDAD:</label> <input type="number" id="cantidad" name="cantidad" value="1"></div>
            <input type="hidden" id="pre_unitario">

            <button type="button" id="btnAnadirProducto" class="btn-anadir">Añadir Producto</button>
            <div class="table-container-modal">
                <table>
                    <thead>
                        <tr>
                            <th>ART</th>
                            <th>CANT</th>
                            <th>PRECIO</th>
                            <th>SUB</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody id="carritoBody"></tbody>
                </table>
            </div>
            <input type="submit" value="REGISTRAR COMPRA">
        </form>
    </div>

    <div class="table-container" id="tabla1">
        <table>
            <thead>
                <tr>
                    <th>ID COMPRA</th>
                    <th>ID PROVEEDOR</th>
                    <th>NOMBRE PROVEEDOR</th>
                    <th>SUBTOTAL</th>
                    <th>IVA</th>
                    <th>TOTAL</th>
                    <th>FECHA COMPRA</th>
                    <th class="acciones">ACCIONES</th>
                </tr>
            </thead>
            <tbody id="tablaCompraBody">
                <?php if(count($compras) > 0): ?>
                    <?php foreach($compras as $c): ?>
                        <tr>
                            <td><?php echo $c['id_compras']; ?></td>
                            <td><?php echo $c['id_proveedor']; ?></td>
                            <td><?php echo $c['nombre_proveedor']; ?></td>
                            <td>$<?php echo number_format($c['subtotal'] ?? 0, 2); ?></td>
                            <td>$<?php echo number_format($c['iva'], 2); ?></td>
                            <td>$<?php echo number_format($c['total'], 2); ?></td>
                            <td><?php echo $c['fecha']; ?></td>
                            <td class="celda-acciones">
                                <button class="btn-modificar" data-id="<?php echo $c['id_compras']; ?>"><i class="fas fa-pen"></i></button>
                                <button class="btn-eliminar" data-id="<?php echo $c['id_compras']; ?>"><i class="fas fa-trash-alt"></i></button>
                                <a href="ticket.php?id=<?php echo $c['id_compras']; ?>" target="_blank" class="btn-pdf" >
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" style="text-align:center; padding:20px;">No se encontraron resultados</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if (empty($busqueda) && isset($total_paginas)): ?>
            <div class="paginacion">
                <?php $link = "?buscar=$busqueda&pagina="; ?>
                <?php if ($pagina > 1): ?><a href="<?php echo $link . ($pagina - 1); ?>">&laquo; Anterior</a><?php endif; ?>
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <a href="<?php echo $link . $i; ?>" class="<?php echo $i == $pagina ? 'activo' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($pagina < $total_paginas): ?><a href="<?php echo $link . ($pagina + 1); ?>">Siguiente &raquo;</a><?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <button id="descargarPDF">DESCARGAR PDF</button> 
    
    <div class="scroll"></div> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="g.js"></script>
    <script src="comm.js"></script> 
    <script>
        if(document.getElementById('descargarPDF')){
            document.getElementById('descargarPDF').addEventListener('click', generarPDF);
        }
    </script>
</body>
</html>