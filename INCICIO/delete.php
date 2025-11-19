<?php

include("conexion.php");
$con=conectar();

$id_productos=$_GET['id'];

$sql="DELETE FROM Productos WHERE id_productos='$id_productos'";
$query=mysqli_query($con,$sql);

    if($query){
        header("location: alumno.php");
    }
?>

