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
        <?php
        $nombreCompleto = isset($_GET['nombreCompleto']) ? htmlspecialchars($_GET['nombreCompleto']) : '';
        $tipoDocumento = isset($_GET['tipoDocumento']) ? htmlspecialchars($_GET['tipoDocumento']) : '';
        $numeroDocumento = isset($_GET['numeroDocumento']) ? htmlspecialchars($_GET['numeroDocumento']) : '';
        $telefono = isset($_GET['telefono']) ? htmlspecialchars($_GET['telefono']) : '';
        $email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
        ?>
        <input type="hidden" name="nombreCompleto" value="<?php echo $nombreCompleto; ?>">
        <input type="hidden" name="tipoDocumento" value="<?php echo $tipoDocumento; ?>">
        <input type="hidden" name="numeroDocumento" value="<?php echo $numeroDocumento; ?>">
        <input type="hidden" name="telefono" value="<?php echo $telefono; ?>">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <h3>Productos</h3>
        <?php
        include_once '../controller/productos_disponibles.php';
        $productos = include '../controller/productos_disponibles.php';

        if (isset($productos) && !empty($productos)) {
            foreach ($productos as $producto) {
                echo '<label for="producto' . $producto['id'] . '">' . $producto['nombre'] . ' ($' . $producto['precio'] . ')</label>';
                echo '<input type="number" id="producto' . $producto['id'] . '" name="producto' . $producto['id'] . '" min="0"><br><br>';
            }
        } else {
            echo '<p>No hay productos disponibles en este momento.</p>';
        }
        ?>
        <button type="submit">Continuar</button>
    </form>
</body>
</html>
