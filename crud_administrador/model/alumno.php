<?php
class Alumno {
    private $nombre;
    private $apellido;
    private $dni;
    private $mail;
    private $contraseña;
    private $db;

    public function __construct($nombre, $apellido, $dni, $mail, $contraseña, $db) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->mail = $mail;
        $this->contraseña = $contraseña;
        $this->db = $db;
    }

    public function registrarAlumno() {
        return $this->db->create($this->nombre, $this->apellido, $this->dni, $this->mail, $this->contraseña);
    }
}
?>