<?php
    include "datos.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros | Mi Empresa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="acerca de.css"> 
</head>
<body>
    <div class="container">
        
        <div class="about-intro">
            <h2>Nuestra Esencia</h2>
            <p>
                Este sistema ha sido diseñado específicamente para optimizar el control de inventarios, 
                agilizar el punto de venta y facilitar la administración de bases de datos en tiempo real.
                <br>
                Nuestra misión es digitalizar procesos manuales mediantes el uso de tecnología.
            </p>
        </div>

        <div class="info-grid">
            
            <div class="card">
                <div class="icon-circle">
                    <i class="fas fa-id-card"></i>
                </div>
                <h3>Datos Fiscales</h3>
                <span class="card-link" style="cursor: default;">
                    RFC: <?php echo $empresa_rfc; ?>
                </span>
            </div>

            <div class="card">
                <div class="icon-circle">
                    <i class="fas fa-server"></i>
                </div>
                <h3>Oficinas Centrales</h3>
                <a href="<?php echo $empresa_mapa_link; ?>" target="_blank" class="card-link">
                    <?php echo $empresa_direccion; ?><br>
                    <?php echo $empresa_colonia; ?>
                </a>
            </div>

            <div class="card">
                <div class="icon-circle">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Contrataciones</h3>
                <a href="tel:<?php echo $empresa_telefono_link; ?>" class="card-link">
                    <?php echo $empresa_telefono; ?>
                </a>
            </div>

            <div class="card">
                <div class="icon-circle">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h3>Soporte Técnico</h3>
                <a href="mailto:<?php echo $empresa_email; ?>" class="card-link">
                    <?php echo $empresa_email; ?>
                </a>
            </div>

        </div>
    </div>

    <footer>
        &copy; 2025 Mi Empresa S.A. de C.V. - Desarrollado con pasión.
    </footer>

</body>
</html>