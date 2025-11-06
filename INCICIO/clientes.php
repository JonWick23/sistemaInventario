<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
    header("location: index.php");
}

include("conexion.php");
$conexion = conectar();

$sql = "SELECT * FROM clientes";
$query = mysqli_query($conexion, $sql);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Clientes</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"><!--Iconos-->
        <script src="https://kit.fontawesome.com/d2fef19485.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
                <link href="estiloo.css" rel="stylesheet"><!--Estilo-->
                <link rel="icon" href="img/cliente.png">
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
			</div>
			
		</div>

	</nav>
        
            <div class="container mt-4">
                    <div class="row"> 

                        <div class="col-md-3">
                            <h1>Datos del cliente</h1>
                                <form action="insertar_cliente.php" method="POST">   
                                    <input type="text" class="form-control mb-3" name="nombre" placeholder="Nombre" required>
                                    <input type="email" class="form-control mb-3" name="email" placeholder="Email" required>
                                    <input type="text" class="form-control mb-3" name="telefono" placeholder="Telefono" required>
                                    <input type="text" class="form-control mb-3" name="direccion" placeholder="Direccion" required>
                                    <input type="text" class="form-control mb-3" name="ciudad" placeholder="Ciudad" required>
                                   <input type="text" class="form-control mb-3" name="estado" placeholder="Estado" required>
                                   <input type="number" class="form-control mb-3" name="codigo_postal" placeholder="Codigo postal" required>
                                    <input type="date" class="form-control mb-3" name="fecha_registro" placeholder="Fecha de registro" required>
                                    <select name="estatus" class="form-select mb-3" required>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
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
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Direccion</th>
                                        <th>Ciudad</th>
                                        <th>Estado</th>
                                        <th>Codigo postal</th>
                                        <th>Fecha de ingreso</th>
                                        <th>Estatus</th> 
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                        <?php
                                            while($row=mysqli_fetch_array($query)){
                                        ?>
                                            <tr>
                                                <th>
                                                    <?php  echo $row['id_cliente']?>
                                                </th>
                                                <th>
                                                    <?php  echo $row['nombre']?>
                                                </th>
                                                <th>
                                                    <?php  echo $row['email']?>
                                                </th>
                                                <th>
                                                    <?php  echo $row['telefono']?>
                                                </th>    
                                                <th>
                                                    <?php  echo $row['direccion']?>
                                                </th> 
                                                <th>
                                                    <?php  echo $row['ciudad']?>
                                                </th> 
                                                <th>
                                                    <?php  echo $row['estado']?>
                                                </th>
                                                <th>
                                                    <?php  echo $row['codigo_postal']?>
                                                </th>
                                                <th>
                                                    <?php  echo $row['fecha_registro']?>
                                                </th> 
                                                <th>
                                                    <?php  echo $row['estatus']?>
                                                </th> 
                                                <th><a href="actualizar.php?id=<?php echo $row['id_cliente'] ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a></th>
                                                <th><a href="delete.php?id=<?php echo $row['id_cliente'] ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a></th>
                                            </tr>
                                        <?php 
                                            }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>  
            </div>
            

    </body>
</html>