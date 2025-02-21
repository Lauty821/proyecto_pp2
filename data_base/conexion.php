<?php
$servidor= "localhost";  // Servidor MySQL
$usuario = "root";    // Usuario de la base de datos
$clave = "";          // Contraseña de la base de datos
$bd = "db_urquiza_actualizada"; // Nombre de la base de datos

// Función para obtener conexión a la base de datos
function obtenerConexion() {
    global $servidor, $usuario, $clave, $bd;

    // Activar reportes de errores en MySQLi
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $conexion = new mysqli($servidor, $usuario, $clave, $bd);
        $conexion->set_charset("utf8mb4"); // Establecer el conjunto de caracteres
        return $conexion;
    } catch (Exception $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

// Crear conexión global (si es necesario)
$conexion = obtenerConexion();
?>
