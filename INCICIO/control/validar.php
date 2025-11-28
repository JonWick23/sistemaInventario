<?php
session_start();
include("db.php"); // conexión a la BD en la variable $conexion

if (!empty($_POST["btningresar"])) {
    if (!empty($_POST["usuario"]) and !empty($_POST["password"])) {

        $usuario = $_POST["usuario"];
        $password = $_POST["password"];

        // Consulta a la base de datos
        $sql = $conexion->query("SELECT * FROM personal WHERE usuario='$usuario' AND password='$password'");

        // Si la consulta devuelve un usuario válido
        if ($datos = $sql->fetch_object()) {
            $_SESSION["id"] = $datos->id;
            $_SESSION["nombre"] = $datos->nombre;
            $_SESSION["apellido"] = $datos->apellido;
            $_SESSION["id_cargo"] = $datos->id_cargo;

            // Redirige según el tipo de usuario
            if ($datos->id_cargo == 1) {
                header("Location: ./inicio.php"); // administrador
                exit();
            } elseif ($datos->id_cargo == 2) {
                header("Location: personal.php"); // personal
                exit();
            } else {
                echo "<div class='alert alert-warning'>Rol no asignado correctamente.</div>";
            }

        } else {
            echo "<div class='alert alert-danger'>Acceso denegado</div>";
        }

    } else {
        echo "<div class='alert alert-warning'>Campos vacíos</div>";
    }
}
?>
