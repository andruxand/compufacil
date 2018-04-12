<?php
    include('../../hooks/head.php');

    if(isset($_POST['buscar'])){

        $sql = " SELECT coddane DANE, descripcion NOMBRE FROM mat_instituciones WHERE 1=1 ";

        if(!empty($_POST['dane'])){
            $sql .= sprintf(" AND coddane = '%s' ", $_POST['dane']);
        }

        if(!empty($_POST['institucion'])){
            $sql .= sprintf(" AND coddane = '%s'", $_POST['institucion']);
        }

        $resultado = $db->sql_exec($sql);

        if($resultado){
            $num_rows = mysqli_num_rows($resultado); 

            if($num_rows > 0){
                echo "numeros " . $num_rows;
            }
        }

    }

?>
<script src="js/script.js" type="text/javascript"></script>

    <div class="container-fluid" id="alimentario">
        <?php
            if(!empty($db->db_error)){
                echo $db->show_db_error();
            }
        ?>

        <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                CONSULTAR ALIMENTACIÓN
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <form method="POST" class="form-row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="ruta"><strong>Código DANE</strong></label>
                                <input type="search" class="form-control-custom" id="dane" placeholder="Código DANE" 
                                       name="dane"/>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="institucion"><strong>Institución Educativa y/o Sede</strong></label>
                                <select class="form-control-custom" id="institucion" name="institucion">
                                    <option value="">TODOS</option>
                                    <?php 
                                        $sql = "SELECT coddane DANE, descripcion NOMBRE FROM mat_instituciones ORDER BY NOMBRE ASC";
                                        $resultado = $db->sql_exec($sql);
                                        while($row = mysqli_fetch_object($resultado)){
                                    ?>
                                        <option value="<?= $row->DANE; ?>"><?= $row->NOMBRE; ?></option>
                                    <?php } ?>
                                </select>
                            </div>  
                        </div> 

                        <div class="col-md-12 text-right">
                            <button type="submit" name="buscar" id="buscar" class="btn btn-dark-blue mb-2">
                                <span class="oi oi-magnifying-glass text-blue" title="icon name" aria-hidden="true"></span>
                                Buscar
                            </button>
                        </div>        

                    </form>
                </div>
            </div>
        </div>
        <!-- Fin Bloque -->

        <hr/>

        <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
        <div class="card border-dark-blue">
            <div class="card-body">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="tabResultados" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="resultados-tab" data-toggle="tab" href="#resultados" role="tab" aria-controls="resultados" aria-selected="true">RESULTADOS</a>
                      </li>
                    </ul>
                    <div class="tab-content resultados" id="myTabContent">
                        <div class="tab-pane fade show active" id="resultados" role="tabpanel" aria-labelledby="resultados-tab">
                            <div class="alert alert-info alert-dismissible fade show animated bounceInDown" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <span class="oi oi-info" title="icon name" aria-hidden="true"></span>
                                Esta es una alerta de inforación!
                            </div>
                            <div class="alert alert-warning alert-dismissible fade show animated bounceInDown" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <span class="oi oi-warning" title="icon name" aria-hidden="true"></span>
                                    Esta es una alerta de Advertencia!
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <th class="text-center" scope="col">No. contrato</th>
                                        <th class="text-center" scope="col">No. Pasajeros</th>
                                        <th class="text-center" scope="col">Jornada</th>
                                        <th class="text-center" scope="col">Nombre de operador</th>
                                        <th class="text-center" scope="col">Institución educativa</th>
                                        <th class="text-center" scope="col">Acciones</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><font style="vertical-align: inherit;">Celda</font></td>
                                            <td class="text-center"><font style="vertical-align: inherit;">Celda</font></td>
                                            <td class="text-center"><font style="vertical-align: inherit;">Celda</font></td>
                                            <td class="text-center"><font style="vertical-align: inherit;">Celda</font></td>
                                            <td class="text-center"><font style="vertical-align: inherit;">Celda</font></td>
                                            <td class="text-center">
                                                <a class="btn btn-outline-primary" data-url="prueba" data-title="Consultar Raciones" 
                                                    data-toggle="modal" data-target="#load-modal" data-backdrop="static" href="#">
                                                    <span class="oi oi-magnifying-glass text-blue" title="icon name" aria-hidden="true"></span>
                                                </a>
                                                <a class="btn btn-outline-primary" data-url="consultar_raciones.php" data-title="Registrar Raciones" 
                                                   data-toggle="modal" data-target="#load-modal" data-backdrop="static" href="#">
                                                    <span class="oi oi-plus text-blue" title="icon name" aria-hidden="true"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Bloque -->

        <hr>

        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-dark-blue mb-2">
                <span class="oi oi-plus text-blue" title="icon name" aria-hidden="true"></span>
                Registrar Raciones
            </button>
            <button type="submit" class="btn btn-dark-blue mb-2">
                <span class="oi oi-magnifying-glass text-blue" title="icon name" aria-hidden="true"></span>
                Consultar
            </button>
            <button type="submit" class="btn btn-dark-blue mb-2">
                <span class="oi oi-account-logout text-blue" title="icon name" aria-hidden="true"></span>
                Salir
            </button>
        </div>

    </div>  

    <div class="modal fade bd-modal-lg" tabindex="-1" id="load-modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="oi oi-browser icon-window" title="icon name" aria-hidden="true"></span>
                    <h4 class="modal-title" id="myLargeModalLabel">
                        <font style="vertical-align: inherit;">
                            Modal grande
                        </font>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><font style="vertical-align: inherit;">×</font></span>
                    </button>
                </div>
                <div class="modal-body">
                 
                </div>
            </div>
        </div> 
    </div>

<?php
include('../../hooks/footer.php');
?>