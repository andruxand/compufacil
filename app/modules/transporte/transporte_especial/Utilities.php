<?php
/**
 * Created by PhpStorm.
 * User: juanc
 * Date: 13/04/2018
 * Time: 14:09
 */

class Utilities {

  public static function consultarRutas($db, $parameter) {
    $db->conectar();
    $parameter = filter_var($parameter, FILTER_SANITIZE_STRING);
    $sql = "SELECT id, nombre_ruta "
      . "FROM tra_rutas "
      . "WHERE nombre_ruta LIKE '%{$parameter}%' "
      . "LIMIT 15";

    $resultado = $db->sql_exec($sql);

    $data = [];
    while ($row = mysqli_fetch_object($resultado)) {
      $data[] = array(
        "id" => (int)$row->id,
        "text" => $row->nombre_ruta
      );
    }

    return json_encode($data);
  }

  public static function consultaRecorridos($db, $parameter) {
    $db->conectar();

    $parameter = filter_var($parameter, FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * "
      . "FROM tra_recorridos "
      . "WHERE ruta = {$parameter} "
      . "ORDER BY secuencia";

    $resultado = $db->sql_exec($sql);

    $data = [];
    while ($row = mysqli_fetch_object($resultado)) {
      $data[] = array(
        "id" => $row->id,
        "ruta" => $row->ruta,
        "secuencia" => $row->secuencia,
        "nombre_parada" => $row->nombre_parada,
        "direccion" => $row->direccion,
        "hora_llegada" => $row->hora_llegada,
        "hora_partida" => $row->hora_partida
      );
    }

    return json_encode($data);
  }

  public static function consultaRecorrido($db, $parameter) {
    $db->conectar();

    $parameter = filter_var($parameter, FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * "
      . "FROM tra_recorridos "
      . "WHERE id = {$parameter}";

    $resultado = $db->sql_exec($sql);

    $data = mysqli_fetch_object($resultado);

    return json_encode($data);
  }

  public static function saveParada($db, $parameters) {
    $db->conectar();

    extract($parameters);

    $id_ruta = filter_var($id_ruta, FILTER_SANITIZE_NUMBER_INT);
    $id_parada = filter_var($id_parada, FILTER_SANITIZE_NUMBER_INT);
    $secuencia = filter_var($secuencia, FILTER_SANITIZE_NUMBER_INT);
    $nom_parada = filter_var($nom_parada, FILTER_SANITIZE_STRING);
    $direccion = filter_var($direccion, FILTER_SANITIZE_STRING);
    $hora_llegada = filter_var($hora_llegada, FILTER_SANITIZE_STRING);
    $hora_partida = filter_var($hora_partida, FILTER_SANITIZE_STRING);

    $data = [
      "ruta" => $id_ruta,
      "secuencia" => $secuencia,
      "nombre_parada" => $nom_parada,
      "direccion" => $direccion,
      "hora_llegada" => $hora_llegada,
      "hora_partida" => $hora_partida,
      "fecha_registro" => date('d/m/Y', time())
    ];

    $resultado = $db->insert("tra_recorridos", $data);

    return json_encode(["success" => $resultado, "message" => "La parada fue creada exitosamente"]);
  }

  public static function updateParada($db, $parameters) {
    $db->conectar();

    extract($parameters);

    $id_ruta = filter_var($id_ruta, FILTER_SANITIZE_NUMBER_INT);
    $id_parada = filter_var($id_parada, FILTER_SANITIZE_NUMBER_INT);
    $secuencia = filter_var($secuencia, FILTER_SANITIZE_NUMBER_INT);
    $nom_parada = filter_var($nom_parada, FILTER_SANITIZE_STRING);
    $direccion = filter_var($direccion, FILTER_SANITIZE_STRING);
    $hora_llegada = filter_var($hora_llegada, FILTER_SANITIZE_STRING);
    $hora_partida = filter_var($hora_partida, FILTER_SANITIZE_STRING);

    $sql = "UPDATE tra_recorridos "
      . "SET nombre_parada = '{$nom_parada}', "
      . "secuencia = {$secuencia}, "
      . "direccion = '{$direccion}', "
      . "hora_llegada = '{$hora_llegada}', "
      . "hora_partida = '{$hora_partida}' "
      . "WHERE id = {$id_parada} AND "
      . "ruta = {$id_ruta}";

    $resultado = $db->sql_exec($sql);

    $response = true;
    if (!$resultado) $response = false;

    return json_encode(["success" => $response, "message" => "La parada fue actualizada exitosamente"]);
  }

  public static function deleteParada($db, $parameter) {
    $db->conectar();

    $parameter = filter_var($parameter, FILTER_SANITIZE_NUMBER_INT);

    $sql = "DELETE FROM tra_recorridos WHERE id = {$parameter}";

    $resultado = $db->sql_exec($sql);

    return json_encode(["success" => $resultado, "message" => "La parada fue eliminada exitosamente"]);
  }

  public static function getProveedores($db) {
    $db->conectar();

    $sql = "SELECT * FROM tra_proveedor";

    $resultado = $db->sql_exec($sql);

    $data = [];
    while ($row = mysqli_fetch_object($resultado)) {
      $data[] = array(
        "id" => (int)$row->id,
        "text" => "{$row->nombre_proveedor} ({$row->numero_contrato})"
      );
    }

    return json_encode($data);
  }

  public static function getIeo($db, $parameter) {
    $db->conectar();

    $sql = "SELECT * FROM mat_instituciones WHERE descripcion LIKE '%{$parameter}%' OR coddane LIKE '%{$parameter}%' LIMIT 15";

    $resultado = $db->sql_exec($sql);

    $data = [];
    while ($row = mysqli_fetch_object($resultado)) {
      $data[] = array(
        "id" => (int)$row->id,
        "text" => "({$row->coddane}) {$row->descripcion}"
      );
    }

    return json_encode($data);
  }

  public static function getVehiculo($db) {
    $db->conectar();

    $sql = "SELECT * FROM tra_vehiculos";

    $resultado = $db->sql_exec($sql);

    $data = [];
    while ($row = mysqli_fetch_object($resultado)) {
      $data[] = array(
        "id" => (int)$row->id,
        "text" => "({$row->placa}) {$row->propietario}"
      );
    }

    return json_encode($data);
  }

  public static function getConductor($db) {
    $db->conectar();

    $sql = "SELECT * FROM tra_conductores";

    $resultado = $db->sql_exec($sql);

    $data = [];
    while ($row = mysqli_fetch_object($resultado)) {
      $data[] = array(
        "id" => (int)$row->id,
        "text" => "({$row->documento}) {$row->primernombre} {$row->primerapellido}"
      );
    }

    return json_encode($data);
  }

  public static function getAuxiliar($db) {
    $db->conectar();

    $sql = "SELECT * FROM tra_auxiliar";

    $resultado = $db->sql_exec($sql);

    $data = [];
    while ($row = mysqli_fetch_object($resultado)) {
      $data[] = array(
        "id" => (int)$row->id,
        "text" => "({$row->documento}) {$row->primernombre} {$row->primerapellido}"
      );
    }

    return json_encode($data);
  }

  public static function createRuta($db, $parameters) {
    try {
      $db->conectar();
      extract($parameters);

      $data = [
        "vigencia" => $vigencia,
        "nombre_ruta" => $nombreRuta,
        "numero_contrato" => $proveedor,
        "institucion_id" => $ieo,
        "vehiculo_id" => $vehiculo,
        "conductor_id" => $conductor,
        "auxiliar_id" => $auxiliar,
        "pasajeros" => $numPasajeros,
        "fecha_registro" => date("Y-m-d H:i:s", time())
      ];

      $db->beginTransaction();
      $res1 = $db->inserTransaction("tra_rutas", $data);
      if (!$res1) $db->rollbackTransaction();
      $idRuta = $db->getLastId();

      foreach ($parada as $key => $para) {
        $data = array(
          "ruta" => $idRuta,
          "secuencia" => $secuencia[$key],
          "nombre_parada" => $para,
          "direccion" => $direccion[$key],
          "hora_llegada" => $hora_llegada[$key],
          "hora_partida" => $hora_partida[$key],
          "fecha_registro" => date("Y-m-d H:i:s", time())
        );
        $res2 = $db->inserTransaction("tra_recorridos", $data);
        if (!$res2) {
          throw new \InvalidArgumentException("No se pudo guardar correctamente una de las paradas");
        }
      }
      $db->commitTransaction();

      return json_encode(["success" => true, "message" => "Se ha guardado exitosamente la ruta"]);
    } catch (\InvalidArgumentException $e) {
      $db->rollbackTransaction();
      return json_encode(["error" => $e->getMessage()]);
    } catch (\Exception $e) {
      $db->rollbackTransaction();
      return json_encode(["error" => $e->getMessage()]);
    }
  }
}