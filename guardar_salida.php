<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: login.php");
include 'conexion.php';

$codigo_boleta = $_POST['codigo_boleta'];
$chofer = $_POST['chofer'];

// Guardar firma
$firma = null;
if (isset($_FILES['firma']) && $_FILES['firma']['error'] == 0) {
    $ext = pathinfo($_FILES['firma']['name'], PATHINFO_EXTENSION);
    $firma = 'firmas/' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['firma']['tmp_name'], $firma);
}

// Guardar boleta
$stmt = $conn->prepare("INSERT INTO salidas (codigo_boleta, chofer, firma) VALUES (?, ?, ?)");
$stmt->execute([$codigo_boleta, $chofer, $firma]);
$salida_id = $conn->lastInsertId();

// Guardar productos
$codigos = $_POST['codigos'];
$descripciones = $_POST['descripciones'];

for ($i = 0; $i < count($codigos); $i++) {
    // Verificar si el producto ya existe
    $stmt = $conn->prepare("SELECT id FROM productos WHERE codigo=?");
    $stmt->execute([$codigos[$i]]);
    $prod = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$prod) {
        // Crear producto nuevo
        $stmt = $conn->prepare("INSERT INTO productos (codigo, descripcion) VALUES (?, ?)");
        $stmt->execute([$codigos[$i], $descripciones[$i]]);
        $producto_id = $conn->lastInsertId();
    } else {
        $producto_id = $prod['id'];
    }

    // Guardar detalle
    $stmt = $conn->prepare("INSERT INTO detalle_salida (salida_id, producto_id) VALUES (?, ?)");
    $stmt->execute([$salida_id, $producto_id]);
}

header("Location: listar_salidas.php");
exit;
