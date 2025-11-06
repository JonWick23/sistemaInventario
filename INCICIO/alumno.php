<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
    header("location: index.php");
}

include("conexion.php");
$conexion = conectar();

$sql = "SELECT * FROM producto";
$query = mysqli_query($conexion, $sql);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Productos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"><!--Iconos-->
        <script src="https://kit.fontawesome.com/d2fef19485.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
                <link href="estiloo.css" rel="stylesheet"><!--Estilo-->
                <link rel="icon" href="img/inventario.png">
                <link rel="stylesheet" href="css/estiloo.css">           
    </head>

    <body>

    <nav class="navbar navbar-dark bg-dark  navbar-expand-md navbar-light bg-light ">
		<div class="text-white bg-success p-2">
			<?php
				echo $_SESSION["nombre"]. " " .$_SESSION["apellido"];
			?>
		</div>
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
			<div class="navbar-nav mr-auto">
				<a class="nav-item nav-link text-justify ml-3 hover-primary" href="logout.php">Salir</a>
                <a href="clientes.php">clientes</a>
			</div>
			
		</div>

	</nav>
        
            <div class="container mt-4">
                    <div class="row"> 

                        <div class="col-md-3">
                            <h1>Datos del producto 📦</h1>
                                <form action="insertar.php" method="POST">

                                    <input type="number" class="form-control mb-3" name="id_producto" placeholder="ID" required>
                                    <input type="text" class="form-control mb-3" name="nombre" placeholder="Nombre" required>
                                    <input type="text" class="form-control mb-3" name="categoria" placeholder="Categoria" required>
                                    <input type="number" class="form-control mb-3" name="cantidad" placeholder="Cantidad" required>
                                    <input type="number" class="form-control mb-3" name="precio_compra" placeholder="Precio de compra" required>
                                    <input type="number" class="form-control mb-3" name="precio_venta" placeholder="Precio de venta" required>
                                    <input type="text" class="form-control mb-3" name="provedor" placeholder="Provedor" required>
                                    <input type="date" class="form-control mb-3" name="fecha_ingreso" placeholder="Fecha de ingreso" required>
                                    <input type="text" class="form-control mb-3" name="ubicacion" placeholder="Ubicacion" required>
                                    <select name="estado" class="form-select mb-3" required>
                                        <option value="disponible">Disponible</option>
                                        <option value="agotado">Agotado</option>
                                        <option value="baja">Baja</option>
                                    </select>

                                    <input type="submit" class="btn btn-primary">
                                    
                                </form>
                        </div>

                        <div class="col-md-8">
                            <table class="table table-striped" >
                                <thead class="tabla">
                                    <tr>
                                        <th >ID</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Cantidad</th>
                                        <th>Precio de compra</th>
                                        <th>Precio de venta</th>
                                        <th>Provedor</th>
                                        <th>Dia de ingreso</th>
                                        <th>Ubicacion</th>
                                        <th>Estado</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        // Variables para acumular los subtotales
                                        $subtotal_compra = 0;
                                        $subtotal_venta  = 0;

                                        while ($row = mysqli_fetch_array($query)) {
                                            // Acumulamos los subtotales
                                            $subtotal_compra += $row['precio_compra'] * $row['cantidad'];
                                            $subtotal_venta  += $row['precio_venta'] * $row['cantidad'];
                                    ?>
                                        <tr>
                                            <th><?php echo $row['id_producto']; ?></th>
                                            <th><?php echo $row['nombre']; ?></th>
                                            <th><?php echo $row['categoria']; ?></th>
                                            <th><?php echo $row['cantidad']; ?></th>
                                            <th>$<?php echo number_format($row['precio_compra'], 2); ?></th>
                                            <th>$<?php echo number_format($row['precio_venta'], 2); ?></th>
                                            <th><?php echo $row['provedor']; ?></th>
                                            <th><?php echo $row['fecha_ingreso']; ?></th>
                                            <th><?php echo $row['ubicacion']; ?></th>
                                            <th><?php echo $row['estado']; ?></th>
                                            <th><a href="actualizar.php?id=<?php echo $row['id_producto']; ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a></th>
                                            <th><a href="delete.php?id=<?php echo $row['id_producto']; ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a></th>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                                <tfoot class="tabla">
                                    <tr>
                                        <th>Subtotal</th>
                                        <th colspan="3"></th>
                                        <th>$<?php echo number_format($subtotal_compra, 2); ?></th>
                                        <th>$<?php echo number_format($subtotal_venta, 2); ?></th>
                                        <th colspan="6"></th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>  
            </div>
            

    </body>
</html>