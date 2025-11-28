<?php
include("conexion.php");
$con=conectar();

$id_clientes=$_GET['id'];

$sql="DELETE FROM clientes WHERE id_clientes='$id_clientes'";
$query=mysqli_query($con,$sql);

  if ($query) {
    header("Location: ../clientes.php?msg=exito");
} else {
    header("Location: ../clientes.php?msg=error");
}
exit();
?>
