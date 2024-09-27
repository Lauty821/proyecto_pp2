<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRUD Usuarios</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="table-title">
        <div class="row">
            <div class="col-md-10"><h2>Lista de <b>Usuarios</b></h2></div>
            <div class="col-md-2">
                <a href="agregar_usuario.php" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar</a>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (!empty($listado)) {
                foreach ($listado as $row) {
                    $id = $row['id'];
                    $nombre = $row['nombre'];
                    $email = $row['email'];
            ?>
            <tr>
                <td><?php echo $nombre; ?></td>
                <td><?php echo $email; ?></td>
                <td>
                    <a href="editar_usuario.php?id=<?php echo $id;?>" class="edit" title="Editar" data-toggle="tooltip">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a href="eliminar_usuario.php?id=<?php echo $id;?>" class="delete" title="Eliminar" data-toggle="tooltip">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='3'>No hay usuarios registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>