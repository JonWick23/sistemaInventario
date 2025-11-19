<html>
  
    <link rel="stylesheet" href="css/menu.css">
    <header>
        <nav class="nav">
            <div class="logo">NAME DE LA EMPRESA</div>
            <ul class="menu">
                <li><a href="#">INICIO</a></li>
                <li><a href="alumno.php">INVENTARIO</a></li>
                <li><a href="compras.html">COMPRAS</a></li>
                <li><a href="#">PROVEEDORES</a></li>
                <li><a href="#">ACERCA DE</a></li>
                <li><a href="#"><?php echo $_SESSION["nombre"]. " " .$_SESSION["apellido"]; ?></a></li>
                <li><a href="logout.php">Salir</a></li>
            </ul>
        </nav>
    </header>

</html>