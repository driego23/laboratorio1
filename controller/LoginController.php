<?php

// Incluir el modelo de usuario
include_once '../models/Usuario.php';
// Incluir la clase de conexión a la base de datos
include_once 'databases/ConexionDBController.php';

// Iniciar sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $usuario = $_POST["usuario"];
    $password = $_POST["pwd"];

    // Crear instancia de la clase de conexión a la base de datos
    $conexionDBController = new \App\controllers\databases\ConexionDBController();

    // Escapar los valores para prevenir inyección SQL
    $usuario = $conexionDBController->conex->real_escape_string($usuario);
    $password = $conexionDBController->conex->real_escape_string($password);

    // Consulta SQL para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND pwd='$password'";

    // Ejecutar la consulta SQL
    $resultado = $conexionDBController->execSql($sql);

    if ($resultado && $resultado->num_rows == 1) {
        // Si se encontró un usuario con las credenciales proporcionadas, iniciar sesión
        $_SESSION["usuario"] = $usuario;
        
        // Redirigir al usuario a la página principal
        header("Location: principal.php");
        exit();
    } else {
        // Si las credenciales son inválidas, mostrar un mensaje de error
        echo "Usuario o contraseña incorrectos";
    }
}

?>
