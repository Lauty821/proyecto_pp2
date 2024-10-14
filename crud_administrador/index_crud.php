<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRUD Usuarios</title>
<link rel="stylesheet" href="./css/styles.css">
</head>
<body>

    <div class="table-title">
        <div class="row">
            <div class="col-md-10"><h2>Lista de <b>Usuarios</b></h2></div>
            <div class="col-md-2">
                <!-- Enlace que lleva a la página de selección de tipo de usuario -->
                <a href="./formularios/agregar.php" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar Usuario</a>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (!empty($listado)) {
                foreach ($listado as $row) {
                    $id = $row['ID_Usuario']; // Asegúrate de que esta variable esté correctamente definida.
                    // Obtener el nombre, apellido, email y rol dependiendo de la tabla.
                    $nombre = $row['Nombre'] ?: 'Sin Nombre';
                    $apellido = $row['Apellido'] ?: 'Sin Apellido'; // Agrega el apellido
                    $email = $row['Mail'] ?: 'Sin Email';
                    $rol = ''; // Aquí deberías establecer cómo determinar el rol dependiendo de la tabla.
                    // Este rol puede ser asignado de acuerdo a las columnas de tu $row o de alguna lógica que tengas.
            ?>
            <tr>
                <td><?php echo $nombre; ?></td>
                <td><?php echo $apellido; ?></td>
                <td><?php echo $email; ?></td>
                <td><?php echo $rol; ?></td> <!-- Mostrar el rol -->
                <td>
                    <a href="editar_usuario.php?id=<?php echo $id;?>" class="edit" title="Editar" data-toggle="tooltip">
                        <i class="fi fi-rr-pencil"></i>
                    </a>
                    
                    <a href="eliminar_usuario.php?id=<?php echo $id;?>" class="delete" title="Eliminar" data-toggle="tooltip">
                        <i class="fi fi-rr-trash"></i>
                    </a>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='5'>No hay usuarios registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>