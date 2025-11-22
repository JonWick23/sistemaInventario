<?php

include("conexion.php");
$con=conectar();

$id_clientes=$_GET['id'];

$sql="DELETE FROM Clientes WHERE id_clientes='$id_clientes'";
$query=mysqli_query($con,$sql);

    if($query){
        echo '<script type="text/javascript">
                alert("Eliminacion Exitosa");
                window.location.href="index.php";
              </script>';
        header("location: clientes.php");
    }
?>

