<?php
namespace App\controllers;


include_once 'databases/ConexionDBController.php';

use App\controllers\databases\ConexionDBController;

// Iniciar sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $usuario = $_POST["usuario"];
    $password = $_POST["pwd"];

    // Crear instancia de la clase de conexión a la base de datos
    $conexionDBController = new \App\controllers\databases\ConexionDBController();

    // Obtener la conexión a la base de datos
    $conex = $conexionDBController->getConexion();

    // Escapar los valores para prevenir inyección SQL
    $usuario = $conex->real_escape_string($usuario);
    $password = $conex->real_escape_string($password);

    // Consulta SQL para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND pwd='$password'";

    // Ejecutar la consulta SQL
    $resultado = $conexionDBController->execSql($sql);

 if ($resultado && $resultado->num_rows == 1) {
    // Si se encontró un usuario con las credenciales proporcionadas, verificar si es un usuario autorizado
    $usuarioData = $resultado->fetch_assoc();
    if ($usuarioData && isset($usuarioData['es_admin']) && $usuarioData['es_admin']) {
        // Si es un administrador, iniciar sesión
        $_SESSION["usuario"] = $usuario;
        
        // Redirigir al usuario a la página principal
        header("Location: productos_disponibles.php");
        exit();
    } else {
        // Si no es un administrador, mostrar un mensaje de error
        exit("Acceso denegado: No tienes permisos de administrador para acceder a esta página. Por favor, inicia sesión con una cuenta de administrador.");
    }
} else {
    // Si las credenciales son inválidas, mostrar un mensaje de error
    exit("Usuario o contraseña incorrectos");
}
}


?>
