<?php

include_once '../controller/databases/ConexionDBController.php';


$conexionDBController = new \App\controllers\databases\ConexionDBController();


$id_cliente = $_GET['id_cliente'] ?? null;

if (!$id_cliente) {
    echo "No se ha especificado el ID del cliente";
    exit;
}


if ($conexionDBController) {
   
    function obtenerFacturasCliente($id_cliente, $conexion) {
        $query = "SELECT * FROM facturas WHERE idcliente = ?";
        $statement = $conexion->getConexion()->prepare($query);
        $statement->bind_param('i', $id_cliente);
        $statement->execute();
        $result = $statement->get_result();
        $facturas = [];
        while ($row = $result->fetch_assoc()) {
            $facturas[] = $row;
        }
        return $facturas;
    }

function obtenerDetallesFactura($refencia_factura, $conexion) {
    $query = "SELECT df.*, a.nombre as nombre_articulo, a.precio 
              FROM detallefacturas df 
              JOIN articulos a ON df.idArticulo = a.id 
              WHERE df.refenciaFactura = ?";
    $statement = $conexion->getConexion()->prepare($query);
    $statement->bind_param('s', $refencia_factura);
    $statement->execute();
    $result = $statement->get_result();
    $detalles = [];
    while ($row = $result->fetch_assoc()) {
        $detalles[] = $row;
    }
    return $detalles;
}


  
    function obtenerFechasFacturacionCliente($id_cliente, $conexion) {
        $query = "SELECT DISTINCT fecha FROM facturas WHERE idcliente = ?";
        $statement = $conexion->getConexion()->prepare($query);
        $statement->bind_param('i', $id_cliente);
        $statement->execute();
        $result = $statement->get_result();
        $fechas = [];
        while ($row = $result->fetch_assoc()) {
            $fechas[] = $row['fecha'];
        }
        return $fechas;
    }

    function obtenerInformacionCliente($id_cliente, $conexion) {
        $query = "SELECT * FROM clientes WHERE id = ?";
        $statement = $conexion->getConexion()->prepare($query);
        $statement->bind_param('i', $id_cliente);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_assoc();
    }

    $cliente = obtenerInformacionCliente($id_cliente, $conexionDBController);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Consultar Facturas del Cliente</title>
        <link rel="stylesheet" href="CSS/consultar.css"> 
    </head>
    <body>
    <div class="container">
        <h1>Consultar Facturas del Cliente</h1>

    
        <h2>Información del Cliente</h2>
        <?php if ($cliente): ?>
            <p>Nombre: <?php echo htmlspecialchars($cliente['nombreCompleto']); ?></p>
            <p>Tipo de Documento: <?php echo htmlspecialchars($cliente['tipoDocumento']); ?></p>
            <p>Número de Documento: <?php echo htmlspecialchars($cliente['numeroDocumento']); ?></p>
            <p>Teléfono: <?php echo htmlspecialchars($cliente['telefono']); ?></p>
            <p>Email: <?php echo htmlspecialchars($cliente['email']); ?></p>
        <?php else: ?>
            <p>No se encontró la información del cliente.</p>
        <?php endif; ?>

      
        <h2>Fechas de Facturación</h2>
        <ul>
            <?php
            $fechas_facturacion_cliente = obtenerFechasFacturacionCliente($id_cliente, $conexionDBController);
            foreach ($fechas_facturacion_cliente as $fecha) {
                echo "<li><a href=\"consultar_facturas.php?id_cliente={$id_cliente}&fecha={$fecha}\">{$fecha}</a></li>";
            }
            ?>
        </ul>
<?php
if (isset($_GET['fecha'])) {
    $fecha_seleccionada = $_GET['fecha'];
    $facturas_cliente = obtenerFacturasCliente($id_cliente, $conexionDBController);
    foreach ($facturas_cliente as $factura) {
        if (array_key_exists('fecha', $factura) && $factura['fecha'] == $fecha_seleccionada) {
            echo "<h2>Factura</h2>";
            echo "<p>Fecha de Emisión: {$factura['fecha']}</p>";

           
            $detalles_factura = obtenerDetallesFactura($factura['refencia'], $conexionDBController);
            echo "<h3>Detalles de la Factura:</h3>";
            echo "<ul>";
            foreach ($detalles_factura as $detalle) {
                echo "<li>{$detalle['nombre_articulo']} - Cantidad: {$detalle['cantidad']} - Precio Unitario: {$detalle['precioUnitario']}</li>";
            }
            echo "</ul>";
        }
    }
}
?>

    </div>
    </body>
    </html>  
<?php } else {
    echo "No se pudo conectar a la base de datos.";
} ?>
