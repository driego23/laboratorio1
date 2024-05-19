<?php
echo "<pre>";
print_r($_POST);
echo "</pre>";

include_once 'databases/ConexionDBController.php';

$conexionDBController = new \App\controllers\databases\ConexionDBController();

$productos_seleccionados = array();
foreach ($_POST as $key => $value) {
    if (strpos($key, 'producto') === 0) {
        $id_producto = substr($key, strlen('producto'));
        $productos_seleccionados[$id_producto] = $value;
    }
}

$total = 0;
foreach ($productos_seleccionados as $id_producto => $cantidad) {

    $sql = "SELECT precio FROM articulos WHERE id = $id_producto";
    $resultado = $conexionDBController->execSql($sql);
    if ($resultado && $resultado->num_rows == 1) {
        $row = $resultado->fetch_assoc();
        $precio_producto = floatval($row['precio']);
        $cantidad = intval($cantidad);
        $subtotal_producto = $precio_producto * $cantidad;
        $total += $subtotal_producto;
    }
}
$descuento = 0;
if ($total > 200000) {
    $descuento = 10;
} elseif ($total > 100000) {
    $descuento = 5;
}

$total_con_descuento = $total - ($total * ($descuento / 100));

$cliente_info = array(
    'nombre' => $_POST['nombre'],
    'tipo_documento' => $_POST['tipo_documento'],
    'numero_documento' => $_POST['numero_documento'],
    'telefono' => $_POST['telefono'],
    'email' => $_POST['email']
);

$productos_info = http_build_query(array('productos' => $productos_seleccionados));

header("Location: ../Views/generar_factura.php?" . http_build_query($cliente_info) . "&" . $productos_info . "&descuento=$descuento&total_con_descuento=$total_con_descuento");
exit();
?>
