<?php
class Alumnos {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para verificar si un alumno ya está registrado
    public function verificarAlumno($nombre, $apellido, $email) {
        $stmt = $this->conexion->prepare("SELECT * FROM Alumnos WHERE nombre = :nombre AND apellido = :apellido AND email = :email");
        $stmt->execute(['nombre' => $nombre, 'apellido' => $apellido, 'email' => $email]);

        return $stmt->rowCount() > 0; // Devuelve true si hay resultados
    }

    // Método para agregar un nuevo alumno
    public function agregarAlumno($nombre, $apellido, $email, $fecha_nacimiento) {
        $stmt = $this->conexion->prepare("INSERT INTO Alumnos (nombre, apellido, email, fecha_nacimiento) VALUES (:nombre, :apellido, :email, :fecha_nacimiento)");
        return $stmt->execute(['nombre' => $nombre, 'apellido' => $apellido, 'email' => $email, 'fecha_nacimiento' => $fecha_nacimiento]);
    }
}
?>