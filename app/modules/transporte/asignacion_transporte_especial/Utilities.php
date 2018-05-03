<?php
/**
 * Created by PhpStorm.
 * User: juanc
 * Date: 27/04/2018
 * Time: 5:39
 */

class Utilities {

  public static function getEstudiantes($db, $parameters) {
    $db->conectar();

    $sql = "SELECT * FROM mat_simatsubeestudiantes " .
      "WHERE estado = 'MATRICULADO' ";

    if (!empty($parameters["documento"])) {
      $sql .= "AND doc = {$parameters["documento"]} ";
    }
    if (!empty($parameters["primer-apellido"])) {
      $sql .= "AND apellido1 LIKE '%{$parameters["primer-apellido"]}%' ";
    }
    if (!empty($parameters["segundo-apellido"])) {
      $sql .= "AND apellido2 LIKE '%{$parameters["segundo-apellido"]}%' ";
    }
    if (!empty($parameters["primer-nombre"])) {
      $sql .= "AND nombre1 LIKE '%{$parameters["primer-nombre"]}%' ";
    }
    if (!empty($parameters["segundo-nombre"])) {
      $sql .= "AND nombre2 LIKE '%{$parameters["segundo-nombre"]}%' ";
    }

    $sql .= "LIMIT 20";
    $result = $db->sql_exec($sql);
    $data = [];
    if ($result){
      while ($row = mysqli_fetch_object($result)) {
        $data[] = array(
          "id" => $row->id,
          "documento" => $row->doc,
          "name" => "{$row->nombre1} {$row->nombre2} {$row->apellido1} {$row->apellido2}",
          "jornada" => $row->jornada,
          "grado" => $row->grado_cod,
          "institucion" => $row->institucion,
          "sede" => $row->sede
        );
      }
    }

    return json_encode($data);
  }

  public static function getEstudiante($db, $parameter) {
    $db->conectar();

    $id = filter_var($parameter, FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM mat_simatsubeestudiantes " .
      "WHERE estado = 'MATRICULADO' AND id = {$id}";

    $result = $db->sql_exec($sql);

    $data = mysqli_fetch_object($result);

    return json_encode($data);
  }

  public static function getRoutes($db, $parameter) {
    $db->conectar();

    $tipoZona = filter_var($parameter, FILTER_SANITIZE_STRING);

    $sql = "SELECT ruta.*, vehi.tipo_zona as zona FROM tra_rutas as ruta ".
            "INNER JOIN tra_vehiculos as vehi ".
            "ON ruta.vehiculo_id = vehi.id ".
            "WHERE tipo_zona LIKE '%{$tipoZona}%'";

    $result = $db->sql_exec($sql);

    $data = [];
    if ($result){
      while ($row = mysqli_fetch_object($result)) {
        $data[] = array(
          "id" => $row->id,
          "nombre_ruta" => $row->nombre_ruta,
          "zona" => $row->zona,
          "numPasajeros" => $row->pasajeros
        );
      }
    }

    return json_encode($data);
  }

  public static function asignarRuta($db, $parameters) {
    $db->conectar();

    $data = [
      "id_estudiante" => $parameters["idStudent"],
      "id_ruta" => $parameters["idRuta"],
      "caracterizacion" => $parameters["caracterizacion"],
      "fecha_asignacion" => date("Y-m-d", time())
    ];

    $db->beginTransaction();

    $consult1 =  $db->executeTransactionQuery("SELECT * FROM tra_AsignaTransEspec WHERE id_estudiante = {$parameters["idStudent"]}");

    if ($consult1->num_rows > 0) {
      throw new InvalidArgumentException("El estudiante ya tiene una ruta asignada");
    }

    $res1 = $db->inserTransaction("tra_AsignaTransEspec", $data);
    if (!$res1) $db->rollbackTransaction();

    $consult2 = $db->executeTransactionQuery("SELECT ruta.*, vehi.id as vehiId FROM tra_rutas as ruta INNER JOIN tra_vehiculos as vehi ON ruta.vehiculo_id = vehi.id WHERE ruta.id = {$parameters["idRuta"]}");

    if (!$consult2) {
      throw new InvalidArgumentException("No se encontró la ruta");
    }

    $resRuta = mysqli_fetch_object($consult2);

    $update1 = $db->executeTransactionQuery("UPDATE tra_vehiculos SET num_pasajeros = num_pasajeros - 1 WHERE id = {$resRuta->vehiId}");

    if (!$update1){
      $db->rollbackTransaction();
      throw new InvalidArgumentException("No se pudo actualizar la cantidad de pasajeros en el vehiculo");
    }

    $update2 = $db->executeTransactionQuery("UPDATE tra_rutas SET pasajeros = pasajeros + 1 WHERE id = {$resRuta->id}");

    if(!$update2) {
      $db->rollbackTransaction();
      throw new InvalidArgumentException("No se pudo actualizar la cantidad de pasajeros en la ruta");
    }

    $db->commitTransaction();

    return json_encode(["success" => true, "message" => "Ruta asignada con éxito"]);
  }

}