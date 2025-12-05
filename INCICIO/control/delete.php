<?php
include("conexion.php");
$con = conectar();

$id_productos = $_GET['id'];

$sql = "DELETE FROM productos WHERE id_productos='$id_productos'";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: ../alumno.php?msg=delete_ok");
} else {
    header("Location: ../alumno.php?msg=delete_error");
}
exit();
?>
