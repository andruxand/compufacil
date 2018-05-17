<?php

    require_once "../../config/autoload.php";
    include('../../hooks/head.php');

?>
<div class="invisible" id="title-export">Consulta de Sedes de Instituciones</div>
<script src="js/script.js" type="text/javascript"></script>

    <div class="container-fluid" id="alimentario">
        <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                CONSULTAR SEDES DE INSTITUCIONES
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="form-row">

                        <div class="col-md-12">
                            <div class="col-md-6" style="float: left;">
                                <div class="form-group">
                                    <label class="mb-2 mr-sm-2" for="institucion"><strong>Código DANE y/o Sede</strong></label>
                                    <select class="form-control-custom" id="institucion" name="institucion">
                                        <option value="">Seleccionar Sede</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="col-md-4" style="float: left;">
                              <div class="form-group">
                                  <label class="mb-2 mr-sm-2" for="proveedor"><strong>Zonas</strong></label>
                                  <select class="form-control-custom" id="zona" name="zona">
                                      <option value="">Sin Asignar</option>
                                      <?php 
                                          $sql = " SELECT id, descripcion
                                                  FROM mat_zonas c ";
                                          $resultado = $db->sql_exec($sql);
                                          while($row = mysqli_fetch_object($resultado)){
                                              $selected = "";
                                              if( isset($_POST['id']) ){
                                                  if( $_POST['id'] ==  $row->proveedor){
                                                      $selected = 'selected="selected"';
                                                  }
                                              }
                                      ?>
                                          <option value="<?= $row->id; ?>" <?= $selected; ?> ><?= $row->descripcion; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                            </div> 
                        </div> 
                            
                        </div>

                        <div class="col-md-12 text-right">

                            <button type="submit" name="reset" id="reset" class="btn btn-dark-blue mb-2">
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
                                        <th class="text-center" scope="col">Código DANE</th>
                                        <th class="text-center" scope="col">Nombre Sede</th>
                                        <th class="text-center" scope="col">Dirección</th>
                                        <th class="text-center" scope="col">Zona</th>
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

    <div class="modal fade bd-modal-lg" tabindex="-1" id="load-modal-zonas" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="oi oi-browser icon-window" title="icon name" aria-hidden="true"></span>
                    <h4 class="modal-title" id="myLargeModalLabel">
                        <font style="vertical-align: inherit;">
                            Asignar Zona
                        </font>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><font style="vertical-align: inherit;">×</font></span>
                    </button>
                </div>
                <div class="modal-body">

                  <div style="display: none;" id="alert-success" class="alert alert-success alert-dismissible fade show animated bounceInDown" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                      <span class="oi oi-check" title="icon name" aria-hidden="true"></span>
                          Zona asignada satisfactoriamente
                  </div>

                  <div style="display: none;" id="alert-danger" class="alert alert-danger alert-dismissible fade show animated bounceInDown" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                      <span class="oi oi-x" title="icon name" aria-hidden="true"></span>
                          Problemas al asignar zona
                  </div>

                  <div class="card border-dark-blue">
                    <div class="card-header-dark-blue">
                        ASIGNAR ZONA A SEDE DE INSTITUCIÓN
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-row">

                                <div class="col-md-12">
                                    <div class="col-md-4" style="float: left;">
                                        <div class="form-group">
                                            <label class="mb-2 mr-sm-2" for="info-coddane"><strong>Código DANE</strong></label>
                                            <input type="text" class="form-control-custom" style="background: #eee;" id="info-coddane" name="info-coddane" disabled>
                                        </div>  
                                    </div>
                                    <div class="col-md-12" style="float: left;">
                                      <div class="form-group">
                                          <label class="mb-2 mr-sm-2" for="info-ieo"><strong>Nombre Sede</strong></label>
                                          <input type="text" class="form-control-custom" style="background: #eee;" id="info-ieo" name="info-ieo" disabled>
                                      </div>
                                    </div> 
                                    <div class="col-md-6" style="float: left;">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2" for="info-zona"><strong>Zonas</strong></label>
                                        <select class="form-control-custom" id="info-zona" name="info-zona">
                                            <option value="">Sin Asignar</option>
                                            <?php 
                                                $sql = " SELECT id, descripcion
                                                        FROM mat_zonas c ";
                                                $resultado = $db->sql_exec($sql);
                                                while($row = mysqli_fetch_object($resultado)){
                                            ?>
                                                <option value="<?= $row->id; ?>"><?= $row->descripcion; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                  </div> 
                                </div> 
                                    
                                </div>

                                <div class="col-md-12 text-right">

                                    <button type="button" class="btn btn-dark-blue mb-2" data-dismiss="modal" aria-label="Close">
                                        <span class="oi oi-account-logout text-blue" title="icon name" aria-hidden="true"></span>
                                        Salir
                                    </button>

                                    <button type="button" name="guardar-zona" id="guardar-zona" class="btn btn-dark-blue mb-2">
                                        <span class="oi oi-check text-blue" title="icon name" aria-hidden="true"></span>
                                        Guardar
                                    </button>
                                </div>        

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin Bloque -->
                 
                </div>
            </div>
        </div> 
    </div>

<?php
include('../../hooks/footer.php');
?>