<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
    header("location: index.php");
}

include("conexion.php");
$conexion = conectar();

$sql = "SELECT * FROM Productos";
$query = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/inventario.png">
    <link rel="stylesheet" href="css/productos.css">
</head>

<body>

    <!-- NAVBAR -->
    <nav>
        <div>
            <?php echo $_SESSION["nombre"]. " " .$_SESSION["apellido"]; ?>
        </div>
        <div>
            <a href="logout.php">Salir</a>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <!-- FORMULARIO -->
            <div class="col-md-3">
                <h1>Datos del producto 📦</h1>
                <form action="insertar.php" method="POST">
    <input type="number" id="codigo_articulo" name="codigo_articulo" placeholder="Código del artículo" required>
    <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
    <input type="text" id="categoria" name="categoria" placeholder="Categoría" required>
    <input type="number" id="cantidad" name="cantidad" placeholder="Cantidad" required>
    <input type="number" id="precio_compra" name="precio_compra" placeholder="Precio de compra" required>
    <input type="number" id="precio_venta" name="precio_venta" placeholder="Precio de venta" required>
    <input type="text" id="proveedor" name="proveedor" placeholder="Proveedor" required>
    <input type="date" id="fecha_ingreso" name="fecha_ingreso" placeholder="Fecha de ingreso" required>
    <input type="text" id="ubicacion" name="ubicacion" placeholder="Ubicación" required>

    <select id="estado" name="estado" required>
        <option value="Disponible">Disponible</option>
        <option value="Agotado">Agotado</option>
        <option value="Baja">Baja</option>
    </select>

    <input type="submit" value="Guardar producto">
</form>

            </div>

            <!-- TABLA -->
            <div class="tabla-contenedor">
                <table class="miTabla">
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
            </div>

        </div>
    </div>

    <script src="js/maxNumeros.js"></script>
    <script src="js/tabla.js"></script>
    <script src="js/autocompletar.js"></script>

</body>
</html>
