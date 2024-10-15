<?php
require_once '../data_base/db_urquiza.php';
require_once '../model/alumno.php';

// Crear una instancia de la clase Database
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $mail = $_POST['mail'];
    $contraseña = $_POST['contraseña'];

    // Encriptar la contraseña antes de crear el objeto Alumno
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Verificar si el mail o el dni ya existen en la base de datos
    $sql = "SELECT * FROM alumnos WHERE dni = ? OR mail = ?";
    $stmt = $db->conexion->prepare($sql);
    $stmt->bind_param("ss", $dni, $mail);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Si ya existe un alumno con el mismo DNI o mail
        echo "<div class='error'>El DNI o el correo electrónico ya están registrados.</div>";
    } else {
        // Si no hay coincidencias, registrar el alumno
        $alumno = new Alumno($nombre, $apellido, $dni, $mail, $contraseña_hash, $db);
        $resultado = $alumno->registrarAlumno();
        echo "<div class='mensaje'>$resultado</div>";
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Alumno</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="container-alumno">
    <h1>Agregar Alumno</h1>
    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>

        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" maxlength="8" required>

        <label for="mail">Mail:</label>
        <input type="email" id="mail" name="mail" required>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>

        <label for="repetir_contraseña">Repetir Contraseña:</label>
        <input type="password" id="repetir_contraseña" name="repetir_contraseña" required>

        <input type="submit" value="Registrar Alumno">
    </form>
</div>
</body>
</html>
