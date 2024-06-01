<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Cliente</title>
    <link rel="stylesheet" href="../Views/CSS/seleccion_productos.css">
</head>
<body>
    <h2>Información del Cliente</h2>
    <form action="../controller/procesar_cliente.php" method="POST">
        <label for="nombreCompleto">Nombre Completo:</label>
        <input type="text" id="nombreCompleto" name="nombreCompleto" required><br><br>

        <label for="tipoDocumento">Tipo de Documento:</label>
        <select id="tipoDocumento" name="tipoDocumento" required>
            <option value="CC">Cédula de Ciudadanía</option>
            <option value="CE">Cédula de Extranjería</option>
            <option value="NIT">NIT</option>
            <option value="TI">Tarjeta de Identidad</option>
            <option value="Otro">Otro</option>
        </select><br><br>

        <label for="numeroDocumento">Número de Documento:</label>
        <input type="text" id="numeroDocumento" name="numeroDocumento" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit">Continuar</button>
    </form>
</body>
</html>
