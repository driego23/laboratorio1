<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente</title>
    <link rel="stylesheet" href="CSS/registro_cliente.css">
</head>
<body>
    <h2>Registro de Cliente</h2>
    <form action="../controller/procesar_registro.php" method="POST">
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

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit">Registrarse</button>
    </form>
</body>
</html>



