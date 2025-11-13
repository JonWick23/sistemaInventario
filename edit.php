<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM proveedores WHERE id = ?");
$stmt->execute([$id]);
$proveedor = $stmt->fetch();

if (!$proveedor) {
    die("Proveedor no encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $rfc = $_POST['rfc'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $contacto = $_POST['contacto'];

    $stmt = $pdo->prepare("UPDATE proveedores SET nombre=?, rfc=?, email=?, telefono=?, contacto=? WHERE id=?");
    $stmt->execute([$nombre, $rfc, $email, $telefono, $contacto, $id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar proveedor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Editar proveedor</h1>
    <form method="post">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($proveedor['nombre']) ?>" required>
        <label>RFC:</label>
        <input type="text" name="rfc" value="<?= htmlspecialchars($proveedor['rfc']) ?>">
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($proveedor['email']) ?>">
        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($proveedor['telefono']) ?>">
        <label>Contacto:</label>
        <input type="text" name="contacto" value="<?= htmlspecialchars($proveedor['contacto']) ?>">
        <button class="btn btn-primary" type="submit">Guardar cambios</button>
        <a class="btn" href="index.php">Cancelar</a>
    </form>
</div>
</body>
</html>
