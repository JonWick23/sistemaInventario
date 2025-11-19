<?php
include("conexion.php");
$con = conectar();

// Asegúrate de recibir el ID del producto desde el formulario
$id_productos     = $_POST['id_productos']; 
$codigo_articulo = $_POST['codigo_articulo'];
$nombre          = $_POST['nombre'];
$categoria       = $_POST['categoria'];
$cantidad        = $_POST['cantidad'];
$precio_compra   = $_POST['precio_compra'];
$precio_venta    = $_POST['precio_venta'];
$proveedor       = $_POST['proveedor'];  // corregido: antes decía 'provedor'
$fecha_ingreso   = $_POST['fecha_ingreso'];
$ubicacion       = $_POST['ubicacion'];
$estado          = $_POST['estado'];

// Sentencia SQL corregida
$sql = "UPDATE Productos 
        SET codigo_articulo = '$codigo_articulo',
            nombre = '$nombre',
            categoria = '$categoria',
            cantidad = '$cantidad',
            precio_compra = '$precio_compra',
            precio_venta = '$precio_venta',
            proveedor = '$proveedor',
            fecha_ingreso = '$fecha_ingreso',
            ubicacion = '$ubicacion',
            estado = '$estado'
        WHERE id_productos = '$id_productos'"; // corregido el nombre del campo ID

$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: alumno.php");
    exit();
} else {
    echo "Error al actualizar: " . mysqli_error($con);
}
?>
