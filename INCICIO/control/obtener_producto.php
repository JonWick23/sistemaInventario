<?php
include("conexion.php");
$conexion = conectar();

$id = $_GET['id'];
$sql = "SELECT * FROM Productos WHERE id_productos = '$id'";
$query = mysqli_query($conexion, $sql);
$row = mysqli_fetch_assoc($query);

echo json_encode($row);
?>
