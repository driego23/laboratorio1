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
        if (isset($_GET['nombreCompleto']) && isset($_GET['tipoDocumento']) && isset($_GET['numeroDocumento']) && isset($_GET['telefono']) && isset($_GET['email'])) {
            echo "<h4>Información del Cliente:</h4>";
            echo "Nombre: " . htmlspecialchars($_GET['nombreCompleto']) . "<br>";
            echo "Tipo de Documento: " . htmlspecialchars($_GET['tipoDocumento']) . "<br>";
            echo "Número de Documento: " . htmlspecialchars($_GET['numeroDocumento']) . "<br>";
            echo "Teléfono: " . htmlspecialchars($_GET['telefono']) . "<br>";
            echo "Email: " . htmlspecialchars($_GET['email']) . "<br>";
        } else {
            echo "<p>No se proporcionó información del cliente.</p>";
        }
        if (isset($_GET['productos']) && is_array($_GET['productos']) && !empty($_GET['productos'])) {
            echo "<h4>Productos:</h4>";
            $total = 0;
            $subtotal_productos = 0;
            include_once '../controller/databases/ConexionDBController.php';
            $conexionDBController = new \App\controllers\databases\ConexionDBController();
            foreach ($_GET['productos'] as $id_producto => $cantidad) {
                $sql = "SELECT nombre, precio FROM articulos WHERE id = $id_producto";
                $resultado = $conexionDBController->execSql($sql);
                if ($resultado && $resultado->num_rows == 1) {
                    $row = $resultado->fetch_assoc();
                    $nombre_producto = $row['nombre'];
                    $precio_unitario = $row['precio'];
                    $subtotal_producto = floatval($cantidad) * floatval($precio_unitario);
                    echo "- " . htmlspecialchars($nombre_producto) . ": " . htmlspecialchars($cantidad) . " x $" . htmlspecialchars($precio_unitario) . " = $" . htmlspecialchars($subtotal_producto) . "<br>";
                    $subtotal_productos += $subtotal_producto;
                }
            }
            echo "<h4>Subtotal: $" . htmlspecialchars($subtotal_productos) . "</h4>";
            $descuento = 0;
            if ($subtotal_productos > 200000) {
                $descuento = 10;
            } elseif ($subtotal_productos > 100000) {
                $descuento = 5;
            }
            $total_con_descuento = $subtotal_productos - ($subtotal_productos * ($descuento / 100));
            if ($descuento > 0) {
                echo "Descuento aplicado: " . htmlspecialchars($descuento) . "%<br>";
                echo "Total con descuento: $" . htmlspecialchars($total_con_descuento) . "<br>";
            } else {
                echo "<p>No se aplicó ningún descuento.</p>";
            }
        } else {
            echo "<p>No hay productos seleccionados.</p>";
        }
        ?>
        <form action="../controller/crearFactura.php" method="post">
            <button type="submit">Guardar Factura</button>
        </form>
    </div>
</body>
</html>
