<?php

// Incluir la clase de conexión a la base de datos
include_once 'databases/ConexionDBController.php';

// Verificar si se enviaron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $usuario = $_POST["usuario"];
    $password = $_POST["pwd"];

    // Crear instancia de la clase de conexión a la base de datos
    $conexionDBController = new \App\controllers\databases\ConexionDBController();

    // Escapar los valores para prevenir inyección SQL
    $nombre = $conexionDBController->conex->real_escape_string($nombre);
    $usuario = $conexionDBController->conex->real_escape_string($usuario);
    $password = $conexionDBController->conex->real_escape_string($password);

    // Consulta SQL para insertar un nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, usuario, pwd) VALUES ('$nombre', '$usuario', '$password')";

    // Ejecutar la consulta SQL
    if ($conexionDBController->execSql($sql)) {
        // Redirigir al usuario a la página de inicio de sesión después del registro exitoso
        header("Location: ../Views/inicio_sesion.html");
        exit();
    } else {
        // Mostrar un mensaje de error si ocurrió un problema al registrar al usuario
        echo "Error al registrar al usuario. Por favor, inténtalo de nuevo.";
    }
}

?>
