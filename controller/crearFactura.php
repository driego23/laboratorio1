<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once 'databases/conexionDBcontroller.php';

    if (isset($_POST['nombre'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['email'], $_POST['productos_seleccionados'], $_POST['descuento'], $_POST['total_con_descuento'])) {
        $nombre = $_POST['nombre'];
        $tipo_documento = $_POST['tipo_documento'];
        $numero_documento = $_POST['numero_documento'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $productos_seleccionados = $_POST['productos_seleccionados'];
        $descuento = $_POST['descuento'];
        $total_con_descuento = $_POST['total_con_descuento'];
        $conexionDBController = new \App\controllers\databases\ConexionDBController();
        $fecha = date("Y-m-d H:i:s");
        $estado = 'Pagada'; 
        $sql = "INSERT INTO facturas (fecha, nombre, tipo_documento, numero_documento, telefono, email, estado, descuento, total_con_descuento) 
                VALUES ('$fecha', '$nombre', '$tipo_documento', '$numero_documento', '$telefono', '$email', '$estado', '$descuento', '$total_con_descuento')";
        
        if ($conexionDBController->execSql($sql)) {
            $factura_id = $conexionDBController->getLastInsertedId();
            foreach ($productos_seleccionados as $id_producto => $cantidad) {
                $sql_precio_producto = "SELECT precio FROM articulos WHERE id = $id_producto";
                $resultado_precio_producto = $conexionDBController->execSql($sql_precio_producto);

                if ($resultado_precio_producto && $resultado_precio_producto->num_rows == 1) {
                    $row_precio_producto = $resultado_precio_producto->fetch_assoc();
                    $precio_unitario = $row_precio_producto['precio'];
                    $sql_insert_detalle = "INSERT INTO detallefacturas (id_factura, id_producto, cantidad, precio_unitario) 
                                           VALUES ('$factura_id', '$id_producto', '$cantidad', '$precio_unitario')";
                    $conexionDBController->execSql($sql_insert_detalle);
                }
            }

            echo "Factura creada exitosamente.";
        } else {
            echo "Error al crear la factura. Por favor, inténtalo de nuevo.";
        }
    } else {
        echo "Error: Datos incompletos.";
    }
} else {
    echo "Error: Método de solicitud incorrecto.";
}
?>
