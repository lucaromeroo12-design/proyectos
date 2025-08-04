<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Casa Lito</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Panel de Administración</h1>
        <form method="GET">
            <input type="text" name="search" placeholder="Buscar...">
            <select name="sucursal">
                <option value="">Todas las Sucursales</option>
                <option value="Berazategui">Berazategui</option>
                <option value="Solano">Solano</option>
                <option value="Quilmes Oeste">Quilmes Oeste</option>
            </select>
            <select name="sorteo">
                <option value="">Todos los Sorteos</option>
                <?php include 'config.php'; foreach ($sorteos as $sorteo): ?>
                    <option value="<?= $sorteo ?>"><?= $sorteo ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                    <th>N° de Factura</th>
                    <th>Cantidad de Cupones</th>
                    <th>Sorteo</th>
                    <th>Sucursal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= htmlspecialchars($client['nombre']) ?></td>
                        <td><?= htmlspecialchars($client['dni']) ?></td>
                        <td><?= htmlspecialchars($client['telefono']) ?></td>
                        <td><?= htmlspecialchars($client['factura']) ?></td>
                        <td><?= htmlspecialchars($client['cupones']) ?></td>
                        <td><?= htmlspecialchars($client['sorteo']) ?></td>
                        <td><?= htmlspecialchars($client['sucursal']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="export_csv.php?sucursal=<?= $sucursal_filter ?>&sorteo=<?= $sorteo_filter ?>&search=<?= $search_query ?>">Exportar CSV</a>
    </div>
</body>
</html>
