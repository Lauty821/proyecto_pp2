<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
<title>Formulario de Pre-Inscripción</title>
</head>
<body>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../proyectopp2/PHPMailer/src/Exception.php';
require '../proyectopp2/PHPMailer/src/PHPMailer.php';
require '../proyectopp2/PHPMailer/src/SMTP.php';

require './data_base/conexion.php'; // Incluir el archivo de conexión

session_start(); // Iniciar sesión para manejar mensajes

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    if (
        !empty($_POST['nombre']) && 
        !empty($_POST['apellido']) && 
        !empty($_POST['DNI']) &&
        !empty($_POST['domicilio']) &&
        !empty($_POST['email']) &&
        !empty($_POST['carrera'])
    ) {
        // Sanitizar y asignar valores del formulario
        $nombre = $conexion->real_escape_string($_POST['nombre']);
        $apellido = $conexion->real_escape_string($_POST['apellido']);
        $dni = $conexion->real_escape_string($_POST['DNI']);
        $domicilio = $conexion->real_escape_string($_POST['domicilio']);
        $email = $conexion->real_escape_string($_POST['email']);
        $carrera = $conexion->real_escape_string($_POST['carrera']);

        // Query SQL para insertar datos
        $sql = "INSERT INTO pre_inscripcion (nombre, apellido, DNI, domicilio, email, carrera) 
                VALUES ('$nombre', '$apellido', '$dni', '$domicilio', '$email', '$carrera')";

        if ($conexion->query($sql) === TRUE) {
            // Cerrar conexión antes de continuar
            $conexion->close();

            // Enviar correo de confirmación
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'urquizapp2@gmail.com';
                $mail->Password = 'kjsi wlpz keen eqrp'; // Asegúrate de usar credenciales seguras
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                // Configuración del correo
                $mail->CharSet = 'UTF-8';
                $mail->setFrom('urquizapp2@gmail.com', 'Formulario Pre-Inscripción');
                $mail->addAddress($email);
                $mail->Subject = 'Confirmación de Pre-Inscripción';
                $mail->Body = "Hola $nombre,\n\nGracias por completar el formulario de pre-inscripción. Para completar la inscripción deberás presentar la siguiente documentación impresa:\n• DNI (original y copia)\n• Partida de Nacimiento (Copia legalizada por tribunales)\n• Certificado de Título Secundario (Copia legalizada por tribunales) o constancia de título en trámite.";

                // Enviar correo
                $mail->send();

                $_SESSION['mensaje'] = "Registro exitoso. Se envió un correo de confirmación a $email.";
            } catch (Exception $e) {
                $_SESSION['mensaje'] = "Registro exitoso, pero hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['mensaje'] = "Error al guardar los datos: " . $conexion->error;
        }

        // Redirigir para evitar reenvío del formulario
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['mensaje'] = "Por favor, completa todos los campos.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
if (isset($_SESSION['mensaje'])) {
    $claseMensaje = strpos($_SESSION['mensaje'], 'Error') !== false ? 'error' : 'exito';
    echo "<div class='mensaje $claseMensaje'>{$_SESSION['mensaje']}</div>";
    unset($_SESSION['mensaje']);
}

// Mostrar mensaje desde la sesión, si existe, y luego destruirlo
if (isset($_SESSION['mensaje'])) {
    echo "<p>{$_SESSION['mensaje']}</p>";
    unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
}
?>

<?php if (!empty($mensaje)): ?>
    <div class="mensaje <?= strpos($mensaje, 'Error') !== false ? 'error' : 'exito'; ?>">
        <?= htmlspecialchars($mensaje) ?>
    </div>
<?php endif; ?>



<form action="" method="post">

        <h1>Formulario de Pre-Inscripción</h1>
        <label for="nombre">Nombre <span class="mandatory">*</span></label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellido">Apellido <span class="mandatory">*</span></label>
        <input type="text" id="apellido" name="apellido" required>

        <label for="DNI">DNI <span class="mandatory">*</span></label>
        <input type="text" id="DNI" name="DNI" required>

        <label for="fecha_nacimiento">Fecha de Nacimiento <span class="mandatory">*</span></label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>

        <label for="genero">Género <span class="mandatory">*</span></label>
        <select id="genero" name="genero" required>
            <option value="">Seleccione</option>
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
            <option value="otro">Otro</option>
        </select>

        <label for="telefono">Número de Teléfono <span class="mandatory">*</span></label>
        <input type="tel" id="telefono" name="telefono" required>

        <label for="email">Correo Electrónico <span class="mandatory">*</span></label>
        <input type="email" id="email" name="email" required>

        <label for="provincia">Provincia <span class="mandatory">*</span></label>
        <input type="text" id="provincia" name="provincia" required>

        <label for="localidad">Localidad <span class="mandatory">*</span></label>
        <input type="text" id="localidad" name="localidad" required>

        <label for="domicilio">Domicilio <span class="mandatory">*</span></label>
        <input type="text" id="domicilio" name="domicilio" required>

        <label for="nacionalidad">Nacionalidad <span class="mandatory">*</span></label>
        <input type="text" id="nacionalidad" name="nacionalidad" required>

        <label for="escuela">Escuela donde realizó sus estudios secundarios <span class="mandatory">*</span></label>
        <input type="text" id="escuela" name="escuela" required>

        <label for="localidad_escuela">Localidad de la Escuela <span class="mandatory">*</span></label>
        <input type="text" id="localidad_escuela" name="localidad_escuela" required>

        <label for="provincia_escuela">Provincia de la Escuela <span class="mandatory">*</span></label>
        <input type="text" id="provincia_escuela" name="provincia_escuela" required>

        <label>¿Tiene sus estudios secundarios completos? <span class="mandatory">*</span></label>
        <select name="estudios_completos" required>
            <option value="">Seleccione</option>
            <option value="si">Sí</option>
            <option value="no">No</option>
        </select>

        <label>Carrera que quiere elegir <span class="mandatory">*</span></label>
        <select name="carrera" required>
            <option value="">Seleccione</option>
            <option value="af">Análisis Funcional (AF)</option>
            <option value="ds">Desarrollo de Software (DS)</option>
            <option value="iti">Infraestructura de Tecnología de la Información (ITI)</option>
        </select>

        <div class="form-actions">
            <button type="submit" name="enviar">Enviar</button>
            <button type="reset">Borrar todo</button>
            <button type="button" class="print-button" onclick="window.print();">Imprimir formulario</button>
        </div> 
    </form>

</body>
</html>
