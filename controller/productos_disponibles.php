<?php
// Incluir la clase de conexión a la base de datos
include_once 'databases/ConexionDBController.php';

// Crear instancia de la clase de conexión a la base de datos
$conexionDBController = new \App\controllers\databases\ConexionDBController();

// Consulta SQL para obtener los productos disponibles
$sql = "SELECT * FROM articulos";
$resultado = $conexionDBController->execSql($sql);

$productos = array();

// Verificar si se obtuvieron resultados
if ($resultado && $resultado->num_rows > 0) {
    // Almacenar los productos en un array
    while ($row = $resultado->fetch_assoc()) {
        $productos[] = $row;
    }
}

// Cerrar la conexión a la base de datos
$conexionDBController->close();

// Retornar el array de productos
return $productos;
?>
