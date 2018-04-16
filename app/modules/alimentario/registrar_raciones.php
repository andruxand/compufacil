<?php

?>

    <div class="container-fluid">
        <div class="alert alert-info alert-dismissible fade show animated bounceInDown" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <span class="oi oi-info" title="icon name" aria-hidden="true"></span>
                La información se registrará con fecha <strong><?= date("d-m-Y"); ?></strong>
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
                                <label class="mb-2 mr-sm-2 full-width text-center" for="institucion"><strong>Institución Educativa</strong></label>
                                <label class="full-width border-label">Institución Educativa</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width text-center" for="sede"><strong>Sede</strong></label>
                                <label class="full-width border-label">Sede</label>
                            </div>  
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width text-center" for="registro"><strong>Fecha de Registro</strong></label>
                                <label class="full-width border-label text-center"><strong><?= date("d-m-Y"); ?></strong></label>
                            </div>  
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width text-center" for="direccion"><strong>Dirección</strong></label>
                                <label class="full-width border-label">Sede</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width text-center" for="barrio"><strong>Barrio</strong></label>
                                <label class="full-width border-label">Barrio</label>
                            </div>  
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 text-center" for="comuna"><strong>Comuna</strong></label>
                                <label class="full-width border-label">Comuna</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="proveedor"><strong>Proveedor</strong></label>
                                <label class="full-width border-label">Proveedor</label>
                            </div>  
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="contrato"><strong>Contrato</strong></label>
                                <label class="full-width border-label">Contrato</label>
                            </div>  
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="modalidad"><strong>Modalidad</strong></label>
                                <label class="full-width border-label">Modalidad</label>
                            </div>  
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="raciones"><strong>Raciones Programadas</strong></label>
                                <label class="full-width border-label">Raciones Programadas</label>
                            </div>  
                        </div>      

                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Bloque -->

        <hr>

        <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                REGISTRO DE RACIÓN
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <form action="" class="form-row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="primaria"><strong>Pre-escolar y Primaria</strong></label>
                                <label class="full-width border-label">Modalidad</label>
                            </div>  
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="secundaria"><strong>Secundaria</strong></label>
                                <label class="full-width border-label">Raciones Programadas</label>
                            </div>  
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="total"><strong>Total Entregados</strong></label>
                                <label class="full-width border-label">Raciones Programadas</label>
                            </div>  
                        </div> 

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="observaciones"><strong>Observaciones</strong></label>
                                <textarea name="observaciones" class="form-control" placeholder="Observaciones" id="observaciones" rows="2"></textarea>
                            </div>  
                        </div> 

                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-dark-blue mb-2">
                                <span class="oi oi-check text-blue" title="icon name" aria-hidden="true"></span>
                                Registrar
                            </button>
                        </div>        

                    </form>
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