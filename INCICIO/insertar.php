<?php
include("conexion.php");
$con = conectar();

$id_producto   = $_POST['id_producto'];
$nombre        = $_POST['nombre'];
$categoria     = $_POST['categoria'];
$cantidad      = $_POST['cantidad'];
$precio_compra = $_POST['precio_compra'];
$precio_venta  = $_POST['precio_venta'];
$provedor      = $_POST['provedor'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$ubicacion     = $_POST['ubicacion'];
$estado        = $_POST['estado'];

// Usa un try-catch si quieres más control
$sql = "INSERT INTO producto (
    id_producto, nombre, categoria, cantidad, precio_compra, precio_venta, provedor, fecha_ingreso, ubicacion, estado
) VALUES (
    '$id_producto', '$nombre', '$categoria', '$cantidad', '$precio_compra', '$precio_venta',
    '$provedor', '$fecha_ingreso', '$ubicacion', '$estado'
)";

if (mysqli_query($con, $sql)) {
    header("location: alumno.php");
    exit();
} else {
    echo "Error al insertar: " . mysqli_error($con);
}
