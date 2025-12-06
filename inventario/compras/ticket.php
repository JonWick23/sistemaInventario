<?php

include "../datos.php";

//OBTENER EL ID
if (!isset($_GET['id'])) {
    die("Error: No se ha especificado una compra.");
}
$id_compra = $_GET['id'];

$server = 'localhost:3306'; $username = 'root'; $password = ''; $database ='sistemainventario';
try {
    $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) { die("Error de conexión: " . $e->getMessage()); }

// CONSULTA DE ENCABEZADO 
$sqlInfo = "SELECT cp.id_compras, cp.fecha, cp.iva, cp.total, 
                   p.nombre as nombre_proveedor, p.rfc, p.direccion, p.telefono
            FROM compras cp 
            JOIN provedores p ON cp.Provedores_id_provedores = p.id_provedores
            WHERE cp.id_compras = :id";
$stmt = $con->prepare($sqlInfo);
$stmt->execute([':id' => $id_compra]);
$info = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$info) { die("Compra no encontrada."); }

// 4. CONSULTA DE PRODUCTOS (Detalle)
$sqlProd = "SELECT pc.cantidad_pd_cp as cantidad, 
                   pc.precio_pd_cp as precio_compra, 
                   pr.nombre as nombre_producto
            FROM productos_compras pc
            JOIN productos pr ON pc.Productos_id_productos = pr.id_productos
            WHERE pc.Compras_id_compras = :id";

$stmtP = $con->prepare($sqlProd);
$stmtP->execute([':id' => $id_compra]);
$productos = $stmtP->fetchAll(PDO::FETCH_ASSOC);

// Cálculos auxiliares para mostrar
$subtotal_final = $info['total'] - $info['iva'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Compra #<?php echo $info['id_compras']; ?></title>
    <link rel="stylesheet" href="ticket.css"> 
</head>
<body>

    <div class="ticket-modal">
        <div class="ticket-body">
            
            <div class="company-info">
                <div class="company-name">MI EMPRESA</div>
                <div class="company-details">
                    RFC: <?php echo $empresa_rfc; ?><br>
                    <?php echo $empresa_direccion; ?><br>
                    Tel: <?php echo $empresa_telefono; ?>
                </div>
            </div>

            <div class="dashed-line">--------------------------------</div>

            <div class="info-row">
                <span class="info-label">Ticket #:</span>
                <span class="info-value"><?php echo $info['id_compras']; ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha:</span>
                <span class="info-value"><?php echo $info['fecha']; ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Proveedor:</span>
                <span class="info-value"><?php echo $info['nombre_proveedor']; ?></span>
            </div>

            <div class="dashed-line">--------------------------------</div>

            <div style="margin-bottom: 10px; font-weight: bold; color:#000;">Detalle de Compra</div>

            <?php foreach($productos as $prod): 
                $subtotal_linea = $prod['cantidad'] * $prod['precio_compra'];
            ?>
            <div class="product-item">
                <div class="product-name"><?php echo $prod['nombre_producto']; ?></div>
                <div class="product-calc">
                    <span><?php echo $prod['cantidad']; ?> x $<?php echo number_format($prod['precio_compra'], 2); ?></span>
                    <span>$<?php echo number_format($subtotal_linea, 2); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
            
            <div class="dashed-line">--------------------------------</div>

            <div class="total-row">
                <span>Subtotal:</span>
                <span>$<?php echo number_format($subtotal_final, 2); ?></span>
            </div>
            <div class="total-row">
                <span>IVA:</span>
                <span>$<?php echo number_format($info['iva'], 2); ?></span>
            </div>
            <div class="total-row total-final">
                <span>TOTAL:</span>
                <span>$<?php echo number_format($info['total'], 2); ?></span>
            </div>

            <div class="dashed-line">--------------------------------</div>

            <div class="ticket-footer">
                ¡Gracias por su compra!<br>
                Este ticket no es un comprobante fiscal<br><br>
            </div>

        </div>
        
        <div style="text-align: center; margin-top: 20px;" id="btn-imprimir-pantalla">
            <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">🖨️ IMPRIMIR</button>
        </div>
    </div>

    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>