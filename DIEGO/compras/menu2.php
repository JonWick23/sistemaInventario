<html>
  
    <link rel="stylesheet" href="menu2.css">
    <header>
        <nav class="nav">
            <div class="logo">NOMBRE DE LA EMPRESA</div>

            
            <ul class="menu">
                <li><a href="#">INICIO</a></li>
                <li><a href="alumno.php">INVENTARIO</a></li>
                <li><a href="compras.html">COMPRAS</a></li>
                <li><a href="#">PROVEEDORES</a></li>
                <li><a href="clientes.php">CLIENTES</a></li>
                <li class="submenu" id="userMenu">
    <a href="#" id="userToggle" class="user-name">
        <?php echo $_SESSION["nombre"] . " " . $_SESSION["apellido"]; ?>
        <span class="arrow">▼</span>
    </a>

    <ul class="submenu-items" id="submenuItems">
        <li><a href="#">ACERCA DE</a></li>
        <li><a href="logout.php">Salir</a></li>
    </ul>
</li>


</ul>
</nav>
</header>
<script src="menu2.js"></script>
</html>