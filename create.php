<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $rfc = $_POST['rfc'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $contacto = $_POST['contacto'];

    $stmt = $pdo->prepare("INSERT INTO proveedores (nombre, rfc, email, telefono, contacto) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $rfc, $email, $telefono, $contacto]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo proveedor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Nuevo proveedor</h1>
    <form method="post">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <label>RFC:</label>
        <input type="text" name="rfc">
        <label>Email:</label>
        <input type="email" name="email">
        <label>Teléfono:</label>
        <input type="text" name="telefono">
        <label>Contacto:</label>
        <input type="text" name="contacto">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn" href="index.php">Cancelar</a>
    </form>
</div>
</body>
</html>
