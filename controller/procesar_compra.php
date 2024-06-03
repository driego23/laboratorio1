<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once 'databases/ConexionDBController.php';
    $conexionDBController = new \App\controllers\databases\ConexionDBController();

    $nombreCompleto = $_POST['nombreCompleto'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroDocumento = $_POST['numeroDocumento'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $productos = array();
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'producto') === 0 && intval($value) > 0) {
            $id_producto = substr($key, strlen('producto'));
            $productos[$id_producto] = $value;
        }
    }
    $total = 0;
    foreach ($productos as $id_producto => $cantidad) {
        $sql = "SELECT nombre, precio FROM articulos WHERE id = $id_producto";
        $resultado = $conexionDBController->execSql($sql);
        if ($resultado && $resultado->num_rows == 1) {
            $row = $resultado->fetch_assoc();
            $nombre_producto = $row['nombre'];
            $precio_producto = $row['precio'];
            $subtotal_producto = floatval($precio_producto) * intval($cantidad);
            $total += $subtotal_producto;
            echo "Nombre del producto: " . htmlspecialchars($nombre_producto) . "<br>";
            echo "Precio unitario: $" . htmlspecialchars($precio_producto) . "<br>";
            echo "Cantidad: " . htmlspecialchars($cantidad) . "<br>";
            echo "Valor total: $" . htmlspecialchars($subtotal_producto) . "<br><br>";
        }
    }
    $descuento = 0;
    if ($total > 200000) {
        $descuento = 10;
    } elseif ($total > 100000) {
        $descuento = 5;
    }
    $total_con_descuento = $total - ($total * ($descuento / 100));
    echo "Descuento aplicado: " . htmlspecialchars($descuento) . "%<br>";
    echo "Total a pagar: $" . htmlspecialchars($total_con_descuento) . "<br>";
    $cliente_info = array(
        'nombre' => $nombreCompleto,
        'tipo_documento' => $tipoDocumento,
        'numero_documento' => $numeroDocumento,
        'telefono' => $telefono,
        'email' => $email
    );
    $productos_info = http_build_query(array('productos' => $productos));
    header("Location: ../Views/generar_factura.php?" . http_build_query($cliente_info) . "&" . $productos_info . "&descuento=$descuento&total_con_descuento=$total_con_descuento");
    exit();
}
?>
