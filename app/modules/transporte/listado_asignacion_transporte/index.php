<?php
require_once('../../../config/autoload.php');
include('../../../hooks/head.php');

$idRuta = filter_var($_GET["ruta"], FILTER_SANITIZE_NUMBER_INT);

if (empty($idRuta)) {

}

$sqlList = "SELECT
                  est.numero_identificacion,
                  CONCAT( est.nombre1, ' ', est.nombre2, ' ', est.apellido1, ' ', est.apellido2 ) AS nombres,
                  est.direccion,
                  jor.descripcion AS jornada,
                  ruta.nombre_ruta,
                  vehi.tipo_zona,
                  ins.descripcion AS institucion
              FROM
                  tra_AsignaTransEspec ates
                  INNER JOIN mat_estudiantes est ON ates.id_estudiante = est.id
                  INNER JOIN mat_matriculas AS mtr ON est.id = mtr.id_estudiantes
                  INNER JOIN mat_paralelos AS par ON mtr.id_paralelos = par.id
                  INNER JOIN mat_sedes_niveles AS sn ON par.id_sedes_niveles = sn.id
                  INNER JOIN mat_sedes_jornadas AS sj ON par.id_sedes_jornadas = sj.id
                  INNER JOIN mat_jornadas AS jor ON sj.id_jornadas = jor.id
                  INNER JOIN tra_rutas AS ruta ON ates.id_ruta = ruta.id
                  INNER JOIN tra_vehiculos AS vehi ON ruta.vehiculo_id = vehi.id
                  INNER JOIN mat_sedes AS ins ON ruta.institucion_id = ins.id
              WHERE ates.id_ruta = {$idRuta}";

$result = $db->sql_exec($sqlList);

$data = [];
if ($result->num_rows > 0) {
  while ($row = mysqli_fetch_object($result)) {
    $data[] = array(
      "identificacion" => $row->numero_identificacion,
      "nombres" => $row->nombres,
      "direccion" => $row->direccion,
      "jornada" => $row->jornada,
      "nombre_ruta" => $row->nombre_ruta,
      "tipo_zona" => $row->tipo_zona,
      "institucion" => $row->institucion
    );
  }
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-dark-blue" id="container-list">
                <div class="card-header-dark-blue">
                    Impresión Soporte de Asignación
                </div>
                <div class="card-body">
                  <?php if (count($data) > 0): ?>
                      <div class="row">
                          <div class="col-md-4">DD/MM/AA</div>
                          <div class="col-md-4 text-center"><h4>Resumen de pasajeros en ruta</h4></div>
                          <div class="col-md-4"><?= $data[0]["institucion"] ?></div>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <h6><?= $data[0]["nombre_ruta"] ?></h6>
                          </div>
                          <div class="col-md-6 text-right">
                              <button type="button" class="btn btn-primary" id="print-list-ruta">
                                  <i class="fa fa-print"></i> Imprimir
                              </button>
                          </div>
                      </div>
                      <br>
                      <div class="row">
                          <div class="col-md-12">
                              <div class="table-responsive">
                                  <table class="table table-stripped">
                                      <thead>
                                      <th>No. Documento</th>
                                      <th>Nombre y Apellidos</th>
                                      <th>Dirección</th>
                                      <th>Jornada</th>
                                      <th>Zona</th>
                                      </thead>
                                      <tbody>
                                      <?php foreach ($data as $row): ?>
                                          <tr>
                                              <td><?= $row["identificacion"] ?></td>
                                              <td><?= $row["nombres"] ?></td>
                                              <td><?= $row["direccion"] ?></td>
                                              <td><?= $row["jornada"] ?></td>
                                              <td><?= $row["tipo_zona"] ?></td>
                                          </tr>
                                      <?php endforeach; ?>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  <?php else: ?>
                      <div class="row">
                          <div class="col-md-12 text-center">
                              <h3>No hay estudiantes asignados en esta ruta</h3>
                          </div>
                      </div>
                  <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('../../../hooks/footer.php');
?>
<script>
    $(document).ready(function () {
        $("#print-list-ruta").click(function (e) {
            $("#container-list").printArea({
                mode: "popup",
                popClose: true,
                popTitle: "Impresión lista estudiantes de ruta",
                popHt: 820,
                popWd: 1100,
                popX: 0,
                popY: 0

            })
        })
    })
</script>
