<?php
session_start();
if(!isset($_SESSION['usuario'])) header("Location: login.php");
include 'conexion.php';

// Crear producto
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['crear'])){
    $stmt = $conn->prepare("INSERT INTO productos(codigo,descripcion,grupo) VALUES(?,?,?)");
    $stmt->execute([$_POST['codigo'], $_POST['descripcion'], $_POST['grupo'] ?: null]);
    header("Location: gestionar_producto.php"); exit;
}

// Actualizar producto
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['actualizar'])){
    $stmt = $conn->prepare("UPDATE productos SET codigo=?, descripcion=?, grupo=? WHERE id=?");
    $stmt->execute([$_POST['codigo'], $_POST['descripcion'], $_POST['grupo'] ?: null, $_POST['id']]);
    header("Location: gestionar_producto.php"); exit;
}

// Eliminar producto
if(isset($_GET['eliminar'])){
    $stmt = $conn->prepare("DELETE FROM productos WHERE id=?");
    $stmt->execute([$_GET['eliminar']]);
    header("Location: gestionar_producto.php"); exit;
}

// Editar producto
if(isset($_GET['editar'])){
    $stmt = $conn->prepare("SELECT * FROM productos WHERE id=?");
    $stmt->execute([$_GET['editar']]);
    $producto = $stmt->fetch();
}

// Listar productos
$productos = $conn->query("SELECT * FROM productos ORDER BY id DESC")->fetchAll();
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<div class="contenido">
    <h2>📦 Gestión de Productos</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $producto['id'] ?? '' ?>">
        <label>Código:</label>
        <input type="text" name="codigo" value="<?= $producto['codigo'] ?? '' ?>" required>
        <label>Descripción:</label>
        <input type="text" name="descripcion" value="<?= $producto['descripcion'] ?? '' ?>" required>
        <label>Grupo (opcional):</label>
        <input type="text" name="grupo" value="<?= $producto['grupo'] ?? '' ?>">
        <button type="submit" name="<?= isset($producto)? 'actualizar':'crear' ?>">
            <?= isset($producto)? 'Actualizar':'Crear' ?> Producto
        </button>
    </form>

    <table>
        <tr><th>ID</th><th>Código</th><th>Descripción</th><th>Grupo</th><th>Acciones</th></tr>
        <?php foreach($productos as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['codigo'] ?></td>
            <td><?= $p['descripcion'] ?></td>
            <td><?= $p['grupo'] ?></td>
            <td>
                <a href="?editar=<?= $p['id'] ?>">Editar</a> |
                <a href="?eliminar=<?= $p['id'] ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body></html>
