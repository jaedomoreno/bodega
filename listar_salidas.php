<?php
session_start();
if(!isset($_SESSION['usuario'])) header("Location: login.php");
include 'conexion.php';

$salidas = $conn->query("SELECT * FROM salidas ORDER BY fecha_salida DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<div class="contenido">
<h2>📋 Historial de Salidas</h2>

<table>
<tr><th>Boleta</th><th>Chofer</th><th>Fecha</th><th>Firma</th><th>Productos</th></tr>
<?php foreach($salidas as $s): ?>
<tr>
    <td><?= $s['codigo_boleta'] ?></td>
    <td><?= $s['chofer'] ?></td>
    <td><?= $s['fecha_salida'] ?></td>
    <td><?php if($s['firma']) echo "<img src='".$s['firma']."' width='80'>"; ?></td>
    <td>
        <ul>
        <?php
        $detalles = $conn->prepare("SELECT p.codigo,p.descripcion FROM detalle_salida d JOIN productos p ON d.producto_id=p.id WHERE d.salida_id=?");
        $detalles->execute([$s['id']]);
        foreach($detalles->fetchAll(PDO::FETCH_ASSOC) as $d) echo "<li>{$d['codigo']} - {$d['descripcion']}</li>";
        ?>
        </ul>
    </td>
</tr>
<?php endforeach; ?>
</table>
</div>
</body></html>
