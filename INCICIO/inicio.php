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
    <link rel="icon" href="img/hogar.png">
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
     <?php 
    include("menu.php");
    ?>

     <div class="scroll"></div>

<!-- Contenedor general -->
<div class="inicio-container">

    <!-- HERO DE BIENVENIDA -->
    <section class="hero">
        <div class="hero-text">
            <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
            <p>Sistema de inventario — Gestión fácil, rápida y segura.</p>
        </div>

        <div class="hero-img">
            <img src="img/in.png" alt="Dashboard Inventario">
        </div>
    </section>

    <!-- TARJETAS RESUMEN -->
   

    <!-- SECCIÓN INFERIOR -->
    <section class="info">
        <h2>¿Qué puedes hacer?</h2>
        <ul>
            <li>Registrar productos y controlar su stock.</li>
            <li>Realizar entradas y salidas.</li>
            <li>Generar reportes.</li>
            <li>Administrar usuarios del sistema.</li>
        </ul>
    </section>

</div>


</body>
</html>