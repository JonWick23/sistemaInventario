<?php
include("conexion.php");
$con = conectar();


$codigo_articulo = $_POST['codigo_articulo'];
$nombre        = $_POST['nombre'];
$categoria     = $_POST['categoria'];
$cantidad      = $_POST['cantidad'];
$precio_compra = $_POST['precio_compra'];
$precio_venta  = $_POST['precio_venta'];
$proveedor      = $_POST['proveedor'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$ubicacion     = $_POST['ubicacion'];
$estado        = $_POST['estado'];


// Usa un try-catch si quieres más control
$sql = "INSERT INTO Productos (
    codigo_articulo, nombre, categoria, cantidad, precio_compra, precio_venta, proveedor, fecha_ingreso, ubicacion, estado
) VALUES (
    '$codigo_articulo', '$nombre', '$categoria', '$cantidad', '$precio_compra', '$precio_venta',
    '$proveedor', '$fecha_ingreso', '$ubicacion', '$estado'
)";

if (mysqli_query($con, $sql)) {
    header("Location: ../alumno.php?msg=insert_ok");
} else {
    header("Location: ../alumno.php?msg=insert_error");
}

exit();

?>