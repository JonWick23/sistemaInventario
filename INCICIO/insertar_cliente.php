<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conexion.php");
$con = conectar();

// No necesitas el id_cliente, MySQL lo genera automáticamente
$nombre         = $_POST['nombre'];
$email          = $_POST['email'];
$telefono       = $_POST['telefono'];
$direccion      = $_POST['direccion'];
$ciudad         = $_POST['ciudad'];
$estado         = $_POST['estado'];
$codigo_postal  = $_POST['codigo_postal'];
$fecha_registro = $_POST['fecha_registro'];
$estatus        = $_POST['estatus'];

$sql = "INSERT INTO clientes (
    nombre, email, telefono, direccion, ciudad, estado, codigo_postal, fecha_registro, estatus
) VALUES (
    '$nombre', '$email', '$telefono', '$direccion', '$ciudad',
    '$estado', '$codigo_postal', '$fecha_registro', '$estatus'
)";

if (mysqli_query($con, $sql)) {
    header("Location: clientes.php");
    exit();
} else {
    echo "❌ Error al insertar: " . mysqli_error($con);
}
?>
