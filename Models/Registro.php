
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../CSS/registro.css">
</head>
<body>

    <div class="container">
        <h2>Registro</h2>
        <form action="controller/RegistroController.php" method="POST" class="register-form">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="pwd">Contraseña</label>
                <input type="password" id="pwd" name="pwd" required>
            </div>
            <button type="submit">Registrarse</button>
            <div class="login-link">
                ¿Ya tienes una cuenta? <a href="../Views/inicio_sesion.html">Inicia sesión aquí</a>
            </div>
        </form>
    </div>
</body>
</html>