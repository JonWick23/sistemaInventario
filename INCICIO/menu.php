<html>
  
    <link rel="stylesheet" href="css/menu.css">
    <header>
        <nav class="nav">
            <div class="logo">UPZ</div>

            
            <ul class="menu">
                <li><a href="inicio.php">INICIO</a></li>
                <li><a href="alumno.php">INVENTARIO</a></li>
                <li><a href="compras.html">COMPRAS</a></li>
                <li><a href="#">VENTAS</a></li>
                <li><a href="#">PROVEEDORES</a></li>
                <li><a href="clientes.php">CLIENTES</a></li>
                <li><a href="#">O. MOVIMIENTOS</a></li>
                <li class="submenu" id="userMenu">
    <a href="#" id="userToggle" class="user-name">
        <?php echo $_SESSION["nombre"] . " " . $_SESSION["apellido"]; ?>
        <span class="arrow">▼</span>
    </a>

    <ul class="submenu-items" id="submenuItems">
        <li><a href="#">ACERCA DE</a></li>
        <li><a href="control/logout.php">Salir</a></li>
    </ul>
</li>


</ul>
</nav>
</header>
<script src="js/menu.js"></script>
</html>