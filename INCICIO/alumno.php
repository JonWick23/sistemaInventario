<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
    header("location: index.php");
}

include("control/conexion.php");
$conexion = conectar();

// ===== PAGINADO =====
$por_pagina = 10; 
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

    <?php include("menu.php"); ?>

    <div class="scroll"></div>

    <!-- CUADROS DE INFORMACIÓN -->
    <div class="informacion">

        <div class="cuadro1">
            <span class="icono-producto"><i class="fas fa-box"></i></span>
            <h2>Total de Productos<br> en el inventario</h2>
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

    <!-- BOTÓN NUEVO PRODUCTO -->
    <button id="btnAbrirFormulario">+ NUEVO PRODUCTO</button>

    <!-- FORMULARIO (MODAL) -->
    <div id="modalOverlay" class="modal-overlay">
        <form action="control/insertar.php" method="POST" id="formularioVenta">
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

    <!-- BUSCADOR -->
    <form action="" method="POST">
        <div class="input-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="buscar" placeholder="Buscar producto por código, nombre o categoría">
            <button type="submit" class="btnBuscar">Buscar</button>
        </div>
    </form>

    <?php
        if (!empty($_POST['buscar'])) {
            $buscar = $_POST['buscar'];

            $sql = "SELECT * FROM Productos 
                    WHERE codigo_articulo LIKE '%$buscar%' 
                    OR nombre LIKE '%$buscar%' 
                    OR categoria LIKE '%$buscar%'";

            $query = mysqli_query($conexion, $sql);

        } else {
            $sql = "SELECT * FROM Productos LIMIT $inicio, $por_pagina";
            $query = mysqli_query($conexion, $sql);
        }
    ?>

    <!-- TABLA DE PRODUCTOS -->
    <div class="table-container">

        <table>
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

                    <!-- BOTÓN MODIFICAR -->
                    <td>
                        <button class="btn-modificar" onclick="abrirEditar(
                            '<?php echo $row['id_productos']; ?>',
                            '<?php echo $row['codigo_articulo']; ?>',
                            '<?php echo $row['nombre']; ?>',
                            '<?php echo $row['categoria']; ?>',
                            '<?php echo $row['cantidad']; ?>',
                            '<?php echo $row['precio_compra']; ?>',
                            '<?php echo $row['precio_venta']; ?>',
                            '<?php echo $row['proveedor']; ?>',
                            '<?php echo $row['fecha_ingreso']; ?>',
                            '<?php echo $row['ubicacion']; ?>',
                            '<?php echo $row['estado']; ?>'
                        )">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>

                    <!-- BOTÓN ELIMINAR -->
                    <td>
                        <button class="btn-eliminar"
                            onclick="if (confirm('¿Seguro que deseas eliminar?')) { 
                                window.location.href='control/delete.php?id=<?php echo $row['id_productos']; ?>';
                            }">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <?php } ?>

                <!-- MODAL EDITAR -->
                <div id="modalEditar" class="modal-overlay">
                    <form action="update.php" method="POST" id="formularioVenta">
                        <span id="btnCerrarEditar" class="cerrar-modal">&times;</span>

                        <input type="hidden" name="id_productos" id="edit_id">

                        <label>Código:</label>
                        <input type="text" name="codigo_articulo" id="edit_codigo" required>

                        <label>Nombre:</label>
                        <input type="text" name="nombre" id="edit_nombre" required>

                        <label>Categoría:</label>
                        <input type="text" name="categoria" id="edit_categoria" required>

                        <label>Cantidad:</label>
                        <input type="number" name="cantidad" id="edit_cantidad" required>

                        <label>Precio Compra:</label>
                        <input type="number" name="precio_compra" id="edit_precio_compra" required>

                        <label>Precio Venta:</label>
                        <input type="number" name="precio_venta" id="edit_precio_venta" required>

                        <label>Proveedor:</label>
                        <input type="text" name="proveedor" id="edit_proveedor" required>

                        <label>Fecha Ingreso:</label>
                        <input type="date" name="fecha_ingreso" id="edit_fecha" required>

                        <label>Ubicación:</label>
                        <input type="text" name="ubicacion" id="edit_ubicacion" required>

                        <label>Estado:</label>
                        <select name="estado" id="edit_estado">
                            <option value="Disponible">Disponible</option>
                            <option value="Agotado">Agotado</option>
                            <option value="Baja">Baja</option>
                        </select>

                        <button type="submit">Actualizar</button>
                    </form>
                </div>

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

    <!-- ALERTA -->
    <?php if (isset($_GET['msg'])): ?>
        <div id="toast" class="toast <?php echo $_GET['msg']; ?>">
            <?php echo $_GET['msg'] == 'exito' ? 'Producto eliminado exitosamente' : 'Error al eliminar el producto'; ?>
        </div>
    <?php endif; ?>

    <!-- JS -->
    <script src="js/toast.js"></script>
    <script src="js/maxNumeros.js"></script>
    <script src="js/modalOvar.js"></script>

</body>
</html>
