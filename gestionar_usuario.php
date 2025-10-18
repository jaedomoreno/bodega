<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: login.php");
include 'conexion.php';

// Crear un nuevo usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $clave = md5($_POST['clave']); // Encriptación de clave

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, clave) VALUES (?, ?)");
    $stmt->execute([$nombre, $clave]);
    header("Location: gestionar_usuario.php");
}

// Actualizar usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $clave = md5($_POST['clave']); // Encriptación de clave

    $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, clave = ? WHERE id = ?");
    $stmt->execute([$nombre, $clave, $id]);
    header("Location: gestionar_usuario.php");
}

// Eliminar usuario
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: gestionar_usuario.php");
}

// Obtener lista de usuarios
$usuarios = $conn->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<?php include 'header.php'; ?>

<body>
    <h2>Gestión de Usuarios</h2>

    <!-- Formulario para crear o actualizar usuario -->
    <form action="gestionar_usuario.php" method="POST">
        <input type="hidden" name="id" value="<?= isset($usuario) ? $usuario['id'] : '' ?>">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= isset($usuario) ? $usuario['nombre'] : '' ?>" required>

        <label>Clave:</label>
        <input type="password" name="clave" value="<?= isset($usuario) ? '' : '' ?>" required>

        <button type="submit" name="<?= isset($usuario) ? 'actualizar' : 'crear' ?>"><?= isset($usuario) ? 'Actualizar' : 'Crear' ?> Usuario</button>
    </form>

    <!-- Lista de usuarios -->
    <table>
        <tr>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= $usuario['nombre'] ?></td>
                <td>
                    <a href="gestionar_usuario.php?editar=<?= $usuario['id'] ?>">Editar</a> |
                    <a href="gestionar_usuario.php?eliminar=<?= $usuario['id'] ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>