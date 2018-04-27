<?php
require_once('../../../../config/autoload.php');
require_once('../Utilities.php');

$idRoute = $_GET["id"];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/css/bootstrap.min.css"/>
</head>
<body onload="window.print()">
<?php
$dataRoute = json_decode(Utilities::getDataRoute($db, $idRoute));
?>
<div class="card" id="card-route">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <span id="nomRuta" class="mr-2"><b>Nombre de ruta:</b> <?= $dataRoute->nombre_ruta; ?></span>
                <span id="operador" class="mr-2"><b>Operador:</b> <?= $dataRoute->nombre_proveedor; ?></span>
                <span id="num-pasajeros-disp"
                      class="mr-2"><b>Cupos Disponibles:</b> <?= $dataRoute->num_pasajeros_disp; ?></span>
                <span id="num-pasajeros-asig" class="mr-2"><b>Cupos Asignados:</b> <?= $dataRoute->pasajeros; ?></span>
                <br><br>
                <span id="ieo" class="mr-2"><b>Institución educativa:</b> <?= $dataRoute->ieo; ?></span>
            </div>
        </div>
    </div>
</div>

<hr>

<?php
$dataVehiculo = json_decode(Utilities::getOneVehiculo($db, $idRoute));
$tipoBus = [
  ["id" => 1,
    "text" => "Bus"],
  ["id" => 2,
    "text" => "MiniBan"],
  ["id" => 3,
    "text" => "Buseta"]
];
$tipoZona = [
  ["id" => "Rural",
    "text" => "Rural"],
  ["id" => "Urbana",
    "text" => "Urbana"]
];
?>
<fieldset>
    <legend>
        Datos del vehículo
    </legend>
</fieldset>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Tipo de vehículo</label>
            <select name="tipoVehiculo" id="tipoVehiculo" class="form-control" disabled>
              <?php foreach ($tipoBus as $tb): ?>
                <?php if ($tb["id"] == $dataVehiculo->tipo_vehiculo): ?>
                      <option value="<?= $tb["id"] ?>" selected><?= $tb["text"] ?></option>
                <?php else: ?>
                      <option value="<?= $tb["id"] ?>"><?= $tb["text"] ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Placa Vehículo</label>
            <input type="text" class="form-control" name="placaVehiculo" id="placaVehiculo"
                   value="<?= $dataVehiculo->placa ?>" disabled/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Marca del Vehículo</label>
            <input type="text" class="form-control" name="marcaVehiculo" id="marcaVehiculo" disabled
                   value="<?= $dataVehiculo->marca_vehiculo ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Fecha Revisión Técnico Mecánica</label>
            <input type="text" class="form-control" name="fecharevitecnomec" id="fecharevitecnomec"
                   disabled value="<?= $dataVehiculo->fecha_tecnico ?>"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">No. Revisión Técnico Mecánica</label>
            <input type="number" class="form-control" name="numrevitecnomec" id="numrevitecnomec" disabled
                   value="<?= $dataVehiculo->tecnico_mecanica ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Fecha Vencimiento SOAT</label>
            <input type="text" class="form-control" name="fechavencisoat" id="fechavencisoat" disabled
                   value="<?= $dataVehiculo->fecha_soat ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">No. SOAT</label>
            <input type="text" class="form-control" name="numsoat" id="numsoat" disabled
                   value="<?= $dataVehiculo->soat ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Asignaciones disponibles</label>
            <input type="number" class="form-control" name="numpasajeros" id="numpasajeros" disabled
                   value="<?= $dataVehiculo->num_pasajeros; ?>"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Propietario del Vehículo</label>
            <input type="text" class="form-control" name="propietarioVehiculo" id="propietarioVehiculo"
                   disabled value="<?= $dataVehiculo->propietario; ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">No. Tarjeta de Operación</label>
            <input type="text" class="form-control" name="numtarjetaope" id="numtarjetaope" disabled
                   value="<?= $dataVehiculo->tarjeta_operacion ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Seguro Contractual</label>
            <input type="text" class="form-control" name="seguroContractual" id="seguroContractual"
                   disabled value="<?= $dataVehiculo->seguro_contractual ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Seguro Extra Contractual</label>
            <input type="text" class="form-control" name="seguroExtraContractual"
                   id="seguroExtraContractual" disabled value="<?= $dataVehiculo->seguro_extracontractual; ?>"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Tipo de Zona</label>
            <select class="form-control" name="tipoZona" id="tipoZona" disabled>
              <?php foreach ($tipoZona as $tz): ?>
                <?php if ($tz["id"] == $dataVehiculo->tipo_zona): ?>
                      <option value="<?= $tz["id"] ?>" selected><?= $tz["text"] ?></option>
                <?php else: ?>
                      <option value="<?= $tz["id"] ?>"><?= $tz["text"] ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">No. De Contrato</label>
            <input type="text" class="form-control" name="numcontrato" id="numcontrato" disabled
                   value="<?= $dataVehiculo->numero_contrato; ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <label for="proveedorCond">Proveedor</label>
      <?php
      $dataProveedor = json_decode(Utilities::getOneProveedor($db, $idRoute));
      ?>
        <input type="text" class="form-control" disabled value="<?= $dataProveedor->nombre_proveedor ?>">
    </div>
</div>

<br>

<?php
$dataCond = json_decode(Utilities::getOneConductor($db, $idRoute));
$tipoDoc = [
  ["id" => 1,
    "text" => "Cédula de ciudadanía"],
  ["id" => 2,
    "text" => "Nuip"],
  ["id" => 3,
    "text" => "Cédula extranjera"],
  ["id" => 4,
    "text" => "Tarjeta de identidad"]
];
?>

