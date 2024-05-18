<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Compra</title>
    <link rel="stylesheet" href="CSS/factura.css">
</head>
<body>
    <div class="container">
        <h2>Factura de Compra</h2>
        <h3>Detalles de la Factura</h3>
        <?php
        // Mostrar el número de referencia de la factura (puede ser generado automáticamente)
        echo "Número de referencia: " . uniqid() . "<br>";
        // Mostrar la fecha de la compra (fecha actual)
        echo "Fecha de compra: " . date("Y-m-d H:i:s") . "<br>";
        // Mostrar la información del cliente si está disponible
        if (isset($_POST['nombre']) && isset($_POST['tipo_documento']) && isset($_POST['numero_documento']) && isset($_POST['telefono']) && isset($_POST['email'])) {
            echo "<h4>Información del Cliente:</h4>";
            echo "Nombre: " . $_POST['nombre'] . "<br>";
            echo "Tipo de Documento: " . $_POST['tipo_documento'] . "<br>";
            echo "Número de Documento: " . $_POST['numero_documento'] . "<br>";
            echo "Teléfono: " . $_POST['telefono'] . "<br>";
            echo "Email: " . $_POST['email'] . "<br>";
        } else {
            echo "<p>No se proporcionó información del cliente.</p>";
        }

        // Verificar si hay productos seleccionados
        if (isset($productos_seleccionados) && is_array($productos_seleccionados) && !empty($productos_seleccionados)) {
            // Mostrar la lista de productos seleccionados y su cantidad
            echo "<h4>Productos:</h4>";
            foreach ($productos_seleccionados as $id_producto => $cantidad) {
                // Obtener el nombre del producto desde la base de datos
                // Realizar la consulta SQL para obtener el nombre del producto con el ID dado
                $sql = "SELECT nombre FROM articulos WHERE id = $id_producto";
                // Ejecutar la consulta SQL
                $resultado = $conexionDBController->execSql($sql);
                // Verificar si se obtuvo un resultado
                if ($resultado && $resultado->num_rows == 1) {
                    // Obtener el nombre del producto
                    $row = $resultado->fetch_assoc();
                    $nombre_producto = $row['nombre'];
                    // Mostrar el nombre del producto y la cantidad
                    echo "- " . $nombre_producto . ": " . $cantidad . "<br>";
                }
            }
        } else {
            echo "<p>No hay productos seleccionados.</p>";
        }

        // Mostrar el descuento aplicado si está disponible
        if (isset($descuento)) {
            echo "Descuento aplicado: " . $descuento . "%";
        } else {
            echo "<p>No se aplicó ningún descuento.</p>";
        }
        ?>
    </div>
</body>
</html>
