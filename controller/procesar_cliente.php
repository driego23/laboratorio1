<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once 'databases/ConexionDBController.php';
    $conexionDBController = new \App\controllers\databases\ConexionDBController();

    $nombreCompleto = $_POST['nombreCompleto'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroDocumento = $_POST['numeroDocumento'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $sql_check = "SELECT * FROM clientes WHERE numeroDocumento = '$numeroDocumento'";
    $resultado = $conexionDBController->execSql($sql_check);

    if ($resultado && $resultado->num_rows > 0) {
        $sql_update = "UPDATE clientes 
                       SET nombreCompleto = '$nombreCompleto', tipoDocumento = '$tipoDocumento', telefono = '$telefono', email = '$email' 
                       WHERE numeroDocumento = '$numeroDocumento'";
        $conexionDBController->execSql($sql_update);
    } else {
        $sql_insert = "INSERT INTO clientes (nombreCompleto, tipoDocumento, numeroDocumento, telefono, email) 
                       VALUES ('$nombreCompleto', '$tipoDocumento', '$numeroDocumento', '$telefono', '$email')";
        $conexionDBController->execSql($sql_insert);
    }
    $cliente_info = array(
        'nombreCompleto' => $nombreCompleto,
        'tipoDocumento' => $tipoDocumento,
        'numeroDocumento' => $numeroDocumento,
        'telefono' => $telefono,
        'email' => $email
    );

    header("Location: ../Views/seleccion_productos.php?" . http_build_query($cliente_info));
    exit();
}
?>
