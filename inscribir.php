<?php

require_once './data_base/db_urquiza.php';

$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $direccion = $_POST['direccion'];
    $localidad = $_POST['localidad'];
    $provincia = $_POST['provincia'];
    $nacionalidad = $_POST['nacionalidad'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $tipo_estudiante = $_POST['tipo_estudiante'];
    $carrera_id = $_POST['carrera_id'];
    $materias = $_POST['materias'];

    if ($nombre && $apellido && $fecha_nacimiento && $genero && $direccion && $localidad && $provincia && $nacionalidad && $email && $telefono && $tipo_estudiante && $carrera_id && !empty($materias)) {
        $usuario = "Usuario Anónimo";

        foreach ($materias as $materia_id) {
            $sql = "INSERT INTO inscripciones (usuario, carrera_id, materia_id) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$usuario, $carrera_id, $materia_id]);
        }

        $success_message = "Inscripción realizada exitosamente";
    } else {
        $success_message = "Por favor, complete todos los campos obligatorios.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de inscripción de materias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .warning {
            background-color: #fff3cd;
            padding: 10px;
            border-left: 4px solid #ffeeba;
            margin-bottom: 20px;
        }
        .success-message {
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button[type="submit"] {
            background-color: #007bff;
            color: white;
        }
        button[type="button"] {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>

<h1>Formulario de inscripción de materias</h1>

<form action="inscribir.php" method="post">
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
    </div>
    <div class="form-group">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
    </div>
    <div class="form-group">
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
    </div>
    <div class="form-group">
        <label for="genero">Género:</label>
        <select id="genero" name="genero" required>
            <option value="Hombre">Hombre</option>
            <option value="Mujer">Mujer</option>
            <option value="No binarie">No binarie</option>
            <option value="Otro">Otro</option>
            <option value="Prefiero no contestar">Prefiero no contestar</option>
        </select>
    </div>
    <div class="form-group">
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required>
    </div>
    <div class="form-group">
        <label for="localidad">Localidad:</label>
        <input type="text" id="localidad" name="localidad" required>
    </div>
    <div class="form-group">
        <label for="provincia">Provincia:</label>
        <input type="text" id="provincia" name="provincia" required>
    </div>
    <div class="form-group">
        <label for="nacionalidad">Nacionalidad:</label>
        <input type="text" id="nacionalidad" name="nacionalidad" required>
    </div>
    <div class="form-group">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="telefono">Número de Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required>
    </div>

    <div class="warning">
        <p>¿Adeuda materias correlativas de alguna materia a la que se está inscribiendo a cursar? Recuerde que no podrá aprobar materias en las que adeude correlativas, ni podrá cursar aquellas materias de formato taller en las que adeude las respectivas correlativas.</p>
    </div>

    <div class="form-group">
        <label>Tipo de Estudiante:</label>
        <input type="radio" id="ingresante" name="tipo_estudiante" value="Ingresante" required>
        <label for="ingresante">Ingresante de primer año</label>
        <input type="radio" id="recursante" name="tipo_estudiante" value="Recursante" required>
        <label for="recursante">Recursante de primer año</label>
	<input type="radio" id="recursante" name="tipo_estudiante" value="Recursante" required>
        <label for="recursante">Cursante de segundo/tercer año</label>
    </div>

    <div class="form-group">
        <label for="materias">Materias a las que se inscribe:</label>
        <select id="materias" name="materias[]" multiple required>
            <?php
            if (!empty($materias)) {
                foreach ($materias as $materia_id) {
                    $sql = "SELECT nombre FROM materias WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$materia_id]);
                    $materia = $stmt->fetch();
                    echo "<option value=\"$materia_id\">{$materia['nombre']}</option>";
                }
            }
            ?>
        </select>
    </div>

    <div class="buttons">
        <button type="submit">Enviar</button>
        <button type="button" onclick="window.print();">Imprimir comprobante</button>
    </div>

    <?php if ($success_message): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>
</form>

</body>
</html>