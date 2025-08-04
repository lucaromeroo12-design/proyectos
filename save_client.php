<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $factura = $_POST['factura'];
    $cupones = $_POST['cupones'];
    $sorteo = $_POST['sorteo'];
    $sucursal = $_POST['sucursal'];

    $stmt = $db->prepare("INSERT INTO clients (nombre, dni, telefono, factura, cupones, sorteo, sucursal) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $dni, $telefono, $factura, $cupones, $sorteo, $sucursal]);

    header('Location: index.html');
}
?>
