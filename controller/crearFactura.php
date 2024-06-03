<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Manejo de errores
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once 'databases/conexionDBcontroller.php';

    // Obtener los datos del formulario
    $numero_referencia = $_POST['numero_referencia'] ?? '';
    $fecha_compra = $_POST['fecha_compra'] ?? '';
    $id_cliente = $_POST['id_cliente'] ?? '';
    $descuento = $_POST['descuento'] ?? '';
    $cliente_json = $_POST['cliente'] ?? '';
    $productos_json = $_POST['productos'] ?? '';

    // Decodificar los datos JSON
    $cliente = json_decode($cliente_json, true);
    $productos = json_decode($productos_json, true);

    // Verificar que los datos necesarios no estén vacíos
    if ($numero_referencia !== '' && $fecha_compra !== '' && $id_cliente !== '' && $descuento !== '' && !empty($productos)) {
        try {
            // Crear una instancia de la conexión a la base de datos
            $conexionDBController = new \App\controllers\databases\ConexionDBController();

            // Insertar factura en la tabla 'facturas'
            $sql_factura = "INSERT INTO facturas (refencia, fecha, idCliente, estado, descuento) 
                            VALUES ('$numero_referencia', '$fecha_compra', '$id_cliente', 'Pagada', '$descuento')";

            // Ejecutar la consulta SQL para la factura
            if ($conexionDBController->execSql($sql_factura)) {
                // Obtener el ID de la factura insertada
                // $factura_id = $conexionDBController->getConexion()->insert_id;

                // Insertar detalles de factura en la tabla 'detallefacturas'
                foreach ($productos as $id_producto => $cantidad) {
                    // Obtener el precio unitario del artículo desde la base de datos
                    $sql_precio_unitario = "SELECT precio FROM articulos WHERE id = '$id_producto'";
                    $resultado = $conexionDBController->execSql($sql_precio_unitario);
                    if ($resultado && $resultado->num_rows == 1) {
                        $fila = $resultado->fetch_assoc();
                        $precio_unitario = $fila['precio'];

                        // Insertar detalle de factura
                        $sql_detalle = "INSERT INTO detallefacturas (cantidad, precioUnitario, idArticulo, refenciaFactura) 
                                        VALUES ('$cantidad', '$precio_unitario', '$id_producto', '$numero_referencia')";
                        $conexionDBController->execSql($sql_detalle);
                    } else {
                        throw new Exception("Error al obtener el precio del artículo con ID $id_producto");
                    }
                }

                echo json_encode(['message' => 'Factura creada exitosamente.']);
            } else {
                echo json_encode(['message' => 'Error al crear la factura. Por favor, inténtalo de nuevo.']);
            }
        } catch (Exception $e) {
            echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['message' => 'Error: Datos incompletos.']);
    }
} else {
    echo json_encode(['message' => 'Error: Método de solicitud incorrecto.']);
}
?>

