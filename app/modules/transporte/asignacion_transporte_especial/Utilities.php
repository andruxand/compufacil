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

//    $sql = "SELECT * FROM mat_simatsubeestudiantes " .
//      "WHERE estado = 'MATRICULADO' ";
    $sql = "SELECT
                  est.id as idEstu,
                  CONCAT( est.nombre1, ' ', est.nombre2, ' ', est.apellido1, ' ', est.apellido2 ) as nombres,
                  est.numero_identificacion as doc,
                  est.fecha_nacimiento,
                  est.direccion,
                  inst.descripcion as institucion,
                  se.descripcion as sede,
                  niv.descripcion as grado,
                  jor.descripcion as jornada
              FROM
                  mat_estudiantes AS est #Estudiantes
                  INNER JOIN mat_matriculas AS mtr ON est.id = mtr.id_estudiantes
                  INNER JOIN mat_paralelos AS par ON mtr.id_paralelos = par.id
                  INNER JOIN mat_sedes_niveles AS sn ON par.id_sedes_niveles = sn.id
                  INNER JOIN mat_sedes AS se ON sn.id_sedes = se.id
                  INNER JOIN mat_instituciones AS inst ON se.id_instituciones = inst.id
                  INNER JOIN mat_niveles AS niv ON sn.id_niveles = niv.id
                  INNER JOIN mat_sedes_jornadas AS sj ON par.id_sedes_jornadas = sj.id
                  INNER JOIN mat_jornadas AS jor ON sj.id_jornadas = jor.id WHERE 1 = 1 ";

    if (!empty($parameters["documento"])) {
      $sql .= "AND est.numero_identificacion = {$parameters["documento"]} ";
    }
    if (!empty($parameters["primer-apellido"])) {
      $sql .= "AND est.apellido1 LIKE '{$parameters["primer-apellido"]}%' ";
    }
    if (!empty($parameters["segundo-apellido"])) {
      $sql .= "AND est.apellido2 LIKE '{$parameters["segundo-apellido"]}%' ";
    }
    if (!empty($parameters["primer-nombre"])) {
      $sql .= "AND est.nombre1 LIKE '{$parameters["primer-nombre"]}%' ";
    }
    if (!empty($parameters["segundo-nombre"])) {
      $sql .= "AND est.nombre2 LIKE '{$parameters["segundo-nombre"]}%' ";
    }

    $sql .= "LIMIT 20";
    $result = $db->sql_exec($sql);
    $data = [];
    if ($result){
      while ($row = mysqli_fetch_object($result)) {
        $data[] = array(
          "id" => $row->idEstu,
          "documento" => $row->doc,
          "name" => $row->nombres,
          "jornada" => $row->jornada,
          "grado" => $row->grado,
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

//    $sql = "SELECT * FROM mat_simatsubeestudiantes " .
//      "WHERE estado = 'MATRICULADO' AND id = {$id}";

    $sql = "SELECT
                  est.id as idEstu,
                  CONCAT( est.nombre1, ' ', est.nombre2, ' ', est.apellido1, ' ', est.apellido2 ) as nombres,
                  est.numero_identificacion as doc,
                  est.fecha_nacimiento,
                  gene.descripcion as genero,
                  est.direccion,
                  inst.descripcion as institucion,
                  se.descripcion as sede,
                  niv.descripcion as grado,
                  jor.descripcion as jornada,
                  bv.descripcion as barrio,
                  cc.descripcion as comuna
              FROM
                  mat_estudiantes AS est #Estudiantes
                  INNER JOIN mat_generos AS gene ON est.id_generos = gene.id
                  INNER JOIN mat_matriculas AS mtr ON est.id = mtr.id_estudiantes
                  INNER JOIN mat_paralelos AS par ON mtr.id_paralelos = par.id
                  INNER JOIN mat_sedes_niveles AS sn ON par.id_sedes_niveles = sn.id
                  INNER JOIN mat_sedes AS se ON sn.id_sedes = se.id
                  INNER JOIN mat_instituciones AS inst ON se.id_instituciones = inst.id
                  INNER JOIN mat_niveles AS niv ON sn.id_niveles = niv.id
                  INNER JOIN mat_barrios_veredas AS bv ON se.id_barrios_veredas = bv.id
                  INNER JOIN mat_comunas_corregimientos AS cc ON bv.id_comunas_corregimientos = cc.id
                  INNER JOIN mat_sedes_jornadas AS sj ON par.id_sedes_jornadas = sj.id
                  INNER JOIN mat_jornadas AS jor ON sj.id_jornadas = jor.id
              WHERE est.id = {$id}";

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