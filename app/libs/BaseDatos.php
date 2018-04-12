<?php

require_once ( APP_CONFIG_PATH . DS . "config.php" );

class BaseDatos
{
    protected $conexion;
    protected $db;
    public $db_error = '';

    public function conectar()
    {
        $this->conexion = mysqli_connect(HOST, USER, PASS, DBNAME);

        if (mysqli_connect_errno()) DIE("Lo sentimos, no se ha podido conectar con MySQL: " . mysqli_connect_error());

        mysqli_set_charset($this->conexion,"utf8");    

        return true;

    }

    public function desconectar()
    {
        if ($this->conexion) {
            mysqli_close($this->conexion);
        }

    }

    //Ejecuta sentencias SQL
    function query_exec($query) {
        if($this->conectar()){
            $result = mysqli_query($this->conexion, $query);

            if(!$result){
                $this->db_error = mysqli_error($this->conexion);
            }

            $this->desconectar();
            return $result;
        }
    }

    //Función Insertar
    function insert($tblname, $form_data){
        $fields = array_keys($form_data);
        $sql = "INSERT INTO " . $tblname . "(" . implode(',', $fields) . ")  VALUES('" . implode("','", $form_data) . "')";
        
        return $this->query_exec($sql);
    }

    //Función para Select y update
    function sql_exec($query){    
        return $this->query_exec($query);
    }

    function show_db_error(){
        return  "<div class='alert alert-danger' role='alert'>" .
                " <span class='oi oi-circle-x' title='icon name' aria-hidden='true'></span>" .
                " Error al consultar la base de datos: " . $this->db_error .
                "</div>";
    }

}

?>