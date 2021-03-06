<?php

    require_once "../../../config/autoload.php";
    include('../../../hooks/head.php');

?>
<div class="invisible" id="title-export">Consulta Registro De Operadores</div>
<script src="js/consulta_registro_proveedores.js" type="text/javascript"></script>

    <div class="container-fluid" id="alimentario">
        <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                CONSULTA REGISTRO DE OPERADORES
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="form-row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="proveedor"><strong>Operador y/o NIT</strong></label>
                                <select class="form-control-custom" id="proveedor" name="proveedor">
                                    <option value="">TODOS</option>
                                    <?php 
                                        $sql = "SELECT p.nit, CONCAT(p.nit, ' / ', p.nombre_proveedor) proveedor
                                                FROM ali_contrato c, ali_proveedor p
                                                WHERE
                                                c.proveedor_id = p.id
                                                GROUP BY  p.nit ASC";
                                        $resultado = $db->sql_exec($sql);
                                        while($row = mysqli_fetch_object($resultado)){
                                            $selected = "";
                                            if( isset($_POST['proveedor']) ){
                                                if( $_POST['proveedor'] ==  $row->proveedor){
                                                    $selected = 'selected="selected"';
                                                }
                                            }
                                    ?>
                                        <option value="<?= $row->nit; ?>" <?= $selected; ?> ><?= $row->proveedor; ?></option>
                                    <?php } ?>
                                </select>
                            </div>  
                        </div> 

                        <div class="col-md-12 text-right">

                            <button type="submit" name="reset" id="reset" class="btn btn-dark-blue mb-2 ajax-loader">
                                <span class="oi oi-loop-circular text-blue" title="icon name" aria-hidden="true"></span>
                                Reiniciar
                            </button>

                            <button type="submit" name="buscar" id="buscar" class="btn btn-dark-blue mb-2 ajax-loader">
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
                                <table id="results" class="table table-hover table-sm display" style="width:100%">
                                    <thead>
                                        <th class="text-center" scope="col">Nombre Operador</th>
                                        <th class="text-center" scope="col">NIT</th>
                                        <th class="text-center" scope="col">Número Contrato</th>
                                        <th class="text-center" scope="col">Tipo Ración</th>
                                        <th class="text-center" scope="col">Jornada Única</th>
                                        <th class="text-center" scope="col">Complemento Alimentario</th>
                                        <th class="text-center" scope="col">Total Raciones</th>
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

    </div>  

<?php
include('../../../hooks/footer.php');
?>