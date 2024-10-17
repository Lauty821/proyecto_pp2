<?php

class Bedel {
    private $nombre;
    private $apellido;
    private $dni;
    private $legajo;
    private $mail;
    private $contraseña;
    private $db;

    public function __construct($nombre, $apellido, $dni, $legajo, $mail, $contraseña, $db) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->legajo = $legajo;
        $this->mail = $mail;
        $this->contraseña = $contraseña;
        $this->db = $db; // Aquí pasamos la conexión a la base de datos
    }

    public function registrarBedel() {
        return $this->db->create_bedel($this->nombre, $this->apellido, $this->dni, $this->legajo, $this->mail, $this->contraseña);
    }
    
}

?>
