<?php
include("conexion.php");
$con = conectar();

if (isset($_GET['codigo_articulo'])) {
    $codigo = $_GET['codigo_articulo'];

    $sql = "SELECT * FROM productos WHERE codigo_articulo = '$codigo'";
    $resultado = mysqli_query($con, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $producto = mysqli_fetch_assoc($resultado);
        echo json_encode($producto);
    } else {
        echo json_encode(["error" => "Producto no encontrado"]);
    }
}
?>
