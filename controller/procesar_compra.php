<?php
// Obtener los datos de los productos seleccionados
$productos_seleccionados = array();
foreach ($_POST as $key => $value) {
    // Verificar si el campo es un producto (comienza con "producto")
    if (strpos($key, 'producto') === 0) {
        // Obtener el ID del producto
        $id_producto = substr($key, strlen('producto'));
        // Guardar la cantidad seleccionada del producto en el array
        $productos_seleccionados[$id_producto] = $value;
    }
}

// Calcular el valor total de la compra
$total = 0;
foreach ($productos_seleccionados as $id_producto => $cantidad) {
    // Obtener el precio del producto desde la base de datos
    // Realizar la consulta SQL para obtener el precio del producto con el ID dado
    $sql = "SELECT precio FROM articulos WHERE id = $id_producto";
    // Ejecutar la consulta SQL
    $resultado = $conexionDBController->execSql($sql);
    // Verificar si se obtuvo un resultado
    if ($resultado && $resultado->num_rows == 1) {
        // Obtener el precio del producto
        $row = $resultado->fetch_assoc();
        $precio_producto = $row['precio'];
        // Calcular el subtotal del producto (precio x cantidad)
        $subtotal_producto = $precio_producto * $cantidad;
        // Agregar el subtotal al total
        $total += $subtotal_producto;
    }
}

// Aplicar descuentos si es necesario
$descuento = 0;
if ($total > 200000) {
    // Descuento del 10% para compras mayores a $200,000
    $descuento = 10;
} elseif ($total > 100000) {
    // Descuento del 5% para compras mayores a $100,000
    $descuento = 5;
}

// Calcular el total con descuento
$total_con_descuento = $total - ($total * ($descuento / 100));

// Mostrar el valor total de la compra y el descuento aplicado
echo "Total a pagar: $" . $total_con_descuento . "<br>";
echo "Descuento aplicado: " . $descuento . "%";

header("Location: generar_factura.php");
exit();
?>
