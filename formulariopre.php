<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pre-Inscripción</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            max-width: 600px;
            margin: auto;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
        }

        .form-actions button {
            padding: 10px 20px;
            background-color: #1b1b32;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-actions button:hover {
            background-color: coral;
        }

        .form-actions .print-button {
            background-color: #555;
        }

        .form-actions .print-button:hover {
            background-color: #999;
        }

        .mandatory {
            color: red;
            font-weight: bold;
        }
    </style>
    <script>
        function validateForm() {
            const inputs = document.querySelectorAll('input[required]');
            for (const input of inputs) {
                if (!input.value) {
                    alert('Por favor, complete todos los campos obligatorios.');
                    return false;
                }
            }
            alert('Formulario enviado correctamente');
            return true;
        }
    </script>
</head>
<body>

<form onsubmit="return validateForm();">
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
        <button type="submit">Enviar</button>
        <button type="reset">Borrar todo</button>
        <button type="button" class="print-button" onclick="window.print();">Imprimir formulario</button>
    </div>
</form>

</body>
</html>