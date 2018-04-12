<?php

require_once ( APP_CONFIG_PATH . DS . "config.php" );

class BaseDatos
{
    protected $conexion;
    protected $db;

    public function conectar()
    {
        $this->conexion = mysqli_connect(HOST, USER, PASS);

        if ($this->conexion == 0) DIE("Lo sentimos, no se ha podido conectar con MySQL: " . mysqli_error());

        $this->db = mysqli_select_db(DBNAME, $this->conexion);

        if ($this->db == 0) DIE("Lo sentimos, no se ha podido conectar con la base datos: " . DBNAME);

        return true;

    }

    public function desconectar()
    {
        if ($this->conectar->conexion) {
            mysqli_close($this->$conexion);
        }

    }

    public function pruebadb($query)
    {
        $tabla = "TU_TABLA";
        $query = mysqli_query($query, $this->conexion);
        if ($query == 0) echo "Sentencia incorrecta llamado a tabla: $tabla.";
        else {
            $nregistrostotal = mysqli_result($query, 0, 0);
            echo "Hay $nregistrostotal registros en la tabla: $tabla.";
            mysqli_free_result($query);
        }
    }
}

?>