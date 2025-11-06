<?php

include("conexion.php");
$con=conectar();

$id_producto=$_POST['id_producto'];
$nombre=$_POST['nombre'];
$categoria=$_POST['categoria'];
$cantidad=$_POST['cantidad'];
$precio_compra=$_POST['precio_compra'];
$precio_venta=$_POST['precio_venta'];
$provedor=$_POST['provedor'];
$fecha_ingreso=$_POST['fecha_ingreso'];
$ubicacion=$_POST['ubicacion'];
$estado=$_POST['estado'];

$sql="UPDATE producto SET  id_producto='$id_producto', nombre='$nombre', categoria='$categoria',cantidad='$cantidad',
precio_compra='$precio_compra',precio_venta='$precio_venta',provedor='$provedor',  fecha_ingreso='$fecha_ingreso',  ubicacion='$ubicacion', 
estado='$estado' WHERE id_producto='$id_producto'";
$query=mysqli_query($con,$sql);

    if($query){
        Header("Location: alumno.php");
    }
?>