<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: login.php");
include 'conexion.php';
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<div class="contenido">
    <h2>📊 Dashboard SubiTodo</h2>
    <p>Bienvenido, <?= $_SESSION['usuario'] ?>!</p>

    <?php
    // Ejemplo: mostrar estadísticas simples
    $total_choferes = $conn->query("SELECT COUNT(*) FROM choferes")->fetchColumn();
    $total_productos = $conn->query("SELECT COUNT(*) FROM productos")->fetchColumn();
    $total_salidas = $conn->query("SELECT COUNT(*) FROM salidas")->fetchColumn();
    ?>
    <div style="display:flex; gap:20px; margin-top:20px;">
        <div style="flex:1; padding:20px; background:#3b82f6; color:white; border-radius:12px; text-align:center;">
            <h3>Choferes</h3>
            <p style="font-size:24px;"><?= $total_choferes ?></p>
        </div>
        <div style="flex:1; padding:20px; background:#10b981; color:white; border-radius:12px; text-align:center;">
            <h3>Productos</h3>
            <p style="font-size:24px;"><?= $total_productos ?></p>
        </div>
        <div style="flex:1; padding:20px; background:#f59e0b; color:white; border-radius:12px; text-align:center;">
            <h3>Salidas</h3>
            <p style="font-size:24px;"><?= $total_salidas ?></p>
        </div>
    </div>
</div>

</body>

</html>