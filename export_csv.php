<?php
include 'db.php';

$sucursal_filter = $_GET['sucursal'] ?? '';
$sorteo_filter = $_GET['sorteo'] ?? '';
$search_query = $_GET['search'] ?? '';

$query = "SELECT * FROM clients WHERE 1=1";
if ($sucursal_filter) {
    $query .= " AND sucursal = :sucursal";
}
if ($sorteo_filter) {
    $query .= " AND sorteo = :sorteo";
}
if ($search_query) {
    $query .= " AND (dni LIKE :search OR nombre LIKE :search OR factura LIKE :search)";
}

$stmt = $db->prepare($query);
if ($sucursal_filter) {
    $stmt->bindValue(':sucursal', $sucursal_filter);
}
if ($sorteo_filter) {
    $stmt->bindValue(':sorteo', $sorteo_filter);
}
if ($search_query) {
    $stmt->bindValue(':search', "%$search_query%");
}
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="clientes.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Nombre', 'DNI', 'Teléfono', 'N° de Factura', 'Cantidad de Cupones', 'Sorteo', 'Sucursal']);
foreach ($clients as $client) {
    fputcsv($output, $client);
}
fclose($output);
exit();
?>
