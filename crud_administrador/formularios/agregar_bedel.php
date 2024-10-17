<?php
session_start(); // Iniciar la sesión

require_once '../data_base/db_urquiza.php';
require_once '../model/bedel.php';

// Crear una instancia de la clase Database
$db = new Database();

// Comprobar conexión
if ($db->conexion === false) {
    die("No estás conectado a la base de datos.");
}

// Inicializar mensaje
$mensaje = '';

// Comprobar si hay un mensaje en la sesión y asignarlo a la variable de mensaje
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']); // Borrar el mensaje de la sesión
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los datos están definidos
    if (isset($_POST['nombre'], $_POST['apellido'], 
    $_POST['dni'],  $_POST['legajo'], $_POST['mail'], $_POST['contraseña'], 
    $_POST['repetir_contraseña'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dni = $_POST['dni'];
        $legajo = $_POST['legajo'];
        $mail = $_POST['mail'];
        $contraseña = $_POST['contraseña'];
        $repetir_contraseña = $_POST['repetir_contraseña'];

        // Verificar si las contraseñas son iguales
        if ($contraseña !== $repetir_contraseña) {
            $_SESSION['mensaje'] = "<div class='mensaje advertencia'>Las contraseñas no son iguales.</div>";
            header("Location: " . $_SERVER['PHP_SELF']); // Redirigir para evitar reenvío de formulario
            exit();
        } else {
            // Encriptar la contraseña antes de crear el objeto Bedel
            $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

            // Verificar si el mail, el dni o el legajo ya existen en la base de datos para bedeles
            $sql = "SELECT * FROM bedeles WHERE dni = ? OR legajo = ? OR mail = ?";
            $stmt = $db->conexion->prepare($sql);
            $stmt->bind_param("sss", $dni, $legajo, $mail,);
            $stmt->execute();
            $resultado = $stmt->get_result();

            // Comprobar si hay resultados
            if ($resultado->num_rows > 0) {
                $_SESSION['mensaje'] = "<div class='mensaje advertencia'>El DNI, mail o legajo ya están registrados.</div>";
                header("Location: " . $_SERVER['PHP_SELF']); // Redirigir para evitar reenvío de formulario
                exit();
            } else {
                // Si no hay coincidencias, registrar el bedel
                $bedel = new Bedel($nombre, $apellido, $dni, $legajo, $mail, $contraseña_hash, $db);
                $resultado = $bedel->registrarBedel();
                
                if ($resultado === true) {
                    $_SESSION['mensaje'] = "<div class='mensaje exito'>El bedel se registró exitosamente.</div>";
                    header("Location: " . $_SERVER['PHP_SELF']); // Redirigir para evitar reenvío de formulario
                    exit();
                } else {
                    $_SESSION['mensaje'] = "<div class='mensaje error'>Hubo un error al registrar el bedel: " . $db->conexion->error . "</div>";
                    header("Location: " . $_SERVER['PHP_SELF']); // Redirigir para evitar reenvío de formulario
                    exit();
                }
            }
        }
    } else {
        $_SESSION['mensaje'] = "<div class='mensaje error'>Por favor, complete todos los campos requeridos.</div>";
        header("Location: " . $_SERVER['PHP_SELF']); // Redirigir para evitar reenvío de formulario
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Bedel</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/styles.css?v=2.0">
    <script>
        function togglePasswordVisibility(inputId, buttonId) {
            const passwordInput = document.getElementById(inputId);
            const button = document.getElementById(buttonId);
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            button.textContent = type === 'password' ? '❌' : '👁️'; // Cambiar texto del botón
        }
    </script>
</head>
<body>
<div class="container-bedel">
    <h1>Agregar Bedel</h1>
    
    <!-- Mostrar mensajes -->
    <div><?php echo $mensaje; ?></div>

    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>

        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" maxlength="8" required>

        <label for="legajo">Legajo:</label>
        <input type="text" id="legajo" name="legajo" maxlength="45" required>

        <label for="mail">Mail:</label>
        <input type="email" id="mail" name="mail" required>

        <label for="contraseña">Contraseña:</label>
        <div style="display: flex; align-items: center;">
            <input type="password" id="contraseña" name="contraseña" required>
            <button type="button" id="btnContraseña" onclick="togglePasswordVisibility('contraseña', 'btnContraseña')">❌</button>
        </div>

        <label for="repetir_contraseña">Repetir Contraseña:</label>
        <div style="display: flex; align-items: center;">
            <input type="password" id="repetir_contraseña" name="repetir_contraseña" required>
            <button type="button" id="btnRepetirContraseña" onclick="togglePasswordVisibility('repetir_contraseña', 'btnRepetirContraseña')">❌</button>
        </div>

        <input type="submit" value="Registrar Bedel"> <!-- Cambiado el texto del botón -->
    </form>
</div>
</body>
</html>