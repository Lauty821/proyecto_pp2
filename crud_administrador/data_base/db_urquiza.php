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

    // Con este método para crear un nuevo registro en la 
    public function create_alumno($nombre, $apellido, $dni, $mail, $contraseña) {
        $sql = "INSERT INTO alumnos (nombre, apellido, dni, mail, contraseña) VALUES (?, ?, ?, ?, ?)";
        $query = $this->conexion->prepare($sql);
        
        if (!$query) {
            die("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $query->bind_param("sssss", $nombre, $apellido, $dni, $mail, $contraseña);
        
        if ($query->execute()) {
            return true;
        } else {
            echo "Error en la inserción: " . $query->error; // Imprimir error
            return false;
        }
    }

    // Leer todos los registros de la tabla Alumnos
    public function read_alumno()
    {
        $sql = "SELECT * FROM Alumnos";
        $res = mysqli_query($this->conexion, $sql);
        return $res;
    }

    // Con este método se puede obtener un único registro (alumno) por su ID.
    public function single_record_alumno($id)
    {
        $sql = "SELECT * FROM Alumnos WHERE id='$id'";
        $res = mysqli_query($this->conexion, $sql);
        return mysqli_fetch_object($res);
    }

    // Con este método actualizo un registro de la tabla Alumnos.
    public function update_alumno($nombre, $apellido, $dni, $mail, $contraseña, $id)
    {
        $sql = "UPDATE Alumnos SET nombre=?, apellido=?, dni=?, mail=?, contraseña=? WHERE id=?";
        $query = $this->conexion->prepare($sql);
        $query->bind_param("sssssi", $nombre, $apellido, $dni, $mail, $contraseña, $id);
        
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Con este método elimino un registro de la tabla Alumnos.
    public function delete_alumno($id)
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





    public function create_bedel($nombre, $apellido, $dni, $legajo, $mail, $contraseña) {
        // Consulta SQL con el orden correcto de los campos
        $sql = "INSERT INTO bedeles (nombre, apellido, dni, legajo, mail, contraseña) VALUES (?, ?, ?, ?, ?, ?)";
        
        // Preparar la consulta
        $stmt = $this->conexion->prepare($sql);
        
        // Asegurarse de que los parámetros estén en el orden correcto
        $stmt->bind_param("ssssss", $nombre, $apellido, $dni, $legajo, $mail, $contraseña);
        
        // Ejecutar la consulta y retornar el resultado
        return $stmt->execute();
    }

    public function read_bedel()
    {
        $sql = "SELECT * FROM bedeles";
        $res = mysqli_query($this->conexion, $sql);
        return $res;
    }

    public function single_record_bedel($id)
    {
        $sql = "SELECT * FROM bedeles WHERE id='$id'";
        $res = mysqli_query($this->conexion, $sql);
        return mysqli_fetch_object($res);
    }

    public function update_bedel($nombre, $apellido, $dni, $mail, $legajo, $contraseña, $id)
    {
        $sql = "UPDATE bedeles SET nombre=?, apellido=?, dni=?, mail=?, legajo=?, contraseña=? WHERE id=?";
        $query = $this->conexion->prepare($sql);
        $query->bind_param("ssssssi", $nombre, $apellido, $dni, $mail, $legajo, $contraseña, $id);
        
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_bedel($id)
    {
        $sql = "DELETE FROM bedeles WHERE id=?";
        $query = $this->conexion->prepare($sql);
        $query->bind_param("i", $id);
        
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>