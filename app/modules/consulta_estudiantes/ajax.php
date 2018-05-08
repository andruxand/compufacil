<?php

require_once '../../config/autoload.php';
header('Content-Type: application/json');
switch ($_GET["router"]) {
  case "listar-estudiantes":
    $columns = array(
      "documento",
      "nombre",
      "grado",
      "jornada",
      "institucion",
      "sede",
      "acciones"
    );

    $sql = " SELECT DISTINCT
                                    est.id idEstudiante,
                                    est.numero_identificacion documento,
                                    CONCAT(est.nombre1,' ',est.nombre2,' ', est.apellido1, ' ', est.apellido2) as nombre,
                                    niv.descripcion grado,
                                    jor.descripcion jornada,
                                    inst.descripcion institucion,
                                    se.descripcion sede
                                    FROM 
                                    mat_estudiantes                             est
                                    LEFT OUTER JOIN mat_matriculas              mtr  ON  mtr.id_estudiantes            =  est.id
                                    LEFT OUTER JOIN mat_paralelos               par  ON  mtr.id_paralelos              =  par.id
                                    LEFT OUTER JOIN mat_sedes_niveles           sn   ON  par.id_sedes_niveles          =   sn.id
                                    LEFT OUTER JOIN mat_sedes                   se   ON   sn.id_sedes                  =   se.id
                                    LEFT OUTER JOIN mat_instituciones           inst ON   se.id_instituciones          = inst.id
                                    LEFT OUTER JOIN mat_sectores                sec  ON inst.id_sectores               =  sec.id
                                    LEFT OUTER JOIN mat_niveles                 niv  ON   sn.id_niveles                =  niv.id
                                    LEFT OUTER JOIN mat_barrios_veredas         bv   ON   se.id_barrios_veredas        =   bv.id
                                    LEFT OUTER JOIN mat_comunas_corregimientos  cc   ON   bv.id_comunas_corregimientos =   cc.id
                                    LEFT OUTER JOIN mat_sedes_jornadas          sj   ON  par.id_sedes_jornadas         =   sj.id
                                    LEFT OUTER JOIN mat_jornadas                jor  ON   sj.id_jornadas               =  jor.id

                                    LEFT OUTER JOIN mat_ie_usuarios us     ON inst.coddane = us.institucion_coddane

                                    WHERE 
                                        est.estado = 'MATRICULADO'  ";

    if (!empty($_POST["documento"])) {
      $sql .= ' AND est.numero_identificacion LIKE "' . $_POST["documento"] . '"';
    }

    if (!empty($_POST["nombre1"])) {
      $sql .= ' AND est.nombre1 LIKE "' . $_POST["nombre1"] . '%"';
    }

    if (!empty($_POST["nombre2"])) {
      $sql .= ' AND est.nombre2 LIKE "' . $_POST["nombre1"] . '%"';
    }

    if (!empty($_POST["apellido1"])) {
      $sql .= ' AND est.apellido1 LIKE "' . $_POST["apellido1"] . '%"';
    }

    if (!empty($_POST["apellido2"])) {
      $sql .= ' AND est.apellido2 LIKE "' . $_POST["apellido2"] . '%"';
    }

    if (!empty($_POST["vigencia"])) {
      $sql .= ' AND mtr.anio_lectivo = "' . $_POST["vigencia"] . '"';
    }

    $estudiantes = $db->sql_exec($sql);

    if ($estudiantes) {
      $totalglobal = mysqli_num_rows($estudiantes);
    }

    if (isset($_POST["order"])) {
      $sql .= ' ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
      $sql .= ' ORDER BY se.coddane DESC ';
    }

    if ($_POST["length"] != -1) {
      $sql .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $estudiantes = $db->sql_exec($sql);

    if ($estudiantes) {
      $totalFiltered = mysqli_num_rows($estudiantes);

      if ($totalFiltered > 0) {
        $data = array();

        while ($row = mysqli_fetch_array($estudiantes)) {
          $nestedData[] = array(
            $columns[0] => $row["documento"],
            $columns[1] => $row["nombre"],
            $columns[2] => $row["grado"],
            $columns[3] => $row["institucion"],
            $columns[4] => $row["sede"],
            $columns[5] => $row["jornada"],
            $columns[6] => "<button type='button' class='btn btn-outline-primary showDetail' id='showDetail' data-id='{$row["idEstudiante"]}'>Ver Detalle</button>"
          );

        }

        $data = $nestedData;

        $json_data = array(
          "draw" => intval($_POST["draw"]),
          "recordsTotal" => intval($totalFiltered),
          "recordsFiltered" => intval($totalglobal),
          "data" => $data
        );

        echo json_encode($json_data);

      } else {
        $json_data = array(
          "draw" => intval($_POST["draw"]),
          "recordsTotal" => intval(0),
          "recordsFiltered" => intval(0),
          "data" => ''
        );

        echo json_encode($json_data);

      }
    } else {

      $json_data = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => intval(0),
        "recordsFiltered" => intval(0),
        "data" => ''
      );

      echo json_encode($json_data);
    }
    break;
  case "get-info-estudent":

    $id = $_GET["id"];

    if (empty($id)) {
      echo json_encode(["success" => false]);
    }

    $sql = "SELECT
                  CONCAT( est.nombre1, ' ', est.nombre2, ' ', est.apellido1, ' ', est.apellido2 ) as nombres,
                  est.numero_identificacion,
                  est.fecha_nacimiento,
                  gene.descripcion as genero,
                  est.direccion,
                  bv.descripcion as barrio,
                  cc.descripcion as comuna,
                  inst.descripcion as institucion,
                  se.descripcion as sede,
                  niv.descripcion as grado,
                  jor.descripcion as jornada,
                  acu.tipoDocumento as tipoDocumentoAcu,
                  acu.numeroDocumento as numDocumentoAcu,
                  acu.nombres as nombresAcu,
                  acu.apellidos as apellidosAcu,
                  acu.mail as correoAcu,
                  acu.celular as celularAcu,
                  parentes.descripcion as parentescoAcu
              FROM
                  mat_estudiantes AS est #Estudiantes
                  INNER JOIN mat_generos AS gene ON est.id_generos = gene.id
                  LEFT JOIN mat_acudientes AS acu ON est.id = acu.mat_estudiantes_id
                  LEFT JOIN mat_parentesco AS parentes ON acu.parentesco = parentes.id
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

    echo json_encode(["success" => true, "data" => $data]);

    break;

  case "get-trans-mio":
    $id = $_GET["id"];

    if (empty($id)) {
      echo json_encode(["success" => false]);
    }

    $sql = "SELECT
                  atmio.caracterizacion,
                  atmio.fecha_asignacion,
                  tmio.nro_tarjeta,
                  tmio.nro_sem,
                  tmio.saldo 
              FROM
                  tra_AsignacionTrjetasMio atmio
                  INNER JOIN tra_TarjetaMIO tmio ON atmio.id_tarjeta = tmio.id_tarjeta 
              WHERE
                  atmio.id_estudiante = {$id}";

    $result = $db->sql_exec($sql);
    $data = false;
    if ($result->num_rows > 0) {
      $data = mysqli_fetch_object($result);
    }

    echo json_encode(["success" => true, "data" => $data]);

    break;

  case "get-trans-especial":
    $id = $_GET["id"];

    if (empty($id)) {
      echo json_encode(["success" => false]);
    }

    $sql = "SELECT
                  ates.caracterizacion,
                  ates.fecha_asignacion,
                  rut.nombre_ruta,
                  rut.vigencia
              FROM
                  tra_AsignaTransEspec ates
                  inner join tra_rutas rut
                  on ates.id_ruta = rut.id
              WHERE
                  id_estudiante = {$id}";

    $result = $db->sql_exec($sql);
    $data = false;
    if ($result->num_rows > 0) {
      $data = mysqli_fetch_object($result);
    }

    echo json_encode(["success" => true, "data" => $data]);

    break;
}