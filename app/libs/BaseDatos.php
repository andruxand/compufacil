<?php
require_once(APP_CONFIG_PATH . DS . "config.php");

class BaseDatos {

  protected $conexion;
  protected $db;
  public $db_error = '';
  public $db_info = '';

  public function conectar() {

    $this->conexion = mysqli_connect(HOST, USER, PASS, DBNAME);

    if (mysqli_connect_errno()) DIE("Lo sentimos, no se ha podido conectar con MySQL: " . mysqli_connect_error());

    mysqli_set_charset($this->conexion, "utf8");

    return true;
  }

  public function desconectar() {

    if ($this->conexion) {

      mysqli_close($this->conexion);

    }

  }

  //Ejecuta sentencias SQL
  function query_exec($query) {
    if ($this->conectar()) {
      $result = mysqli_query($this->conexion, $query);
      $this->db_info = mysqli_info($this->conexion);
      if (!$result) {
        $this->db_error = mysqli_error($this->conexion);
      }
      $this->desconectar();
      return $result;
    }
  }

  //Función Insertar
  function insert($tblname, $form_data) {

    $fields = array_keys($form_data);

    $sql = "INSERT INTO " . $tblname . "(" . implode(',', $fields) . ")  VALUES('" . implode("','", $form_data) . "')";

    return $this->query_exec($sql);
  }

  //Función para Select y update
  function sql_exec($query) {

    return $this->query_exec($query);

  }

  function show_db_error() {

    return "<div class='alert alert-danger' role='alert'>" .
      " <span class='oi oi-circle-x' title='icon name' aria-hidden='true'></span>" .
      " Error al consultar la base de datos: " . $this->db_error .
      "</div>";

  }

  function beginTransaction() {

    return mysqli_autocommit($this->conexion, FALSE);

  }

  function executeTransactionQuery($query) {

      $result = mysqli_query($this->conexion, $query);

      if (!$result) {
        $this->db_error = mysqli_error($this->conexion);
      }

      return $result;
  }

  function inserTransaction($tblname, $form_data){

    $fields = array_keys($form_data);
    $sql = "INSERT INTO " . $tblname . "(" . implode(',', $fields) . ")  VALUES('" . implode("','", $form_data) . "')";

    return $this->executeTransactionQuery($sql);
  }

  function getLastId() {

    return mysqli_insert_id($this->conexion);

  }

  function commitTransaction() {

    mysqli_commit($this->conexion);

    $this->desconectar();

  }

  function rollbackTransaction() {

    mysqli_rollback($this->conexion);

    $this->conectar();

  }

  function loadRoles($userId){

    $sql = " SELECT ug.id, ug.title
             FROM min_usergroups ug, min_user_usergroup_map ugm
             WHERE 
             ug.id = ugm.group_id
             AND ugm.user_id = " . $userId; 

    $roles = $this->sql_exec( $sql );

    if( $roles ){

          $totalRows= mysqli_num_rows($roles);  

          if( $totalRows > 0 ){

            $lista_roles = array();

            while( $row = mysqli_fetch_array($roles) ) { 

              array_push($lista_roles, $row['id']);

            }

            return $lista_roles;

          }else{
            return False;
          }

    }else{
      return False;
    }

  }

  function verifyRoles($userRoles, $roles){

    $existe = 0;

    foreach ($userRoles as $value1) {

      foreach ($roles as $value2) {
            
        if ($value1 == $value2){
          $existe++;
        }

      }

    }

    if($existe > 0){
      return true;
    }else{
      return false;  
    }
    


  }


}

?>