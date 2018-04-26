<?php

    require_once "../../config/autoload.php";
    include('../../hooks/head.php');

?>

    <script src="js/consulta_entrega_raciones.js" type="text/javascript"></script>
    <script type="text/javascript">
        
    $(document).ready(function() {

        consultar_raciones(49);
        consulta_entrega_raciones_por_usuario(46, '2018-03');
        
    });

    </script>

    <div class="container-fluid" id="consultar_raciones">

        <div style="display: none;" class="alert alert-info alert-dismissible fade show animated bounceInDown" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <span class="oi oi-info" title="icon name" aria-hidden="true"></span>
            <label id="info-msg"></label>
        </div>

        <!-- Consulta por Fecha -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                CONSULTA MENSUAL DE ENTREGA DE RACIONES
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="form-row">

                        <div class="col-md-8">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2" for="institucion"><strong>Mes y Año</strong></label>
                                <input type="month" name="mes" id="mes" step="1" class="form-control-custom" value="<?= date('Y-m') ?>" >
                            </div>  
                        </div> 

                        <div class="col-md-12 text-right">

                            <button type="submit" name="buscar_raciones" id="buscar_raciones" class="btn btn-dark-blue mb-2">
                                <span class="oi oi-magnifying-glass text-blue" title="icon name" aria-hidden="true"></span>
                                Buscar
                            </button>
                        </div>        

                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Bloque -->

        <hr>    

        <!-- INFO -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                INFORMACIÓN DE ENTREGA DE RACIONES MENSUAL
            </div>
            <div class="card-body-custom" id="area-impresion">
                <div class="col-md-12">
                    <div class="form-row">

                        <div class="col-md-4 col-xs-4">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2 full-width" for="institucion"><strong>Institución Educativa</strong></label>
                                <label id="nombre-institucion" class="full-width border-label"></label>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-4">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2 full-width" for="sede"><strong>Sede</strong></label>
                                <label id="sede" class="full-width border-label"></label>
                            </div>  
                        </div> 
                        <div class="col-md-2 col-xs-2">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2 full-width" for="registro"><strong>Código DANE</strong></label>
                                <label id="dane" class="full-width border-label"></label>
                            </div>  
                        </div> 
                        <div class="col-md-2 col-xs-2">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2 full-width" for="registro"><strong>Fecha de Registro</strong></label>
                                <label class="full-width border-label"><strong><?= date("d-m-Y"); ?></strong></label>
                            </div>  
                        </div> 

                        <div class="col-md-4 col-xs-4">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2 full-width" for="direccion"><strong>Dirección</strong></label>
                                <label id="direccion" class="full-width border-label"></label>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-4">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2 full-width" for="barrio"><strong>Barrio</strong></label>
                                <label id="barrio" class="full-width border-label"></label>
                            </div>  
                        </div> 

                        <div class="col-md-4 col-xs-4">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2" for="comuna"><strong>Comuna</strong></label>
                                <label id="comuna" class="full-width border-label"></label>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-4">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2" for="proveedor"><strong>Proveedor</strong></label>
                                <label id="proveedor" class="full-width border-label"></label>
                            </div>  
                        </div> 
                        <div class="col-md-2 col-xs-2">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2" for="contrato"><strong>Contrato</strong></label>
                                <label id="contrato" class="full-width border-label"></label>
                            </div>  
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2" for="modalidad"><strong>Modalidad</strong></label>
                                <label id="tipo_racion" class="full-width border-label"></label>
                            </div>  
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2" for="raciones"><strong>Pre-Escolar/Primaria</strong></label>
                                <label id="raciones_programadas_pp" class="full-width border-label"></label>
                            </div>  
                        </div>
                        <div class="col-md-2">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2" for="raciones"><strong>Secundaria</strong></label>
                                <label id="raciones_programadas_s" class="full-width border-label"></label>
                            </div>  
                        </div>
                        <form method="post" id="entrega-raciones-form" enctype="multipart/form-data">
                            <div class="col-md-12 table-responsive">
                                <table id="results" class="table table-hover table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">SEDE</th>
                                            <th class="text-center" scope="col">TIPO RACIÓN</th>
                                            <th class="text-center" scope="col"># RACIONES PRE-ESCOLAR/PRIMARIA POR DÍA</th>
                                            <th class="text-center" scope="col"># RACIONES SECUNDARIA POR DÍA</th>
                                            <th class="text-center" scope="col"># DIAS ATENDIDOS</th>
                                            <th class="text-center" scope="col">TOTAL RACIONES</th>
                                            <th class="text-center" scope="col">ADJUNTAR SOPORTE</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>      
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Bloque -->

        <hr>

        <div class="col-md-12 text-right">

            <button class="btn btn-dark-blue mb-2" id="vista-impresion">
                <span class="oi oi-print text-blue" title="icon name" aria-hidden="true"></span>
                Vista Impresión
            </button>

            <button type="submit" class="btn btn-dark-blue mb-2" data-dismiss="modal" aria-label="Close">
                <span class="oi oi-account-logout text-blue" title="icon name" aria-hidden="true"></span>
                Salir
            </button>
        </div>

    </div>  

<?php
include('../../hooks/footer.php');
?>