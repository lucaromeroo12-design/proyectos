<?php
$db = new PDO('sqlite:clients.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE IF NOT EXISTS clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    dni TEXT NOT NULL,
    telefono TEXT NOT NULL,
    factura TEXT NOT NULL,
    cupones INTEGER NOT NULL,
    sorteo TEXT NOT NULL,
    sucursal TEXT NOT NULL
)");
?>
