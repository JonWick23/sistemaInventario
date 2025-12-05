<?php
session_start();
if (empty($_SESSION['nombre']) && empty($_SESSION['apellido'])) {
    header("location: index.php");
}

include("control/conexion.php");
$conexion = conectar();

// ===== PAGINADO =====
$por_pagina = 10;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $por_pagina;

// ===== BUSCADOR =====
$buscar = "";
$condicion = "";

if (!empty($_POST['buscar'])) {
    $buscar = mysqli_real_escape_string($conexion, $_POST['buscar']);
    $condicion = "WHERE codigo_articulo LIKE '%$buscar%' 
                  OR nombre LIKE '%$buscar%' 
                  OR categoria LIKE '%$buscar%'";
}

// Total registros
$total_query = mysqli_query($conexion, "SELECT COUNT(*) AS total FROM Productos $condicion");
$total_row = mysqli_fetch_assoc($total_query);
$total_registros = $total_row['total'];

$total_paginas = ceil($total_registros / $por_pagina);

// Consulta con límite
$sql = "SELECT * FROM Productos $condicion LIMIT $inicio, $por_pagina";
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

                    // Subtotales
                    $subtotal_compra += $row['precio_compra'] * $row['cantidad'];
                    $subtotal_venta  += $row['precio_venta'] * $row['cantidad'];
                ?>
                <tr>
                    <td><?= $row['id_productos'] ?></td>
                    <td><?= $row['codigo_articulo'] ?></td>
                    <td><?= $row['nombre'] ?></td>
                    <td><?= $row['categoria'] ?></td>
                    <td><?= $row['cantidad'] ?></td>
                    <td>$<?= number_format($row['precio_compra'], 2) ?></td>
                    <td>$<?= number_format($row['precio_venta'], 2) ?></td>
                    <td><?= $row['proveedor'] ?></td>
                    <td><?= $row['fecha_ingreso'] ?></td>
                    <td><?= $row['ubicacion'] ?></td>
                    <td><?= $row['estado'] ?></td>

                    <!-- BOTÓN MODIFICAR -->
                    <td>
                        <button class="btn-modificar" 
                        onclick="abrirEditar(
                            '<?= htmlspecialchars($row['id_productos'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['codigo_articulo'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['nombre'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['categoria'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['cantidad'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['precio_compra'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['precio_venta'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['proveedor'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['fecha_ingreso'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['ubicacion'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['estado'], ENT_QUOTES) ?>'
                        )">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>

                    <!-- BOTÓN ELIMINAR -->
                    <td>
                        <button class="btn-eliminar"
                            onclick="if (confirm('¿Seguro que deseas eliminar?')) { 
                                window.location.href='control/delete.php?id=<?= $row['id_productos'] ?>';
                            }">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <?php } ?>
            </tbody>

            <tfoot>
                <tr>
                    <th>Subtotal</th>
                    <th colspan="4"></th>
                    <th>$<?= number_format($subtotal_compra, 2) ?></th>
                    <th>$<?= number_format($subtotal_venta, 2) ?></th>
                    <th colspan="6"></th>
                </tr>
            </tfoot>
        </table>

        <!-- PAGINACIÓN -->
        <div class="paginacion">
            <?php if ($pagina > 1): ?>
                <a href="?pagina=<?= $pagina - 1 ?>">&laquo; Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <a href="?pagina=<?= $i ?>" class="<?= $i == $pagina ? 'activo' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($pagina < $total_paginas): ?>
                <a href="?pagina=<?= $pagina + 1 ?>">Siguiente &raquo;</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- MODAL EDITAR PRODUCTO -->
<div id="modalEditar" class="modal-overlay">
    <form action="control/update.php" method="POST" id="formularioEditar" class="modal-content">
        <span id="btnCerrarEditar" class="cerrar-modal">&times;</span>

        <h2 class="titulo-modal">EDITAR PRODUCTO</h2>

        <input type="hidden" name="id_productos" id="edit_id">

        <div class="campo">
            <label for="edit_codigo">CÓDIGO DEL ARTÍCULO:</label>
            <input type="text" name="codigo_articulo" id="edit_codigo" required>
        </div>

        <div class="campo">
            <label for="edit_nombre">NOMBRE:</label>
            <input type="text" name="nombre" id="edit_nombre" required>
        </div>

        <div class="campo">
            <label for="edit_categoria">CATEGORÍA:</label>
            <input type="text" name="categoria" id="edit_categoria" required>
        </div>

        <div class="campo">
            <label for="edit_cantidad">CANTIDAD:</label>
            <input type="number" name="cantidad" id="edit_cantidad" required>
        </div>

        <div class="campo">
            <label for="edit_precio_compra">PRECIO COMPRA:</label>
            <input type="number" name="precio_compra" id="edit_precio_compra" required>
        </div>

        <div class="campo">
            <label for="edit_precio_venta">PRECIO VENTA:</label>
            <input type="number" name="precio_venta" id="edit_precio_venta" required>
        </div>

        <div class="campo">
            <label for="edit_proveedor">PROVEEDOR:</label>
            <input type="text" name="proveedor" id="edit_proveedor" required>
        </div>

        <div class="campo">
            <label for="edit_fecha">FECHA INGRESO:</label>
            <input type="date" name="fecha_ingreso" id="edit_fecha" required>
        </div>

        <div class="campo">
            <label for="edit_ubicacion">UBICACIÓN:</label>
            <input type="text" name="ubicacion" id="edit_ubicacion" required>
        </div>

        <div class="campo">
            <label for="edit_estado">ESTADO:</label>
            <select name="estado" id="edit_estado" required>
                <option value="Disponible">Disponible</option>
                <option value="Agotado">Agotado</option>
                <option value="Baja">Baja</option>
            </select>
        </div>

        <button type="submit" class="btn-guardar">ACTUALIZAR PRODUCTO</button>

    </form>
</div>


     <!-- ALERTA -->
    <?php if (isset($_GET['msg'])): ?>

    <?php
        $msg = $_GET['msg'];
        $texto = "";
        $clase = "";

        switch ($msg) {
            case "insert_ok":
                $texto = "Insertado correctamente";
                $clase = "insertado"; // Verde
                break;
            case "insert_error":
                $texto = "No se pudo insertar";
                $clase = "eliminado"; // Rojo
                break;

            case "delete_ok":
                $texto = "Eliminación correcta";
                $clase = "insertado"; // Verde
                break;
            case "delete_error":
                $texto = "Error al eliminar";
                $clase = "eliminado"; // Rojo
                break;

            case "update_ok":
                $texto = "Actualizado correctamente";
                $clase = "insertado"; // Verde
                break;
            case "update_error":
                $texto = "Error al actualizar";
                $clase = "eliminado"; // Rojo
                break;
        }
    ?>

    <div id="toast" class="toast <?= $clase ?>">
        <?= $texto ?>
    </div>

<?php endif; ?>




    <!-- SCRIPTS -->
    <script src="js/toast.js"></script>
    <script src="js/maxNumeros.js"></script>
    <script src="js/modalOvar.js"></script>
    <script src="js/modalEditar.js"></script>

</body>
</html>
