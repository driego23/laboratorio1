<?php
include_once '../controller/databases/ConexionDBController.php';

$conexionDBController = new \App\controllers\databases\ConexionDBController();
$sql = "SELECT * FROM facturas";
$resultado = $conexionDBController->execSql($sql);

if ($resultado && $resultado->num_rows > 0) {
    echo "<h2>Facturas</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Número de Factura</th><th>Fecha</th><th>Estado</th></tr>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($fila['numero_factura']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['fecha']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['estado']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No se encontraron facturas.</p>";
}
?>
