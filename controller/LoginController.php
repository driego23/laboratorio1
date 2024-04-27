<?php

// Incluir el modelo de usuario
include_once '../models/Usuario.php';

// Iniciar sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $usuario = $_POST["usuario"];
    $password = $_POST["pwd"];

    // Crear instancia del modelo Usuario
    $usuarioModel = new Usuario();

    // Verificar si las credenciales son válidas
    if ($usuarioModel->validarCredenciales($usuario, $password)) {
        // Si las credenciales son válidas, almacenar información de sesión
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