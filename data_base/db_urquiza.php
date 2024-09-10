<?php
$servidor = "localhost";
$db_nombre = "instituto";
$usuario = "root";
$contraseña = "";

try {
    $conexion = new PDO("mysql:host=$servidor ;port=3306;dbname=$db_nombre", $usuario, $contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
