<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Productos</title>
    <link rel="stylesheet" href="../CSS/seleccion_productos.css">
</head>
<body>
    <h2>Selección de Productos</h2>
    <form action="procesar_compra.php" method="POST">
        <?php
        // Incluir el archivo productos_disponibles.php para obtener los productos
        include_once 'productos_disponibles.php';

        // Mostrar los productos en el formulario
        foreach ($productos as $producto) {
            echo '<label for="producto' . $producto['id'] . '">' . $producto['nombre'] . ' ($' . $producto['precio'] . ')</label>';
            echo '<input type="number" id="producto' . $producto['id'] . '" name="producto' . $producto['id'] . '" min="0"><br><br>';
        }
        ?>
        <button type="submit">Continuar</button>
    </form>
</body>
</html>
