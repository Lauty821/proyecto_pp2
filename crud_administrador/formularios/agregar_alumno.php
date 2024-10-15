<?php
require_once '../data_base/db_urquiza.php';
require_once '../model/alumno.php';

// Crear una instancia de la clase Database
$db = new Database();

// Comprobar conexión
if ($db->conexion === false) {
    die("No estás conectado a la base de datos.");
}

// Inicializar mensaje
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los datos están definidos
    if (isset($_POST['nombre'], $_POST['apellido'], $_POST['dni'], $_POST['mail'], $_POST['contraseña'], $_POST['repetir_contraseña'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dni = $_POST['dni'];
        $mail = $_POST['mail'];
        $contraseña = $_POST['contraseña'];
        $repetir_contraseña = $_POST['repetir_contraseña'];

        // Verificar si las contraseñas son iguales
        if ($contraseña !== $repetir_contraseña) {
            $mensaje = "<div class='mensaje advertencia'>Las contraseñas no son iguales.</div>";
        } else {
            // Encriptar la contraseña antes de crear el objeto Alumno
            $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

            // Verificar si el mail o el dni ya existen en la base de datos
            $sql = "SELECT * FROM alumnos WHERE dni = ? OR mail = ?";
            $stmt = $db->conexion->prepare($sql);
            $stmt->bind_param("ss", $dni, $mail);
            $stmt->execute();
            $resultado = $stmt->get_result();

            // Comprobar si hay resultados
            if ($resultado->num_rows > 0) {
                $mensaje = "<div class='mensaje advertencia'>El DNI y/o mail ya están registrados.</div>";
            } else {
                // Si no hay coincidencias, registrar el alumno
                $alumno = new Alumno($nombre, $apellido, $dni, $mail, $contraseña_hash, $db);
                $resultado = $alumno->registrarAlumno();
                
                if ($resultado === true) {
                    $mensaje = "<div class='mensaje exito'>El usuario se pudo registrar exitosamente.</div>";
                } else {
                    $mensaje = "<div class='mensaje error'>Hubo un error al registrar el usuario: " . $db->conexion->error . "</div>";
                }
            }
        }
    } else {
        $mensaje = "<div class='mensaje error'>Por favor, complete todos los campos requeridos.</div>";
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
    <link rel="stylesheet" href="../css/styles.css?v=2.0">
</head>
<body>
<div class="container-alumno">
    <h1>Agregar Alumno</h1>
    
    <!-- Mostrar mensajes -->
    <div><?php echo $mensaje; ?></div>

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