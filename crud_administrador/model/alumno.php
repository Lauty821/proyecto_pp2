<?php
require_once '../data_base/db_urquiza.php';

class Alumno {
    private $nombre;
    private $apellido;
    private $dni;
    private $mail;
    private $contraseña;
    private $conexion;

    // Constructor de la clase Alumno
    public function __construct($nombre, $apellido, $dni, $mail, $contraseña, $conexion) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->mail = $mail;
        $this->contraseña = $contraseña;
        $this->conexion = $conexion; // Asignamos la conexión
    }

    // Método para registrar un nuevo alumno
    public function registrarAlumno() {
        // Sanitizamos los datos
        $nombre = $this->conexion->sanitize($this->nombre);
        $apellido = $this->conexion->sanitize($this->apellido);
        $dni = $this->conexion->sanitize($this->dni);
        $mail = $this->conexion->sanitize($this->mail);
        $contraseña = $this->conexion->sanitize($this->contraseña);

        // Intentamos crear el alumno en la base de datos
        if ($this->conexion->create($nombre, $apellido, $dni, $mail, $contraseña)) {
            return "Alumno registrado exitosamente.";
        } else {
            return "Error al registrar el alumno: " . mysqli_error($this->conexion->conexion);
        }
    }

    // Puedes agregar otros métodos aquí para actualizar, eliminar, etc.
}