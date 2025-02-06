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

session_start(); // Iniciar sesión para manejar mensajes temporales

$mensaje = ""; // Variable para mostrar mensajes al usuario

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    if (!empty($_POST['nombre']) && !empty($_POST['email'])) {
        $nombre = htmlspecialchars($_POST['nombre']);
        $email_destinatario = htmlspecialchars($_POST['email']);
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'urquizapp2@gmail.com'; // Tu correo
            $mail->Password = 'kjsi wlpz keen eqrp'; // Tu contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Configuración del correo
            $mail->CharSet = 'UTF-8'; // Configura el charset a UTF-8
            $mail->setFrom('urquizapp2@gmail.com', 'Formulario Pre-Inscripción');
            $mail->addAddress($email_destinatario); // Correo ingresado en el formulario
            $mail->Subject = 'Confirmación de Pre-Inscripción';
            $mail->Body = "Hola $nombre,\n\nGracias por completar el formulario de pre-inscripción. Para completar la inscripción debera presertar la siguiente documentación impresa: \n• Documento Nacional de Identidad (DNI original y copia). \n• Partida de Nacimiento (Copia legalizada por tribunales). \n• Certificado de Título Secundario (Copia legalizada por tribunales) o constancia de título en trámite.";

            // Enviar correo
            $mail->send();

            // Guardar mensaje de éxito en la sesión
            $_SESSION['mensaje'] = "Se envió un correo de confirmación a $email_destinatario. Por favor revisa tu correo eléctronico.";
        } catch (Exception $e) {
            // Guardar mensaje de error en la sesión
            $_SESSION['mensaje'] = "Error al enviar el correo: {$mail->ErrorInfo}";
        }

        // Redirigir para evitar reenvío
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['mensaje'] = "Por favor, completa todos los campos.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Mostrar mensaje desde la sesión, si existe, y luego destruirlo
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']); // Destruir el mensaje después de mostrarlo
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

        <label for="documento">Número de documento <span class="mandatory">*</span></label>
        <input type="text" id="documento" name="documento" required>

        <label for="fecha_nacimiento">Fecha de Nacimiento <span class="mandatory">*</span></label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>

        <label for="genero">Género <span class="mandatory">*</span></label>
        <select id="genero" name="genero" required>
            <option value="">Seleccione</option>
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
            <option value="otro">Otro</option>
        </select>

        <label for="direccion">Dirección <span class="mandatory">*</span></label>
        <input type="text" id="direccion" name="direccion" required>

        <label for="localidad">Localidad <span class="mandatory">*</span></label>
        <input type="text" id="localidad" name="localidad" required>

        <label for="provincia">Provincia <span class="mandatory">*</span></label>
        <input type="text" id="provincia" name="provincia" required>

        <label for="nacionalidad">Nacionalidad <span class="mandatory">*</span></label>
        <input type="text" id="nacionalidad" name="nacionalidad" required>

        <label for="email">Correo Electrónico <span class="mandatory">*</span></label>
        <input type="email" id="email" name="email" required>

        <label for="telefono">Número de Teléfono <span class="mandatory">*</span></label>
        <input type="tel" id="telefono" name="telefono" required>

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

        <div class="form-actions">
            <button type="submit" name="enviar">Enviar</button>
            <button type="reset">Borrar todo</button>
            <button type="button" class="print-button" onclick="window.print();">Imprimir formulario</button>
        </div> 
    </form>

</body>
</html>
