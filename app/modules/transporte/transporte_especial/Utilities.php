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

    $valid = "SELECT secuencia FROM tra_recorridos WHERE secuencia = {$secuencia} AND ruta = {$id_ruta}";
    $res = $db->sql_exec($valid);
    if($res->num_rows > 0) {
      throw new InvalidArgumentException("No puede guardar una parada con una secuencia existente");
    }

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


    $valid = "SELECT secuencia FROM tra_recorridos WHERE secuencia = {$secuencia} AND ruta = {$id_ruta}";

    if($db->sql_exec($valid)) {
      throw new InvalidArgumentException("No puede guardar una parada con una secuencia existente");
    }

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
        "text" => "{$row->nombre_proveedor} ({$row->numero_contrato})",
        "numero_contrato" => $row->numero_contrato
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

  public static function getVehiculos($db) {
    $db->conectar();

    $sql = "SELECT * FROM tra_vehiculos";

    $resultado = $db->sql_exec($sql);

    $data = [];
    while ($row = mysqli_fetch_object($resultado)) {
      $data[] = array(
        "id" => (int)$row->id,
        "text" => "({$row->placa}) {$row->propietario}",
        "num_pasajeros" => $row->num_pasajeros
      );
    }

    return json_encode($data);
  }

  public static function getConductores($db) {
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

  public static function getAuxiliares($db) {
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
        "fecha_registro" => date("Y-m-d H:i:s", time())
      ];

      $db->beginTransaction();

      $consult = $db->executeTransactionQuery("SELECT num_pasajeros FROM tra_vehiculos WHERE id = {$vehiculo}");

      if(!$consult) {
        throw new InvalidArgumentException("No se encontró el vehiculo seleccionado");
      }

      $vehi = mysqli_fetch_object($consult);

      if ($vehi->num_pasajeros < $numPasajeros) {
        throw new InvalidArgumentException("La cantidad de pasajeros ingresada en la ruta es mayor a la disponible en el vehículo seleccionado");
      }

      $res1 = $db->inserTransaction("tra_rutas", $data);
      if (!$res1) $db->rollbackTransaction();
      $idRuta = $db->getLastId();

      if(isset($parada) && count($parada) > 0) {
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
      }

      $upd = $db->executeTransactionQuery("UPDATE tra_vehiculos SET num_pasajeros = num_pasajeros - {$numPasajeros} WHERE id = {$vehiculo} ");

      if (!$upd) {
          throw new InvalidArgumentException("No se pudo actualizar la cantidad de asignaciones en el vehículo seleccionado");
      }

      $db->commitTransaction();


      return json_encode(["success" => true, "message" => "Se ha guardado exitosamente la ruta"]);
  }

  public static function getOneVehiculo($db, $parameter) {
    $db->conectar();

    $sql = "SELECT vehi.*, provee.numero_contrato ".
           "FROM tra_rutas as ruta ".
           "INNER JOIN tra_vehiculos vehi ".
           "ON ruta.vehiculo_id = vehi.id ".
           "INNER JOIN tra_proveedor as provee ".
           "ON vehi.id_proveedor = provee.id ".
           "WHERE ruta.id = {$parameter}";

    $result = $db->sql_exec($sql);

    $data = mysqli_fetch_object($result);

    return json_encode($data);
  }

  public static function getOneConductor($db, $parameter) {
    $db->conectar();

    $sql = "SELECT condu.* ".
           "FROM tra_rutas as ruta ".
           "INNER JOIN tra_conductores condu ".
           "ON ruta.conductor_id = condu.id ".
           "WHERE ruta.id = {$parameter}";

    $result = $db->sql_exec($sql);

    $data = mysqli_fetch_object($result);

    return json_encode($data);
  }

  public static function getOneAuxiliar($db, $parameter) {
    $db->conectar();

    $sql = "SELECT aux.* ".
           "FROM tra_rutas as ruta ".
           "INNER JOIN tra_auxiliar aux ".
           "ON ruta.auxiliar_id = aux.id ".
           "WHERE ruta.id = {$parameter}";

    $result = $db->sql_exec($sql);

    $data = mysqli_fetch_object($result);

    return json_encode($data);
  }

  public static function updateVehiculo($db, $parameters) {
    $db->conectar();

    extract($parameters);

    $sql = "UPDATE tra_vehiculos SET marca_vehiculo = '{$marcaVehiculo}', placa = '{$placaVehiculo}', propietario = '{$propietarioVehiculo}', ".
           //"tarjeta_operacion = '{$numtarjetaope}', soat = '{$numsoat}', num_pasajeros = {$numpasajeros}, fecha_soat = '{$fechavencisoat}', seguro_contractual = '{$seguroContractual}', ".
           "tarjeta_operacion = '{$numtarjetaope}', soat = '{$numsoat}', fecha_soat = '{$fechavencisoat}', seguro_contractual = '{$seguroContractual}', ".
           "seguro_extracontractual = '{$seguroExtraContractual}', tipo_zona = '{$tipoZona}' WHERE id = {$idVehiculo}";

    $resultado = $db->sql_exec($sql);

    return json_encode(["success" => $resultado, "message" => "El vehículo fue actualizado exitosamente"]);
  }

  public static function updateConductor($db, $parameters){
    $db->conectar();

    extract($parameters);

    $sql = "UPDATE tra_conductores SET tipodoc_id = '{$tipoDocumentoCond}', documento = '{$documentCond}', primernombre = '{$primerNombreCond}', ".
           "segundonombre = '{$segundoNombreCond}', primerapellido = '{$primerApellidoCond}', segundoapellido = '{$segundoApellidoCond}', ".
           "direccion = '{$direccionResidenciaCond}', celular = '{$numCelularCond}', licencia = '{$licenciaConduccion}', categoria = '{$categoriaAutorizada}', ".
           "fecha_vencimiento = '".date('Y-m-d', strtotime($fechavencilince))."' WHERE id = {$idConductor}";

    $resultado = $db->sql_exec($sql);

    return json_encode(["success" => $resultado, "message" => "El conductor fue actualizado exitosamente"]);
  }

  public static function updateAuxiliar($db, $parameters) {
    $db->conectar();

    extract($parameters);

    $sql = "UPDATE tra_auxiliar SET tipodoc_id = '{$tipoDocumentoAux}', documento = '{$documentoAux}', primernombre = '{$primerNombreAux}', ".
           "segundonombre = '{$segundoNombreAux}', primerapellido = '{$primerApellidoAux}', segundoapellido = '{$segundoApellidoAux}', ".
           "direccion = '{$direccionResidenciaAux}', celular = '{$numCelularAux}', formacion = '{$formacionAcadeAux}' WHERE id = {$idAuxiliar}";

    $resultado = $db->sql_exec($sql);

    return json_encode(["success" => $resultado, "message" => "El auxiliar fue actualizado exitosamente"]);
  }

  public static function getDataRoute($db, $parameter) {
    $db->conectar();

    $sql = "SELECT ruta.*, provee.nombre_proveedor, ieo.descripcion as ieo, vehi.num_pasajeros as num_pasajeros_disp  FROM tra_rutas as ruta ".
            "INNER JOIN tra_proveedor as provee ".
            " ON ruta.numero_contrato = provee.id ".
            "INNER JOIN mat_instituciones as ieo ".
            "ON ruta.institucion_id = ieo.id ".
            "INNER JOIN tra_vehiculos as vehi ".
            "ON ruta.vehiculo_id = vehi.id ".
            "WHERE ruta.id = {$parameter}";

    $resul = $db->sql_exec($sql);

    if(!$resul) throw new InvalidArgumentException("No se encontró la ruta seleccionada");

    $data = mysqli_fetch_object($resul);

    return json_encode($data);
  }

  public static function createVehiculo($db, $parameters){
    $db->conectar();

    extract($parameters);

    $data = [
      "marca_vehiculo" => filter_var($marcaVehiculo, FILTER_SANITIZE_STRING),
      "placa" => filter_var($placaVehiculo, FILTER_SANITIZE_STRING),
      "propietario" => filter_var($propietarioVehiculo, FILTER_SANITIZE_STRING),
      "tarjeta_operacion" => filter_var($numtarjetaope, FILTER_SANITIZE_STRING),
      "soat" => filter_var($numsoat, FILTER_SANITIZE_STRING),
      "fecha_soat" => filter_var($fechavencisoat, FILTER_SANITIZE_STRING),
      "num_pasajeros" => filter_var($numpasajeros, FILTER_SANITIZE_NUMBER_INT),
      "tecnico_mecanica" => filter_var($numrevitecnomec, FILTER_SANITIZE_STRING),
      "fecha_tecnico" => filter_var($fecharevitecnomec, FILTER_SANITIZE_STRING),
      "seguro_contractual" => filter_var($seguroContractual, FILTER_SANITIZE_STRING),
      "seguro_extracontractual" => filter_var($seguroExtraContractual, FILTER_SANITIZE_STRING),
      "tipo_zona" => filter_var($tipoZona, FILTER_SANITIZE_STRING),
      "fecha_registro" => date("Y-m-d", time())
    ];

    $result = $db->insert("tra_vehiculos", $data);

    if (!$result) {
      throw new InvalidArgumentException("No se pudo guardar el vehículo correctamente");
    }

    return json_encode(["success" => $result, "message" => "El vehículo fue creado exitosamente"]);
  }

  public static function createConductor($db, $parameters){
    $db->conectar();

    extract($parameters);

    $data = [
      "tipodoc_id" => filter_var($tipoDocumentoCond, FILTER_SANITIZE_NUMBER_INT),
      "documento" => filter_var($documentCond, FILTER_SANITIZE_STRING),
      "primernombre" => filter_var($primerNombreCond, FILTER_SANITIZE_STRING),
      "segundonombre" => filter_var($segundoNombreCond, FILTER_SANITIZE_STRING),
      "primerapellido" => filter_var($primerApellidoCond, FILTER_SANITIZE_STRING),
      "segundoapellido" => filter_var($segundoApellidoCond, FILTER_SANITIZE_STRING),
      "direccion" => filter_var($direccionResidenciaCond, FILTER_SANITIZE_STRING),
      "celular" => filter_var($numCelularCond, FILTER_SANITIZE_STRING),
      "licencia" => filter_var($licenciaConduccion, FILTER_SANITIZE_STRING),
      "categoria" => filter_var($categoriaAutorizada, FILTER_SANITIZE_STRING),
      "fecha_vencimiento" => filter_var($fechavencilince, FILTER_SANITIZE_STRING),
      "fecha_registro" => date("Y-m-d H:i:s", time())
    ];

    $result = $db->insert("tra_conductores", $data);

    if (!$result) {
      throw new InvalidArgumentException("No se pudo guardar el conductor correctamente");
    }

    return json_encode(["success" => $result, "message" => "El conductor fue creado exitosamente"]);
  }

  public static function createAuxiliar($db, $paramaters) {
    $db->conectar();

    extract($paramaters);

    $data = [
      "tipodoc_id" => filter_var($tipoDocumentoAux, FILTER_SANITIZE_NUMBER_INT),
      "documento" => filter_var($documentoAux, FILTER_SANITIZE_STRING),
      "primernombre" => filter_var($primerNombreAux, FILTER_SANITIZE_STRING),
      "segundonombre" => filter_var($segundoNombreAux, FILTER_SANITIZE_STRING),
      "primerapellido" => filter_var($primerApellidoAux, FILTER_SANITIZE_STRING),
      "segundoapellido" => filter_var($segundoApellidoAux, FILTER_SANITIZE_STRING),
      "direccion" => filter_var($direccionResidenciaAux, FILTER_SANITIZE_STRING),
      "celular" => filter_var($numCelularAux, FILTER_SANITIZE_STRING),
      "formacion" => filter_var($formacionAcadeAux, FILTER_SANITIZE_STRING),
      "fecha_registro" => date("Y-m-d H:i:s", time()),
    ];

    $result = $db->insert("tra_auxiliar", $data);

    if (!$result) {
      throw new InvalidArgumentException("No se pudo guardar el auxiliar correctamente");
    }

    return json_encode(["success" => $result, "message" => "El auxiliar fue creado exitosamente"]);
  }
}