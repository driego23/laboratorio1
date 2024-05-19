<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Productos</title>
    <link rel="stylesheet" href="../Views/CSS/seleccion_productos.css">
</head>
<body>
    <h2>Selección de Productos</h2>
    <form action="../controller/procesar_compra.php" method="POST">
        <h3>Información del Cliente</h3>
        <label for="nombre">Nombre Completo:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="tipo_documento">Tipo de Documento:</label>
        <select id="tipo_documento" name="tipo_documento" required>
                <option value="CC">Cédula de Ciudadanía</option>
                <option value="CE">Cédula de Extranjería</option>
                <option value="NIT">NIT</option>
                <option value="TI">Tarjeta de Identidad</option>
                <option value="Otro">Otro</option>
      </select><br><br>
      

        <label for="numero_documento">Número de Documento:</label>
        <input type="text" id="numero_documento" name="numero_documento" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <h3>Productos</h3>
        <?php
        // Incluir el archivo productos_disponibles.php para obtener los productos
        include_once '../controller/productos_disponibles.php';
        $productos = include '../controller/productos_disponibles.php';

        // Verificar si la variable $productos está definida y no es nula
        if (isset($productos) && !empty($productos)) {
            // Mostrar los productos en el formulario
            foreach ($productos as $producto) {
                echo '<label for="producto' . $producto['id'] . '">' . $producto['nombre'] . ' ($' . $producto['precio'] . ')</label>';
                echo '<input type="number" id="producto' . $producto['id'] . '" name="producto' . $producto['id'] . '" min="0"><br><br>';
            }
        } else {
            // Si no se obtienen productos, mostrar un mensaje de error
            echo '<p>No hay productos disponibles en este momento.</p>';
        }
        ?>
        <button type="submit">Continuar</button>
    </form>
</body>
</html>
