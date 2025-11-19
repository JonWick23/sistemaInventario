<?php 
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
    header("location: index.php");
}

    include("conexion.php");
    $con=conectar();

$id=$_GET['id'];

$sql="SELECT * FROM Productos WHERE id_productos='$id'";
$query=mysqli_query($con,$sql);

$row=mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Actualizar</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
        <title>Actualizar</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="icon" href="img/actualizar.png">
        <link rel="stylesheet" href="css/productos.css">
    </head>
    <body>

    <h1>Actualizar datos</h1>
                <div class="container mt-5">
                    <form action="update.php" method="POST">

                                <input type="hidden" name="id_productos" value="<?php echo $row['id_productos']; ?>">
                                <input type="text" class="form-control mb-3" name="codigo_articulo" value="<?php echo $row['codigo_articulo']  ?>">
                                <input type="text" class="form-control mb-3" name="nombre" placeholder="Nombre" value="<?php echo $row['nombre']  ?>">
                                <input type="text" class="form-control mb-3" name="categoria" placeholder="Categoria" value="<?php echo $row['categoria']  ?>">
                                <input type="text" class="form-control mb-3" name="cantidad" placeholder="Cantidad" value="<?php echo $row['cantidad']  ?>">
                                <input type="text" class="form-control mb-3" name="precio_compra" placeholder="Precio de Compra" value="<?php echo $row['precio_compra']  ?>">
                                <input type="text" class="form-control mb-3" name="precio_venta" placeholder="Precio de venta" value="<?php echo $row['precio_venta']  ?>">
                                <input type="text" class="form-control mb-3" name="provedor" placeholder="Provedor" value="<?php echo $row['provedor']  ?>">
                                <input type="text" class="form-control mb-3" name="fecha_ingreso" placeholder="Fecha de ingreso" value="<?php echo $row['fecha_ingreso']  ?>">
                                <input type="text" class="form-control mb-3" name="ubicacion" placeholder="Ubicacion" value="<?php echo $row['ubicacion']  ?>">
                                <select name="estado" class="form-select mb-3">
                                    <option value="Disponible">Disponible</option>
                                    <option value="Agotado">Agotado</option>
                                    <option value="Baja">Baja</option>
                                </select>
                            <input type="submit" class="btn btn-primary btn-block" value="Actualizar">
                    </form>

                </div>
    </body>
</html>