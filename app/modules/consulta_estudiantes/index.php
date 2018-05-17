<?php

    require_once "../../config/autoload.php";
    include('../../hooks/head.php');

?>
<div class="invisible" id="title-export">Consulta de Estudiantes Matriculados</div>
    <div class="container-fluid" id="alimentario">
        <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                CONSULTAR ESTUDIANTES MATRICULADOS
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <form id="formSearchStudents">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-3">
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
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <div class="form-group">
                                    <label for="documento">Documento</label>
                                    <input type="text" name="documento" id="documento" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <div class="form-group">
                                    <label for="primer-apellido">Primer Apellido</label>
                                    <input type="text" name="primer-apellido" id="primer-apellido" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <div class="form-group">
                                    <label for="segundo-apellido">Segundo Apellido</label>
                                    <input type="text" name="segundo-apellido" id="segundo-apellido" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <div class="form-group">
                                    <label for="primer-nombre">Primer Nombre</label>
                                    <input type="text" name="primer-nombre" id="primer-nombre" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <div class="form-group">
                                    <label for="segundo-nombre">Segundo Nombre</label>
                                    <input type="text" name="segundo-nombre" id="segundo-nombre" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <div class="form-group">
                                    <label class="mb-2 mr-sm-2" for="grupo">Año lectivo</label>
                                    <select id="vigencia" class="form-control" name="vigencia">
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
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <button type="submit" name="reset" id="reset" class="btn btn-dark-blue mt-4">
                                    <span class="oi oi-loop-circular text-blue" title="icon name" aria-hidden="true"></span>
                                    Reiniciar
                                </button>

                                <button type="submit" name="buscar" id="buscar" class="btn btn-dark-blue mt-4">
                                    <span class="oi oi-magnifying-glass text-blue" title="icon name" aria-hidden="true"></span>
                                    Buscar
                                </button>
                            </div>
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
                                    Por favor utilice los filtros superiores para una búsqueda especifica y el filtro inferior para una búsqueda global de los datos.
                                </div> 

                            <div id="show_errors"></div>

                            <div class="table-responsive">
                                <table id="results" class="table table-hover table-sm">
                                    <thead>
                                        <th class="text-center" scope="col">No. Documento</th>
                                        <th class="text-center" scope="col">Nombre</th>
                                        <th class="text-center" scope="col">Grado</th>
                                        <th class="text-center" scope="col">Jornada</th>
                                        <th class="text-center" scope="col">Institucion Educativa</th>
                                        <th class="text-center" scope="col">Sede</th>
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

<div class="modal fade bd-modal-lg" tabindex="-1" data-backdrop='static' id="load-modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-extra-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span class="oi oi-browser icon-window" title="icon name" aria-hidden="true"></span>
                <h4 class="modal-title" id="myLargeModalLabel">
                    Detalle estudiante
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><font style="vertical-align: inherit;">×</font></span>
                </button>
            </div>
            <div id="modal-body" class="modal-body">

            </div>
        </div>
    </div>
</div>

<?php
include('../../hooks/footer.php');
?>
<script src="js/script.js" type="text/javascript"></script>
