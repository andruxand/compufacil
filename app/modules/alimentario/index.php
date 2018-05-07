<?php

    require_once "../../config/autoload.php";
    include('../../hooks/head.php');

    if(in_array(8, $current_roles)){
        echo "Usted tiene permisos para rol 1";
    }else{
        echo "No tiene permisos para el rol 1";
    }
    //echo $current_roles[0] . " - " . $current_roles[1];

?>
<div class="invisible" id="title-export">Lista de Instituciones Con Contratos</div>
<script src="js/script.js" type="text/javascript"></script>

    <div class="container-fluid" id="alimentario">
        <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                CONSULTAR ALIMENTACIÓN
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="form-row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="institucion"><strong>Código DANE , Institución Educativa y/o Sede</strong></label>
                                <select class="form-control-custom" id="institucion" name="institucion">
                                    <option value="">TODOS</option>
                                    <?php 
                                        $sql = "SELECT sc.coddane DANE, CONCAT(sc.coddane, ' - ', CONCAT(i.descripcion, ' / ', sc.descripcion) ) NOMBRE
                                                FROM mat_instituciones i, ali_contrato c, mat_sedes sc
                                                WHERE
                                                sc.id_instituciones = i.id
                                                AND c.sede_id = sc.id 
                                                AND c.user_id = ".$current_userID."
                                                ORDER BY NOMBRE ASC";
                                        $resultado = $db->sql_exec($sql);
                                        while($row = mysqli_fetch_object($resultado)){
                                            $selected = "";
                                            if( isset($_POST['institucion']) ){
                                                if( $_POST['institucion'] ==  $row->NOMBRE){
                                                    $selected = 'selected="selected"';
                                                }
                                            }
                                    ?>
                                        <option value="<?= $row->DANE; ?>" <?= $selected; ?> ><?= $row->NOMBRE; ?></option>
                                    <?php } ?>
                                </select>
                            </div>  
                        </div> 

                        <div class="col-md-12 text-right">

                            <button type="submit" name="reset" id="reset" class="btn btn-dark-blue mb-2 ajax-loader">
                                <span class="oi oi-loop-circular text-blue" title="icon name" aria-hidden="true"></span>
                                Reiniciar
                            </button>

                            <button type="submit" name="buscar" id="buscar" class="btn btn-dark-blue mb-2">
                                <span class="oi oi-magnifying-glass text-blue" title="icon name" aria-hidden="true"></span>
                                Buscar
                            </button>
                        </div>        

                    </div>
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
                                    Por favor utilice los filtros superiores para una búsqueda especifica y el filtro inferior para una búsqueda global de los datos.
                                </div> 

                            <div id="show_errors"></div>

                            <div class="table-responsive">
                                <table id="results" class="table table-hover table-sm">
                                    <thead>
                                        <th class="text-center" scope="col">DANE</th>
                                        <th class="text-center" scope="col">Operador</th>
                                        <th class="text-center" scope="col">InstituciónEducativa/Sede</th>
                                        <th class="text-center" scope="col">Dirección</th>
                                        <th class="text-center" scope="col">Comuna</th>
                                        <!--<th class="text-center" scope="col">Tipo de Zona</th>-->
                                        <th class="text-center" scope="col">Sector</th>
                                        <!--<th class="text-center" scope="col">Zona</th>-->
                                        <th class="text-center" scope="col">Modalidad</th>
                                        <th class="text-center" scope="col">Formación</th>
                                        <th class="text-center" scope="col">Acciones</th>
                                    </thead>
                                    <tbody>
                                        
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

    </div>  

    <div class="modal fade bd-modal-lg" tabindex="-1" id="load-modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-extra-lg">
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