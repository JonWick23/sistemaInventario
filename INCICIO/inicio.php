<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
    header("location: index.php");
}

include("control/conexion.php");
$conexion = conectar();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
     <?php 
    include("menu.php");
    ?>

     <div class="scroll"></div>

    <h2>Bienvenido a la página de inicio</h2>

</body>
</html>