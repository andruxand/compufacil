<?php
require_once('../../../config/autoload.php');
require_once('./Utilities.php');

if (isset($_GET['router'])) {
  header('Content-Type: application/json');
  try {
    switch ($_GET['router']) {
      case "search-estudiantes":
        echo Utilities::getEstudiantes($db, $_POST);
        exit;
      case "get-estudiante":
        echo Utilities::getEstudiante($db, $_GET["id"]);
        exit;
      case "get-routes":
        echo Utilities::getRoutes($db, $_POST["zona"]);
        exit;
      case "asignar-ruta":
        echo Utilities::asignarRuta($db, $_POST);
        exit;
    }
  } catch (InvalidArgumentException $e) {
    header("Status: 403 Error");
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit;
  } catch (Exception $e) {
    header("Status: 403 Error");
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit;
  }
}

?>

<?php
include('../../../hooks/head.php')
?>

<div class="container-fluid">
    <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
    <div class="card border-dark-blue" id="container-search">
        <div class="card-header-dark-blue">
            Asignación transporte especial
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <form id="formSearch">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipoDocumento">Tipo de documento</label>
                                <select class="form-control" name="tipoDocumento" id="tipoDocumento">
                                    <option value="1">Cédula de ciudadanía</option>
                                    <option value="2">Nuip</option>
                                    <option value="3">Cédula extranjera</option>
                                    <option value="4">Tarjeta de identidad</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="documento">Documento</label>
                                <input type="text" name="documento" id="documento" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="primer-apellido">Primer Apellido</label>
                                <input type="text" name="primer-apellido" id="primer-apellido" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="segundo-apellido">Segundo Apellido</label>
                                <input type="text" name="segundo-apellido" id="segundo-apellido" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="primer-nombre">Primer Nombre</label>
                                <input type="text" name="primer-nombre" id="primer-nombre" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="segundo-nombre">Segundo Nombre</label>
                                <input type="text" name="segundo-nombre" id="segundo-nombre" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <i class="fa fa-refresh fa-spin fa-3x mr-4" id="loader-search-students"
                               style="display: none"></i>
                            <button type="submit" class="btn btn-dark-blue pull-right" id="btn-search">Consultar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fin Bloque -->

    <hr>

    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-success" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-error" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div id="container"></div>


    <div class="row" id="list-students">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="students" class="table table-bordered table-condensed">
                    <thead>
                    <th>Documento</th>
                    <th>Nombre y apellido</th>
                    <th>Jornada</th>
                    <th>Grado</th>
                    <th>Institución Educativa</th>
                    <th>Sede</th>
                    <th></th>
                    </thead>
                    <tbody id="tbody-table-students">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include('../../../hooks/footer.php')
?>

<script src="./js/app.js"></script>
