<?php

include_once '../controller/databases/ConexionDBController.php';


$conexionDBController = new \App\controllers\databases\ConexionDBController();


$id_cliente = $_GET['id_cliente']; 

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

    
    function obtenerDetallesFactura($id_factura, $conexion) {
        $query = "SELECT * FROM detallefacturas WHERE id = ?";
        $statement = $conexion->getConexion()->prepare($query);
        $statement->bind_param('i', $id_factura);
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

    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Consultar Facturas del Cliente</title>
        <link rel="stylesheet" href="CSS/estilos.css"> <!-- Agrega el enlace al archivo CSS -->
    </head>
    <body>
    <h1>Consultar Facturas del Cliente</h1>

    <!-- Mostramos las fechas de facturación únicas del cliente como enlaces -->
    <ul>
        <?php
        $fechas_facturacion_cliente = obtenerFechasFacturacionCliente($id_cliente, $conexionDBController);
        foreach ($fechas_facturacion_cliente as $fecha) {
            echo "<li><a href=\"consultar_facturas.php?id_cliente={$id_cliente}&fecha={$fecha}\">{$fecha}</a></li>";
        }
        ?>
    </ul>

    <!-- Mostramos las facturas del cliente por fecha -->
    <?php
    if (isset($_GET['fecha'])) {
        $fecha_seleccionada = $_GET['fecha'];
        $facturas_cliente = obtenerFacturasCliente($id_cliente, $conexionDBController);
        foreach ($facturas_cliente as $factura) {
            if (array_key_exists('fecha', $factura) && $factura['fecha'] == $fecha_seleccionada) {
                echo "<h2>Factura</h2>";
                echo "<p>Fecha de Emisión: {$factura['fecha']}</p>";

                // Obtenemos los detalles de la factura
                $detalles_factura = obtenerDetallesFactura($factura['idCliente'], $conexionDBController);
                echo "<h3>Detalles de la Factura:</h3>";
                echo "<ul>";
                foreach ($detalles_factura as $detalle) {
                    echo "<li>{$detalle['idArticulo']} - Cantidad: {$detalle['cantidad']} - Precio Unitario: {$detalle['precioUnitario']}</li>";
                }
                echo "</ul>";
            }
        }
    }
    ?>
    </body>
    </html>  
<?php } else {
    echo "No se pudo conectar a la base de datos.";
} ?>

