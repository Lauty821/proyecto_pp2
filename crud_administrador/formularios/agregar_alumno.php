<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Alumno</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/styles.css?v=2.0">
    <link rel="stylesheet" href="../css/styles.css?v=3.0">
</head>
<body>
<div class="container-alumno">
    <h1>Agregar Alumno</h1>
    <form action="" method="POST">  <!-- Acción eliminada para procesar en este mismo archivo -->
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>

        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" maxlength="8" required>  <!-- Cambiado a type="text" y maxlength a 8 -->

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>

        <label for="repetir_contraseña">Repetir Contraseña:</label>
        <input type="password" id="repetir_contraseña" name="repetir_contraseña" required>  <!-- Campo para repetir la contraseña -->

        <input type="submit" value="Registrar Alumno">
    </form>

    <?php
    // Incluir el archivo de conexión a la base de datos
    require_once '../data_base/db_urquiza.php';

    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dni = $_POST['dni'];
        $email = $_POST['email'];
        $contraseña = $_POST['contraseña'];
        $repetir_contraseña = $_POST['repetir_contraseña'];

        // Verificar que las contraseñas coincidan
        if ($contraseña !== $repetir_contraseña) {
            echo '<div class="error">Las contraseñas no coinciden.</div>';  // Mensaje si las contraseñas no coinciden
        } else {
            // Verificar si el alumno ya está registrado
            $sql = "SELECT * FROM Alumnos WHERE DNI = :dni OR Mail = :mail";
            $stmt = $conexion->prepare($sql);
            $stmt->execute(['dni' => $dni, 'mail' => $email]);
            $alumnoExistente = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($alumnoExistente) {
                echo '<div class="error">El alumno ya está registrado.</div>';  // Mensaje en cuadro amarillo
            } else {
                // Preparar la consulta para insertar el nuevo alumno
                $sql = "INSERT INTO Alumnos (Nombre, Apellido, DNI, Mail, Contraseña) VALUES (:nombre, :apellido, :dni, :mail, :contraseña)";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'dni' => $dni,
                    'mail' => $email,
                    'contraseña' => password_hash($contraseña, PASSWORD_DEFAULT)  // Guardar contraseña encriptada
                ]);

                echo '<div class="success">Alumno registrado exitosamente.</div>';  // Mensaje de éxito
            }
        }
    }
    ?>
</div>
</body>
</html>