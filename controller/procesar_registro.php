<?php
include_once 'databases/ConexionDBController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $tipo_documento = $_POST["tipo_documento"];
    $numero_documento = $_POST["numero_documento"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];

    $conexionDBController = new \App\controllers\databases\ConexionDBController();

    $nombre = $conexionDBController->getConexion()->real_escape_string($nombre);
    $tipo_documento = $conexionDBController->getConexion()->real_escape_string($tipo_documento);
    $numero_documento = $conexionDBController->getConexion()->real_escape_string($numero_documento);
    $telefono = $conexionDBController->getConexion()->real_escape_string($telefono);
    $email = $conexionDBController->getConexion()->real_escape_string($email);

    $sql = "SELECT * FROM clientes WHERE numeroDocumento='$numero_documento'";
    $resultado = $conexionDBController->execSql($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $sql_update = "UPDATE clientes SET nombreCompleto='$nombre', tipoDocumento='$tipo_documento', telefono='$telefono', email='$email' WHERE numeroDocumento='$numero_documento'";
        if ($conexionDBController->execSql($sql_update)) {
            echo "¡Información actualizada correctamente!";
        } else {
            echo "Error al actualizar la información del cliente.";
        }
    } else {
        $sql_insert = "INSERT INTO clientes (nombreCompleto, tipoDocumento, numeroDocumento, telefono, email) VALUES ('$nombre', '$tipo_documento', '$numero_documento', '$telefono', '$email')";
        if ($conexionDBController->execSql($sql_insert)) {
            echo "¡Cliente registrado correctamente!";
        } else {
            echo "Error al registrar el cliente.";
        }
    }
}
echo "¡Registro exitoso! Serás redirigido a la página de inicio de sesión en unos momentos.";
echo '<meta http-equiv="refresh" content="5;URL=../Views/inicio_sesion.html">';
exit();
?>
