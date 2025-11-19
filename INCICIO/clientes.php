<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
    header("location: index.php");
}

include("conexion.php");
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
    <link rel="stylesheet" href="css/productos.css   ">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="usuario">
            <?php echo $_SESSION["nombre"]. " " .$_SESSION["apellido"]; ?>
        </div>
        <div class="menu">
            <a href="alumno.php">Productos</a>
            <a href="logout.php" class="btn-salir">Salir</a>
        </div>
    </nav>

    <div class="container">
        <div class="formulario">
            <h1>Datos del cliente 👤</h1>
            <form action="insertar_cliente.php" method="POST">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="telefono" placeholder="Teléfono" required>
                <input type="text" name="direccion" placeholder="Dirección" required>
                <input type="text" name="ciudad" placeholder="Ciudad" required>
                <input type="text" name="estado" placeholder="Estado" required>
                <input type="number" name="codigo_postal" placeholder="Código postal" required>
                <input type="date" name="fecha_registro" placeholder="Fecha de registro" required>

                <select name="estatus" required>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>

                <input type="submit" value="Guardar cliente" class="btn-guardar">
            </form>
        </div>

        <div class="tabla-contenedor">
            <table class="miTabla">
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
                            <td><a href="actualizar_cliente.php?id=<?php echo $row['id_clientes']; ?>" class="btn-editar"><i class="fa-solid fa-pen-to-square"></i></a></td>
                            <td><a href="delete_cliente.php?id=<?php echo $row['id_clientes']; ?>" class="btn-borrar"><i class="fa-solid fa-trash"></i></a></td>
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
    </div>
    
<script src="js/tabla.js"></script>
</body>
</html>
