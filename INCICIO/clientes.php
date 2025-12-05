<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
    header("location: index.php");
}

include("control/conexion.php");
$conexion = conectar();

// ===== PAGINADO =====
$por_pagina = 10; // cantidad de clientes por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $por_pagina;

// Total de registros
$total_query = mysqli_query($conexion, "SELECT COUNT(*) as total FROM Clientes");
$total_row = mysqli_fetch_assoc($total_query);
$total_registros = $total_row['total'];
$total_paginas = ceil($total_registros / $por_pagina);

// Consulta con límite
$sql = "SELECT * FROM Clientes LIMIT $inicio, $por_pagina";
$query = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/cliente.png">
    <script src="https://kit.fontawesome.com/d2fef19485.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style1.css">
</head>

<body>

    <?php include("menu.php"); ?>

    <div class="scroll"></div>

    <!-- BOTÓN NUEVO CLIENTE -->
    <button id="btnAbrirFormulario">+ NUEVO CLIENTE</button>

    <!-- MODAL REGISTRO CLIENTE -->
    <div id="modalOverlay" class="modal-overlay">
        <form action="control/insertar_cliente.php" method="POST" id="formularioVenta">
            <span id="btnCerrarModal" class="cerrar-modal">&times;</span>

            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>
            </div>

            <div class="campo">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>

            <div class="campo">
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" required>
            </div>

            <div class="campo">
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" required>
            </div>

            <div class="campo">
                <label for="ciudad">Ciudad:</label>
                <input type="text" name="ciudad" required>
            </div>

            <div class="campo">
                <label for="estado">Estado:</label>
                <input type="text" name="estado" required>
            </div>

            <div class="campo">
                <label for="codigo_postal">Código Postal:</label>
                <input type="number" name="codigo_postal" required>
            </div>

            <div class="campo">
                <label for="fecha_registro">Fecha de Registro:</label>
                <input type="date" name="fecha_registro" required>
            </div>

            <div class="campo">
                <label for="estatus">Estatus:</label>
                <select name="estatus" required>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>

            <input type="submit" value="GUARDAR CLIENTE">
        </form>
    </div>

    <!-- BUSCADOR -->
    <form action="" method="POST">
        <div class="input-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="buscar" placeholder="Buscar cliente por ID, nombre o email">
            <button type="submit" class="btnBuscar">Buscar</button>
        </div>
    </form>

    <?php
        if (!empty($_POST['buscar'])) {

            $buscar = $_POST['buscar'];

            $sql = "SELECT * FROM Clientes 
                    WHERE id_clientes LIKE '%$buscar%' 
                    OR nombre LIKE '%$buscar%' 
                    OR email LIKE '%$buscar%'";

            $query = mysqli_query($conexion, $sql);

        } else {
            $sql = "SELECT * FROM Clientes LIMIT $inicio, $por_pagina";
            $query = mysqli_query($conexion, $sql);
        }
    ?>

    <!-- TABLA -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>Código postal</th>
                    <th>Registro</th>
                    <th>Estatus</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                </tr>
            </thead>

            <tbody>
                <?php while($row = mysqli_fetch_array($query)) { ?>
                <tr>
                    <td><?php echo $row['id_clientes']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['telefono']; ?></td>
                    <td><?php echo $row['direccion']; ?></td>
                    <td><?php echo $row['ciudad']; ?></td>
                    <td><?php echo $row['estado']; ?></td>
                    <td><?php echo $row['codigo_postal']; ?></td>
                    <td><?php echo $row['fecha_registro']; ?></td>
                    <td><?php echo $row['estatus']; ?></td>

                    <!-- BOTÓN EDITAR -->
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
                            onclick="if (confirm('¿Seguro de eliminar?')) { 
                                window.location.href='control/delete_cliente.php?id=<?php echo $row['id_clientes']; ?>';
                            }">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
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
    <script src="js/modalOvar.js"></script>

</body>
</html>
