<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
    header("location: index.php");
}

include("conexion.php");
$conexion = conectar();

// ===== PAGINADO =====
$por_pagina = 10; // cantidad de registros por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $por_pagina;

// Total de registros
$total_query = mysqli_query($conexion, "SELECT COUNT(*) as total FROM Productos");
$total_row = mysqli_fetch_assoc($total_query);
$total_registros = $total_row['total'];
$total_paginas = ceil($total_registros / $por_pagina);

// Consulta con límite
$sql = "SELECT * FROM Productos LIMIT $inicio, $por_pagina";
$query = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/inventario.png">
    <link rel="stylesheet" href="css/style1.css">
    <script src="https://kit.fontawesome.com/d2fef19485.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php 
    include("menu.php");
    ?>

    <div class="scroll"></div>

    <!-- CUADROS DE INFORMACIÓN -->
    <div class="informacion">
        <div class="cuadro1">
            <span class="icono-producto"><i class="fas fa-box"></i></span>
            <h2>Total de Productos</h2>
            <p><?php echo $total_registros; ?></p>
        </div>

        <div class="cuadro2">
            <span class="icono-dolar"><i class="fas fa-dollar-sign"></i></span>
            <h2>Valor del inventario <br>a precio de compra</h2>
            <p>
                <?php 
                    $total = mysqli_query($conexion, "SELECT SUM(precio_compra * cantidad) AS totalCompra FROM Productos");
                    $t = mysqli_fetch_assoc($total);
                    echo "$" . number_format($t['totalCompra'], 2);
                ?>
            </p>
        </div>

        <div class="cuadro3">
            <h2>Valor del inventario a precio de venta</h2>
            <p>
                <?php 
                    $total = mysqli_query($conexion, "SELECT SUM(precio_venta * cantidad) AS totalVenta FROM Productos");
                    $t = mysqli_fetch_assoc($total);
                    echo "$" . number_format($t['totalVenta'], 2);
                ?>
            </p>
        </div>
    </div>

    <button id="btnAbrirFormulario">+ NUEVO PRODUCTO</button>
    <!-- FORMULARIO (MODAL) -->
    <div id="modalOverlay" class="modal-overlay">
        <form action="insertar.php" method="POST" id="formularioVenta">
            <span id="btnCerrarModal" class="cerrar-modal">&times;</span>

            <div class="campo">
                <label for="codigo_articulo">CÓDIGO DEL ARTÍCULO:</label>
                <input type="text" name="codigo_articulo" id="codigo_articulo" required>
            </div>
            <div class="campo">
                <label for="nombre">NOMBRE:</label>
                <input type="text" name="nombre" id="nombre" required>
            </div>
            <div class="campo">
                <label for="categoria">CATEGORÍA:</label>
                <input type="text" name="categoria" id="categoria" required>
            </div>
            <div class="campo">
                <label for="cantidad">CANTIDAD:</label>
                <input type="number" name="cantidad" id="cantidad" required>
            </div>
            <div class="campo">
                <label for="precio_compra">PRECIO COMPRA:</label>
                <input type="number" name="precio_compra" id="precio_compra" required>
            </div>
            <div class="campo">
                <label for="precio_venta">PRECIO VENTA:</label>
                <input type="number" name="precio_venta" id="precio_venta" required>
            </div>
            <div class="campo">
                <label for="proveedor">PROVEEDOR:</label>
                <input type="text" name="proveedor" id="proveedor" required>
            </div>
            <div class="campo">
                <label for="fecha_ingreso">FECHA INGRESO:</label>
                <input type="date" name="fecha_ingreso" id="fecha_ingreso" required>
            </div>
            <div class="campo">
                <label for="ubicacion">UBICACIÓN:</label>
                <input type="text" name="ubicacion" id="ubicacion" required>
            </div>
            <div class="campo">
                <label for="estado">ESTADO:</label>
                <select name="estado" id="estado" required>
                    <option value="Disponible">Disponible</option>
                    <option value="Agotado">Agotado</option>
                    <option value="Baja">Baja</option>
                </select>
            </div>

            <input type="submit" value="GUARDAR PRODUCTO">
        </form>
    </div>
    
    <!-- TABLA DE PRODUCTOS -->
    <div class="table-container">
        <table class="miTabla">
            <br>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                    <th>Precio compra</th>
                    <th>Precio venta</th>
                    <th>Proveedor</th>
                    <th>Ingreso</th>
                    <th>Ubicación</th>
                    <th>Estado</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $subtotal_compra = 0;
                    $subtotal_venta  = 0;

                    while ($row = mysqli_fetch_array($query)) {
                        $subtotal_compra += $row['precio_compra'] * $row['cantidad'];
                        $subtotal_venta  += $row['precio_venta'] * $row['cantidad'];
                ?>
                    <tr>
                        <td><?php echo $row['id_productos']; ?></td>
                        <td><?php echo $row['codigo_articulo']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['categoria']; ?></td>
                        <td><?php echo $row['cantidad']; ?></td>
                        <td>$<?php echo number_format($row['precio_compra'], 2); ?></td>
                        <td>$<?php echo number_format($row['precio_venta'], 2); ?></td>
                        <td><?php echo $row['proveedor']; ?></td>
                        <td><?php echo $row['fecha_ingreso']; ?></td>
                        <td><?php echo $row['ubicacion']; ?></td>
                        <td><?php echo $row['estado']; ?></td>
                        <td><a href="actualizar.php?id=<?php echo $row['id_productos']; ?>" class="btn-modificar"><i class="fa-solid fa-pen-to-square"></i></a></td>
                        <td><a href="delete.php?id=<?php echo $row['id_productos']; ?>" class="btn-eliminar"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>

            <tfoot>
                <tr>
                    <th>Subtotal</th>
                    <th colspan="4"></th>
                    <th>$<?php echo number_format($subtotal_compra, 2); ?></th>
                    <th>$<?php echo number_format($subtotal_venta, 2); ?></th>
                    <th colspan="6"></th>
                </tr>
            </tfoot>
        </table>

        <!-- PAGINACIÓN -->
        <div class="paginacion">
            <?php if ($pagina > 1): ?>
                <a href="?pagina=<?php echo $pagina - 1; ?>">&laquo; Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <a href="?pagina=<?php echo $i; ?>" class="<?php echo $i == $pagina ? 'activo' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($pagina < $total_paginas): ?>
                <a href="?pagina=<?php echo $pagina + 1; ?>">Siguiente &raquo;</a>
            <?php endif; ?>
        </div>
    </div>

    <script src="js/tabla.js"></script>
    <script src="js/maxNumeros.js"></script>
    <script src="js/modalOver.js"></script>
</body>
</html>
