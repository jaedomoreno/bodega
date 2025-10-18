<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: login.php");
include 'conexion.php';

// Crear chofer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear'])) {
    $stmt = $conn->prepare("INSERT INTO choferes(nombre,rut,telefono) VALUES(?,?,?)");
    $stmt->execute([$_POST['nombre'], $_POST['rut'], $_POST['telefono']]);
    header("Location: gestionar_chofer.php");
    exit;
}

// Actualizar chofer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar'])) {
    $stmt = $conn->prepare("UPDATE choferes SET nombre=?, rut=?, telefono=? WHERE id=?");
    $stmt->execute([$_POST['nombre'], $_POST['rut'], $_POST['telefono'], $_POST['id']]);
    header("Location: gestionar_chofer.php");
    exit;
}

// Eliminar
if (isset($_GET['eliminar'])) {
    $stmt = $conn->prepare("DELETE FROM choferes WHERE id=?");
    $stmt->execute([$_GET['eliminar']]);
    header("Location: gestionar_chofer.php");
    exit;
}

// Editar
if (isset($_GET['editar'])) {
    $stmt = $conn->prepare("SELECT * FROM choferes WHERE id=?");
    $stmt->execute([$_GET['editar']]);
    $chofer = $stmt->fetch();
}

// Lista
$choferes = $conn->query("SELECT * FROM choferes")->fetchAll();
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<div class="contenido">
    <h2>👨‍✈️ Gestión de Choferes</h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $chofer['id'] ?? '' ?>">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $chofer['nombre'] ?? '' ?>" required>
        <label>RUT:</label>
        <input type="text" name="rut" value="<?= $chofer['rut'] ?? '' ?>" required>
        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?= $chofer['telefono'] ?? '' ?>" required>
        <button type="submit" name="<?= isset($chofer) ? 'actualizar' : 'crear' ?>">
            <?= isset($chofer) ? 'Actualizar' : 'Crear' ?> Chofer
        </button>
    </form>

    <table>
        <tr>
            <th>Nombre</th>
            <th>RUT</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($choferes as $c): ?>
            <tr>
                <td><?= $c['nombre'] ?></td>
                <td><?= $c['rut'] ?></td>
                <td><?= $c['telefono'] ?></td>
                <td>
                    <a href="?editar=<?= $c['id'] ?>">Editar</a> |
                    <a href="?eliminar=<?= $c['id'] ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>

</html>