<fieldset>
    <legend>
        Datos del conductor
    </legend>
</fieldset>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Tipo de Documento</label>
            <select class="form-control" name="tipoDocumentoCond" id="tipoDocumentoCond" disabled>
              <?php foreach ($tipoDoc as $td): ?>
                <?php if ($td["id"] == $dataCond->tipodoc_id): ?>
                      <option value="<?= $td["id"] ?>" selected><?= $td["text"] ?></option>
                <?php else: ?>
                      <option value="<?= $td["id"] ?>"><?= $td["text"] ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Documento</label>
            <input type="number" class="form-control" name="documentCond" id="documentCond" disabled
                   value="<?= $dataCond->documento ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Primer Apellido</label>
            <input type="text" class="form-control" name="primerApellidoCond" id="primerApellidoCond"
                   disabled value="<?= $dataCond->primerapellido ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Segundo Apellido</label>
            <input type="text" class="form-control" name="segundoApellidoCond" id="segundoApellidoCond" disabled
                   value="<?= $dataCond->segundoapellido ?>"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Primer Nombre</label>
            <input type="text" class="form-control" name="primerNombreCond" id="primerNombreCond" disabled
                   value="<?= $dataCond->primernombre ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Segundo Nombre</label>
            <input type="text" class="form-control" name="segundoNombreCond" id="segundoNombreCond" disabled
                   value="<?= $dataCond->segundonombre ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Dirección de Residencia</label>
            <input type="text" class="form-control" name="direccionResidenciaCond" id="direccionResidenciaCond" disabled
                   value="<?= $dataCond->direccion ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">No. de Celular</label>
            <input type="text" class="form-control" name="numCelularCond" id="numCelularCond" disabled
                   value="<?= $dataCond->celular ?>"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Licencia de conducción No.</label>
            <input type="text" class="form-control" name="licenciaConduccion" id="licenciaConduccion" disabled
                   value="<?= $dataCond->licencia ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Categoría Autorizada</label>
            <input type="text" class="form-control" name="categoriaAutorizada" id="categoriaAutorizada" disabled
                   value="<?= $dataCond->categoria ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Fecha Vencimiento Licencia</label>
            <input type="text" class="form-control" name="fechavencilince" id="fechavencilince" disabled
                   value="<?= $dataCond->fecha_vencimiento ?>"/>
        </div>
    </div>
</div>

<br>

<?php
$dataAux = json_decode(Utilities::getOneAuxiliar($db, $idRoute));

?>

<fieldset>
    <legend>
        Datos del Auxiliar
    </legend>
</fieldset>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Tipo de Documento</label>
            <select class="form-control" name="tipoDocumentoAux" id="tipoDocumentoAux" disabled>
              <?php foreach ($tipoDoc as $td): ?>
                <?php if ($td["id"] == $dataAux->tipodoc_id): ?>
                      <option value="<?= $td["id"] ?>" selected><?= $td["text"] ?></option>
                <?php else: ?>
                      <option value="<?= $td["id"] ?>"><?= $td["text"] ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Documento</label>
            <input type="number" class="form-control" name="documentoAux" id="documentoAux" disabled
                   value="<?= $dataAux->documento; ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Primer Apellido</label>
            <input type="text" class="form-control" name="primerApellidoAux" id="primerApellidoAux" disabled
                   value="<?= $dataAux->primerapellido; ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Segundo Apellido</label>
            <input type="text" class="form-control" name="segundoApellidoAux" id="segundoApellidoAux" disabled
                   value="<?= $dataAux->segundoapellido; ?>"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Primer Nombre</label>
            <input type="text" class="form-control" name="primerNombreAux" id="primerNombreAux" disabled
                   value="<?= $dataAux->primernombre; ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Segundo Nombre</label>
            <input type="text" class="form-control" name="segundoNombreAux" id="segundoNombreAux" disabled
                   value="<?= $dataAux->segundoapellido; ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Dirección de Residencia</label>
            <input type="text" class="form-control" name="direccionResidenciaAux" id="direccionResidenciaAux" disabled
                   value="<?= $dataAux->direccion; ?>"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">No. de Celular</label>
            <input type="text" class="form-control" name="numCelularAux" id="numCelularAux" disabled
                   value="<?= $dataAux->celular; ?>"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Formación Académica</label>
            <input type="text" class="form-control" name="formacionAcadeAux" id="formacionAcadeAux" disabled
                   value="<?= $dataAux->formacion ?>"/>
        </div>
    </div>
</div>

<br>

<?php
$paradas = json_decode(Utilities::consultaRecorridos($db, $idRoute));
?>
<fieldset>
    <legend>
        Recorrido (paradas)
    </legend>
</fieldset>
<div class="row">
    <div class="col-md-12">
      <?php if (count($paradas) > 0): ?>
          <table class="table table-bordered table-striped">
              <thead>
              <tr>
                  <th>Secuencia</th>
                  <th>Punto</th>
                  <th>Dirección</th>
                  <th>Horario</th>
              </tr>
              </thead>
              <tbody id="bodyTableRecorrido">
              <?php foreach ($paradas as $parada): ?>
                  <tr>
                      <td><?= $parada->secuencia; ?></td>
                      <td><?= $parada->nombre_parada; ?></td>
                      <td><?= $parada->direccion; ?></td>
                      <td><?= $parada->hora_llegada . " - " . $parada->hora_partida ?></td>
                  </tr>
              <?php endforeach; ?>
              </tbody>
          </table>
      <?php endif ?>
    </div>
</div>


</body>
</html>