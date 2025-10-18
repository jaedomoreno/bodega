<?php
session_start();
include 'conexion.php';

$nombre = trim($_POST['nombre']);
$clave = md5($_POST['clave']);  // codifica la clave en MD5

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre = ? AND clave = ? AND estatus = 1");
$stmt->execute([$nombre, $clave]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $_SESSION['usuario'] = $user['nombre'];
    $_SESSION['nombre'] = $user['nombre'];
    header("Location: index.php");
    exit;
} else {
    header("Location: login.php?error=1");
    exit;
}
?>
