<?php
require_once('../../../config/autoload.php');
require_once('./Utilities.php');
if (isset($_GET['router'])) {
  header('Content-Type: application/json');
  try {
    switch ($_GET['router']) {
      case 'search-route':
        echo Utilities::consultarRutas($db, $_GET['search']);
        exit;
      case 'search-routes':

        exit;
      case 'get-recorridos':
        echo Utilities::consultaRecorridos($db, $_GET['id']);
        exit;
      case 'get-recorrido':
        echo Utilities::consultaRecorrido($db, $_GET['id']);
        exit;
      case 'guardar-recorrido':
        if (!empty($_POST['id_parada'])) echo Utilities::updateParada($db, $_POST);
        else echo Utilities::saveParada($db, $_POST);
        exit;
      case 'delete-parada':
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
          echo Utilities::deleteParada($db, $_REQUEST['id']);
        else echo json_encode(["message" => "No tiene permiso para esta acción"]);
        exit;
      case "get-proveedores":
        echo Utilities::getProveedores($db);
        exit;
      case "get-ieo":
        echo Utilities::getIeo($db, $_GET["search"]);
        exit;
      case "get-vehiculos":
        echo Utilities::getVehiculos($db);
        exit;
      case "get-conductores":
        echo Utilities::getConductores($db);
        exit;
      case "get-auxiliares":
        echo Utilities::getAuxiliares($db);
        exit;
      case "create-ruta":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') echo Utilities::createRuta($db, $_POST);
        else echo json_encode(["message" => "No tiene permiso para esta acción"]);
        exit;
      case "get-vehiculo":
        echo Utilities::getOneVehiculo($db, $_GET["id"]);
        exit;
      case "get-conductor":
        echo Utilities::getOneConductor($db, $_GET["id"]);
        exit;
      case "get-auxiliar":
        echo Utilities::getOneAuxiliar($db, $_GET["id"]);
        exit;
      case "update-vehiculo":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') echo Utilities::updateVehiculo($db, $_POST);
        else throw new InvalidArgumentException("No tiene permiso para esta acción");
        exit;
      case "update-conductor":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') echo Utilities::updateConductor($db, $_POST);
        else throw new InvalidArgumentException("No tiene permiso para esta acción");
        exit;
      case "update-auxiliar":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') echo Utilities::updateAuxiliar($db, $_POST);
        else throw new InvalidArgumentException("No tiene permiso para esta acción");
        exit;
      case "get-data-route":
        echo Utilities::getDataRoute($db, $_GET["id"]);
        exit;
      case "create-vehiculo":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') echo Utilities::createVehiculo($db, $_POST);
        else throw new InvalidArgumentException("No tiene permiso para esta acción");
        exit;
      case "create-conductor":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') echo Utilities::createConductor($db, $_POST);
        else throw new InvalidArgumentException("No tiene permiso para esta acción");
        exit;
      case "create-auxiliar":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') echo Utilities::createAuxiliar($db, $_POST);
        else throw new InvalidArgumentException("No tiene permiso para esta acción");
        exit;
      case "load-conductores":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') echo Utilities::loadConductor($db, $_FILES);
        else throw new InvalidArgumentException("No tiene permiso para esta acción");
        exit;
    }
  } catch (InvalidArgumentException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit;
  } catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit;
  }
}
?>

<?php
include('../../../hooks/head.php')
?>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"/>

<style>
    #alert-success, #alert-error {
        display: none;
    }
</style>

<div class="container-fluid">
    <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
    <div class="card border-dark-blue" id="container-search">
        <div class="card-header-dark-blue">
            Consulta transporte especial
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <form action="index.php" method="post" class="form-inline">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="my-1 mr-2" for="searchRoute">Nombre de Ruta</label>
                                <select class="form-control mb-2 mr-sm-2" style="width: 30%" name="search"
                                        id="searchRoute"></select>
                            </div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-dark-blue ml-3 mt-3" id="btn-search">Buscar</button>
                    <button type="button" class="btn btn-dark-blue ml-3 mt-3" id="btn-create-ruta">Crear Ruta</button>
                    <div class="dropdown ml-3 mt-3">
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Carga masiva
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#" id="btn-load-vehiculos">Carga masiva vehiculos</a>
                            <a class="dropdown-item" href="#" id="btn-load-conductores">Carga masiva conductores</a>
                            <a class="dropdown-item" href="#" id="btn-load-auxiliares">Carga masiva auxiliar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fin Bloque -->

    <hr/>


    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-error">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div id="container"></div>

</div>


<div class="modal fade bd-modal-lg" tabindex="-1" id="load-modal" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span class="oi oi-browser icon-window" title="icon name" aria-hidden="true"></span>
                <h4 class="modal-title" id="myLargeModalLabel">
                    Parada
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formRecorrido">
                    <input type="hidden" name="id_parada" id="id_parada"/>
                    <input type="hidden" name="id_ruta" id="id_ruta"/>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nom_parada">Nombre de parada</label>
                                <input type="text" name="nom_parada" id="nom_parada" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="secuencia">Secuencia</label>
                                <input type="number" name="secuencia" id="secuencia" class="form-control" required/>
                                <span class="form-text text-muted">
                                    Orden de la parada
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hora_llegada">Hora de llegada</label>
                                <input type="text" name="hora_llegada" id="hora_llegada" class="form-control" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hora_partida">Hora de partida</label>
                                <input type="text" name="hora_partida" id="hora_partida" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group text-right mt-3">
                                <button type="submit" id="btn-save-parada" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
include('../../../hooks/footer.php')
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>

<script src="./js/app.js"></script>
<script>
    $('#myTab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>