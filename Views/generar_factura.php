<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Compra</title>
    <link rel="stylesheet" href="../Views/CSS/factura.css">
</head>
<body>
    <div class="container">
        <h2>Factura de Compra</h2>
        <h3>Detalles de la Factura</h3>
        <?php
        echo "Número de referencia: " . uniqid() . "<br>";
        echo "Fecha de compra: " . date("Y-m-d H:i:s") . "<br>";
        if (isset($_GET['nombre']) && isset($_GET['tipo_documento']) && isset($_GET['numero_documento']) && isset($_GET['telefono']) && isset($_GET['email'])) {
            echo "<h4>Información del Cliente:</h4>";
            echo "Nombre: " . htmlspecialchars($_GET['nombre']) . "<br>";
            echo "Tipo de Documento: " . htmlspecialchars($_GET['tipo_documento']) . "<br>";
            echo "Número de Documento: " . htmlspecialchars($_GET['numero_documento']) . "<br>";
            echo "Teléfono: " . htmlspecialchars($_GET['telefono']) . "<br>";
            echo "Email: " . htmlspecialchars($_GET['email']) . "<br>";
        } else {
            echo "<p>No se proporcionó información del cliente.</p>";
        }

        if (isset($_GET['productos']) && is_array($_GET['productos']) && !empty($_GET['productos'])) {
            echo "<h4>Productos:</h4>";
            foreach ($_GET['productos'] as $id_producto => $cantidad) {
                include_once '../controller/databases/ConexionDBController.php';
                $conexionDBController = new \App\controllers\databases\ConexionDBController();
                $sql = "SELECT nombre FROM articulos WHERE id = $id_producto";
                $resultado = $conexionDBController->execSql($sql);
                if ($resultado && $resultado->num_rows == 1) {
                    $row = $resultado->fetch_assoc();
                    $nombre_producto = $row['nombre'];
                    echo "- " . htmlspecialchars($nombre_producto) . ": " . htmlspecialchars($cantidad) . "<br>";
                }
            }
        } else {
            echo "<p>No hay productos seleccionados.</p>";
        }
        if (isset($_GET['descuento'])) {
            echo "Descuento aplicado: " . htmlspecialchars($_GET['descuento']) . "%<br>";
        } else {
            echo "<p>No se aplicó ningún descuento.</p>";
        }
        if (isset($_GET['total_con_descuento'])) {
            echo "Total a pagar: $" . htmlspecialchars($_GET['total_con_descuento']) . "<br>";
        }

        ?>
        <form action="../controller/crearFactura.php" method="post">
    <button type="submit">Guardar Factura</button>
</form>
    </div>
</body>
</html>
