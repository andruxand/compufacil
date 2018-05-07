    <script src="js/registrar_raciones.js" type="text/javascript"></script>
    <script type="text/javascript">
        
    $(document).ready(function() {

        consultar_datos_estudiantes('<?= $_POST['id']; ?>');

    });

    </script>

    <div class="container-fluid">
        <div style="display: none;" id="info-racion" class="alert alert-info alert-dismissible fade show animated bounceInDown" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <span class="oi oi-info" title="icon name" aria-hidden="true"></span>
                La información se registrará con fecha <strong><?= date("d-m-Y"); ?></strong>
        </div>

        <div style="display: none;" id="existe-racion" class="alert alert-info alert-dismissible fade show animated bounceInDown" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <span class="oi oi-info" title="icon name" aria-hidden="true"></span>
                La información para este día ya se encuentra registrada, fecha: <strong><?= date("d-m-Y"); ?></strong>
        </div>

        <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                INFORMACIÓN DE LA INSTITUCIÓN
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="form-row">

                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width" for="institucion"><strong>Institución Educativa</strong></label>
                                <label id="nombre-institucion" class="full-width border-label"></label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width" for="sede"><strong>Sede</strong></label>
                                <label id="sede" class="full-width border-label"></label>
                            </div>  
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width" for="registro"><strong>Fecha de Registro</strong></label>
                                <label class="full-width border-label"><?= date("d/m/Y"); ?></label>
                            </div>  
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width" for="direccion"><strong>Dirección</strong></label>
                                <label id="direccion" class="full-width border-label"></label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width" for="barrio"><strong>Barrio</strong></label>
                                <label id="barrio" class="full-width border-label"></label>
                            </div>  
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="comuna"><strong>Comuna</strong></label>
                                <label id="comuna" class="full-width border-label"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="proveedor"><strong>Operador</strong></label>
                                <label id="proveedor" class="full-width border-label"></label>
                            </div>  
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="contrato"><strong>Contrato</strong></label>
                                <label id="contrato" class="full-width border-label"></label>
                            </div>  
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="modalidad"><strong>Modalidad</strong></label>
                                <label id="tipo_racion" class="full-width border-label"></label>
                            </div>  
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="raciones"><strong>Jornada Única</strong></label>
                                <label id="raciones_programadas_pp" class="full-width border-label"></label>
                            </div>  
                        </div>  
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="raciones"><strong>Complemento Alimentario</strong></label>
                                <label id="raciones_programadas_s" class="full-width border-label"></label>
                            </div>  
                        </div>     

                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Bloque -->

        <hr>

        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-dark-blue mb-2" data-dismiss="modal" aria-label="Close">
                <span class="oi oi-account-logout text-blue" title="icon name" aria-hidden="true"></span>
                Salir
            </button>
        </div>

    </div>  
