<?php
// Verificar si se enviaron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $tipo_documento = $_POST["tipo_documento"];
    $numero_documento = $_POST["numero_documento"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];

    // Crear instancia de la clase de conexión a la base de datos
    include_once 'databases/ConexionDBController.php';
    $conexionDBController = new \App\controllers\databases\ConexionDBController();

    // Escapar los valores para prevenir inyección SQL
    $nombre = $conexionDBController->getConexion()->real_escape_string($nombre);
    $tipo_documento = $conexionDBController->getConexion()->real_escape_string($tipo_documento);
    $numero_documento = $conexionDBController->getConexion()->real_escape_string($numero_documento);
    $telefono = $conexionDBController->getConexion()->real_escape_string($telefono);
    $email = $conexionDBController->getConexion()->real_escape_string($email);

    // Verificar si el cliente ya está registrado
    $sql = "SELECT * FROM clientes WHERE numeroDocumento='$numero_documento'";
    $resultado = $conexionDBController->execSql($sql);

    if ($resultado && $resultado->num_rows > 0) {
        // El cliente ya está registrado, actualizar la información
        $sql_update = "UPDATE clientes SET nombreCompleto='$nombre', tipoDocumento='$tipo_documento', telefono='$telefono', email='$email' WHERE numeroDocumento='$numero_documento'";
        if ($conexionDBController->execSql($sql_update)) {
            echo "¡Información actualizada correctamente!";
        } else {
            echo "Error al actualizar la información del cliente.";
        }
    } else {
        // El cliente no está registrado, insertar nueva información
        $sql_insert = "INSERT INTO clientes (nombreCompleto, tipoDocumento, numeroDocumento, telefono, email) VALUES ('$nombre', '$tipo_documento', '$numero_documento', '$telefono', '$email')";
        if ($conexionDBController->execSql($sql_insert)) {
            echo "¡Cliente registrado correctamente!";
        } else {
            echo "Error al registrar el cliente.";
        }
    }

    // Redirigir al usuario después del registro exitoso
    echo "¡Registro exitoso! Serás redirigido a la página de inicio de sesión en unos momentos.";
    echo '<meta http-equiv="refresh" content="5;URL=../Views/inicio_sesion.html">';
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente</title>
    <link rel="stylesheet" href="../CSS/registro_cliente.css">
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



