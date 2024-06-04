<?php
include_once '../controller/databases/ConexionDBController.php';

$nombre = $_GET['nombre'] ?? '';
$tipo_documento = $_GET['tipo_documento'] ?? '';
$numero_documento = $_GET['numero_documento'] ?? '';
$telefono = $_GET['telefono'] ?? '';
$email = $_GET['email'] ?? '';
$productos = $_GET['productos'] ?? [];
$descuento = $_GET['descuento'] ?? '';
$total_con_descuento = $_GET['total_con_descuento'] ?? '';
$conexionDBController = new \App\controllers\databases\ConexionDBController();
$sql_cliente = "SELECT id FROM clientes WHERE numeroDocumento = '$numero_documento'";
$resultado = $conexionDBController->execSql($sql_cliente);
$id_cliente = null;

if ($resultado && $resultado->num_rows == 1) {
    $row = $resultado->fetch_assoc();
    $id_cliente = $row['id'];
} else {
    $sql_insert_cliente = "INSERT INTO clientes (nombreCompleto, tipoDocumento, numeroDocumento, email, telefono) 
                           VALUES ('$nombre', '$tipo_documento', '$numero_documento', '$email', '$telefono')";
    if ($conexionDBController->execSql($sql_insert_cliente)) {
        $id_cliente = $conexionDBController->getConexion()->insert_id;
    }
}

session_start();
$_SESSION['id_cliente'] = $id_cliente;

$cliente = [
    'nombre' => $nombre,
    'tipo_documento' => $tipo_documento,
    'numero_documento' => $numero_documento,
    'telefono' => $telefono,
    'email' => $email
];
?>

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
        $numero_referencia = uniqid();
        $fecha_compra = date("Y-m-d H:i:s");

        echo "Número de referencia: " . $numero_referencia . "<br>";
        echo "Fecha de compra: " . $fecha_compra . "<br>";

        if (!empty($cliente['nombre']) && !empty($cliente['tipo_documento']) && !empty($cliente['numero_documento']) && !empty($cliente['telefono']) && !empty($cliente['email'])) {
            echo "<h4>Información del Cliente:</h4>";
            echo "Nombre: " . htmlspecialchars($cliente['nombre']) . "<br>";
            echo "Tipo de Documento: " . htmlspecialchars($cliente['tipo_documento']) . "<br>";
            echo "Número de Documento: " . htmlspecialchars($cliente['numero_documento']) . "<br>";
            echo "Teléfono: " . htmlspecialchars($cliente['telefono']) . "<br>";
            echo "Email: " . htmlspecialchars($cliente['email']) . "<br>";
        } else {
            echo "<p>No se proporcionó información del cliente.</p>";
        }

        if (!empty($productos)) {
            echo "<h4>Productos:</h4>";
            $subtotal = 0;
            foreach ($productos as $id_producto => $cantidad) {
                $sql = "SELECT nombre, precio FROM articulos WHERE id = $id_producto";
                $resultado = $conexionDBController->execSql($sql);
                if ($resultado && $resultado->num_rows == 1) {
                    $row = $resultado->fetch_assoc();
                    $nombre_producto = $row['nombre'];
                    $precio_producto = $row['precio'];
                    $valor_total = $cantidad * $precio_producto;
                    $subtotal += $valor_total;
                    echo "- " . htmlspecialchars($nombre_producto) . ": " . htmlspecialchars($cantidad) . " x $" . htmlspecialchars($precio_producto) . " = $" . htmlspecialchars($valor_total) . "<br>";
                }
            }
            echo "Subtotal: $" . htmlspecialchars($subtotal) . "<br>";
        } else {
            echo "<p>No hay productos seleccionados.</p>";
        }

        if (!empty($descuento)) {
            echo "Descuento aplicado: " . htmlspecialchars($descuento) . "%<br>";
        } else {
            echo "<p>No se aplicó ningún descuento.</p>";
        }

        if (!empty($total_con_descuento)) {
            echo "Total con descuento: $" . htmlspecialchars($total_con_descuento) . "<br>";
        }
        ?>

        <form action="../controller/crearFactura.php" method="post">
            <input type="hidden" name="numero_referencia" value="<?php echo $numero_referencia; ?>">
            <input type="hidden" name="fecha_compra" value="<?php echo $fecha_compra; ?>">
            <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($id_cliente); ?>">
            <input type="hidden" name="cliente" value='<?php echo json_encode($cliente); ?>'>
            <input type="hidden" name="productos" value='<?php echo json_encode($productos); ?>'>
            <input type="hidden" name="descuento" value="<?php echo htmlspecialchars($descuento); ?>">
            <input type="hidden" name="total_con_descuento" value="<?php echo htmlspecialchars($total_con_descuento); ?>">
            <button type="submit">Guardar Factura</button>
        </form>
        <a href="consultar_facturas.php?id_cliente=<?php echo $id_cliente; ?>">Consultar Facturas</a>
    </div>
</body>
</html>
