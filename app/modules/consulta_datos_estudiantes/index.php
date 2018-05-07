<?php

    require_once "../../config/autoload.php";
    include('../../hooks/head.php');

?>
<div class="invisible" id="title-export">Consulta Datos de Estudiantes</div>
<script src="js/script.js" type="text/javascript"></script>

    <div class="container-fluid" id="alimentario">
        <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                CONSULTAR DATOS DE ESTUDIANTES
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="form-row">

                        <div class="col-md-12">
                            <div class="col-md-6" style="float: left;">
                                <div class="form-group">
                                    <label class="mb-2 mr-sm-2" for="institucion"><strong>Código DANE , Institución Educativa y/o Sede</strong></label>
                                    <select class="form-control-custom" id="institucion" name="institucion">
                                        <option value="">Seleccionar Sede</option>
                                    </select>
                                </div>  
                            </div> 
                            <div class="col-md-4" style="float: left;">
                                <div class="form-group">
                                    <label class="mb-2 mr-sm-2" for="institucion"><strong>Grado</strong></label>
                                    <select class="form-control-custom" id="grado" name="grado">
                                        <option value="">Seleccionar Grado</option>
                                        <option value = "PRE-JARDIN"      >PRE-JARDIN          </option>
                                         <option value = "JRD I/KIND"      >JRD I/KIND          </option>
                                         <option value = "GRADO 0"         >GRADO 0             </option>
                                         <option value = "PRIMERO"         >PRIMERO             </option>
                                         <option value = "SEGUNDO"         >SEGUNDO             </option>
                                         <option value = "TERCERO"         >TERCERO             </option>
                                         <option value = "CUARTO"          >CUARTO              </option>
                                         <option value = "QUINTO"          >QUINTO              </option>
                                         <option value = "SEXTO"           >SEXTO               </option>
                                         <option value = "SEPTIMO"         >SEPTIMO             </option>
                                         <option value = "OCTAVO"          >OCTAVO              </option>
                                         <option value = "NOVENO"          >NOVENO              </option>
                                         <option value = "DECIMO"          >DECIMO              </option>
                                         <option value = "ONCE"            >ONCE                </option>
                                         <option value = "DOCE NRML SUP"   >DOCE NRML SUP       </option>
                                         <option value = "TRECE NRML SUP"  >TRECE NRML SUP      </option>
                                         <option value = "CICLO 1 ADULTOS" >CICLO 1 ADULTOS     </option>
                                         <option value = "CICLO 2 ADULTOS" >CICLO 2 ADULTOS     </option>
                                         <option value = "CICLO 3 ADULTOS" >CICLO 3 ADULTOS     </option>
                                         <option value = "CICLO 4 ADULTOS" >CICLO 4 ADULTOS     </option>
                                         <option value = "CICLO 5 ADULTOS" >CICLO 5 ADULTOS     </option>
                                         <option value = "CICLO 6 ADULTOS" >CICLO 6 ADULTOS     </option>
                                         <option value = "ACELERACION DEL APRENDIZAJE" >ACELERACION DEL APRENDIZAJE</option>
                                    </select>
                                </div>  
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-4" style="float: left;">
                                <div class="form-group">
                                    <label class="mb-2 mr-sm-2" for="grupo"><strong>Grupo</strong></label>
                                    <input type="text" class="form-control-custom" placeholder="Grupo" id="grupo" name="grupo">
                                </div>
                            </div>

                            <div class="col-md-4" style="float: left;">
                                <div class="form-group">
                                    <label class="mb-2 mr-sm-2" for="grupo"><strong>Vigencia</strong></label>
                                    <select id="vigencia" class="form-control-custom" name="vigencia">
                                          <option value=""       >Seleccionar Vigencia </option>
                                          <option value="2016"   >2016</option>
                                          <option value="2017"   >2017</option>
                                          <option value="2018"   >2018</option>
                                          <option value="2019"   >2019</option>
                                          <option value="2020"   >2020</option>
                                          <option value="2021"   >2021</option>
                                          <option value="2022"   >2022</option>
                                          <option value="2023"   >2023</option>
                                          <option value="2024"   >2024</option>
                                          <option value="2025"   >2025</option>
                                    </select>
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
                                        <th class="text-center" scope="col">Tipo Documento</th>
                                        <th class="text-center" scope="col">No. Documento</th>
                                        <th class="text-center" scope="col">Apellido1</th>
                                        <th class="text-center" scope="col">Apellido2</th>
                                        <th class="text-center" scope="col">Nombre1</th>
                                        <th class="text-center" scope="col">Nombre2</th>
                                        <th class="text-center" scope="col">Grado</th>
                                        <th class="text-center" scope="col">Grupo</th>
                                        <th class="text-center" scope="col">Institucion Educativa</th>
                                        <th class="text-center" scope="col">Sede</th>
                                        <th class="text-center" scope="col">Jornada</th>
                                        <th class="text-center" scope="col">Año Lectivo</th>
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