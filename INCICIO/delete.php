<?php

include("conexion.php");
$con=conectar();

$id_productos=$_GET['id'];

$sql="DELETE FROM Productos WHERE id_productos='$id_productos'";
$query=mysqli_query($con,$sql);

?>


<div class="contenedor-toast">
<?php
    if($query){
        echo "<script class='exito'>alert('Producto eliminado exitosamente'); window.location='alumno.php';</script>";
    }else{
        echo "<script class='error'>alert('Error al eliminar el producto'); window.location='alumno.php';</script>";
    }
?>
</div>