<?php
class Database
{
    public $conexion;
    private $servidor = "localhost";
    private $db_nombre = "db_urquiza";
    private $usuario = "root"; 
    private $contraseña = "";

    function __construct()
    {
        $this->connect_db();
    }

    // Conexión a la base de datos
    public function connect_db()
    {
        $this->conexion = mysqli_connect($this->servidor, $this->usuario, $this->contraseña, $this->db_nombre);
        if (mysqli_connect_error()) {
            die("La conexión a la base de datos falló: " . mysqli_connect_error() . mysqli_connect_errno());
        }
    }

    // Sanitizar los datos para evitar inyecciones SQL
    public function sanitize($var)
    {
        return mysqli_real_escape_string($this->conexion, $var);
    }

    public function create($nombre, $apellido, $dni, $mail, $contraseña) {
        $sql = "INSERT INTO alumnos (nombre, apellido, dni, mail, contraseña) VALUES (?, ?, ?, ?, ?)";
        $query = $this->conexion->prepare($sql);
        $query->bind_param("sssss", $nombre, $apellido, $dni, $mail, $contraseña);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
    

    // Leer todos los registros de la tabla Alumnos
    public function read()
    {
        $sql = "SELECT * FROM Alumnos";
        $res = mysqli_query($this->conexion, $sql);
        return $res;
    }

    // Obtener un único registro (alumno) por su ID
    public function single_record($id)
    {
        $sql = "SELECT * FROM Alumnos WHERE id='$id'";
        $res = mysqli_query($this->conexion, $sql);
        return mysqli_fetch_object($res);
    }

    // Actualizar un registro de alumno
    public function update($nombre, $apellido, $dni, $mail, $contraseña, $id)
    {
        $sql = "UPDATE Alumnos SET Nombre=?, Apellido=?, DNI=?, Mail=?, Contraseña=? WHERE id=?";
        $query = $this->conexion->prepare($sql);
        $query->bind_param("sssssi", $nombre, $apellido, $dni, $mail, $contraseña, $id);
        
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Eliminar un registro de alumno
    public function delete($id)
    {
        $sql = "DELETE FROM Alumnos WHERE id=?";
        $query = $this->conexion->prepare($sql);
        $query->bind_param("i", $id);
        
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
}