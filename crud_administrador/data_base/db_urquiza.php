<?php

$servidor = "localhost";
$db_nombre = "db_urquiza";
$usuario = "root";
$contraseña = "";

try {
    $conexion = new PDO("mysql:host=$servidor;port=3306;dbname=$db_nombre", $usuario, $contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Lo sentimos mucho, hubo un error de conexión: " . $e->getMessage();
}

?>