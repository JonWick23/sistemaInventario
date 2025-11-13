<?php
require 'db.php';

$search = $_GET['search'] ?? '';
if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM proveedores WHERE id = :id OR nombre LIKE :nombre ORDER BY id DESC");
    $stmt->execute([
        ':id' => $search,
        ':nombre' => "%$search%"
    ]);
} else {
    $stmt = $pdo->query("SELECT * FROM proveedores ORDER BY id DESC");
}

$proveedores = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proveedores - Inventario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Proveedores</h1>
    <div class="top-bar">
        <a class="btn btn-primary" href="create.php">+ Nuevo proveedor</a>
        <form method="get" class="search">
            <input type="text" name="search" placeholder="Buscar por ID o nombre" value="<?= htmlspecialchars($search) ?>">
            <button class="btn" type="submit">Buscar</button>
            <a class="btn" href="index.php">Limpiar</a>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>RFC</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Contacto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($proveedores) === 0): ?>
            <tr><td colspan="7">No se encontraron proveedores.</td></tr>
        <?php else: ?>
            <?php foreach ($proveedores as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><?= htmlspecialchars($p['rfc']) ?></td>
                <td><?= htmlspecialchars($p['email']) ?></td>
                <td><?= htmlspecialchars($p['telefono']) ?></td>
                <td><?= htmlspecialchars($p['contacto']) ?></td>
                <td>
                    <a class="btn" href="edit.php?id=<?= $p['id'] ?>">Editar</a>
                    <a class="btn btn-danger" href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('¿Eliminar este proveedor?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
