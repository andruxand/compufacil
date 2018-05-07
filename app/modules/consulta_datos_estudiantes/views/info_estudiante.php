    <script src="js/script.js" type="text/javascript"></script>
    <script type="text/javascript">
        
    $(document).ready(function() {

        consulta_datos_estudiantes('<?= $_POST['id']; ?>');

    });

    </script>

    <div class="container-fluid">

        <div id="infoEstudianteActual" class="card border-dark-blue" >
          <div class="card-body" style="padding: 5px;">

            <div class="col-md-12 form-row">

              <div class="col-md-4">

                <div class="form-group" style="margin: 0px;">
                    <label class="col-sm-12" for="iNombres" data-toggle="tooltip" title="" ><strong>Nombre</strong></label>
                    <div class="col-sm-12 formControls">
                        <span id="infoNombre"></span>  
                    </div>
                </div>

              </div>

              <div class="col-md-4">

                <div class="form-group rsform-block rsform-block-direccion" style="margin: 0px;">
                  <label class="col-sm-12 control-label formControlLabel" data-toggle="tooltip" title="" for="direccion"><strong>Tipo Identificación</strong></label>
                    <div class="col-sm-12 formControls">
                        <span id="infoTipoIdentificacion"></span>    
                    </div>   
                </div>

              </div>

              <div class="col-md-4">

                <div class="form-group rsform-block rsform-block-direccion" style="margin: 0px;">
                  <label class="col-sm-12 control-label formControlLabel" data-toggle="tooltip" title="" for="direccion"><strong>Identificación</strong></label>
                  <div class="col-sm-12 formControls">
                    <span id="infoIdentificacion"></span>       
                  </div>
                </div>

              </div>

            </div>

          </div><!-- fin panel body -->
        </div><!-- fin panel Primario -->

        <hr>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">INFORMACIÓN ESTUDIANTE</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">INFORMACIÓN ACUDIENTE</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">INFORMACIÓN ACADÉMICA</a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              
            <div style="display: none;" class="alert alert-info alert-dismissible fade show animated bounceInDown" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span class="oi oi-info" title="icon name" aria-hidden="true"></span>
                    <label id="info-msg"></label>
                </div>

                <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
                <div class="card border-dark-blue">
                    <div class="card-header-dark-blue">
                        INFORMACIÓN DEL ESTUDIANTE
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-row">

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Tipo Documento de Identificación</strong></label>
                                        <label id="tipodoc" class="full-width border-label"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Número de Identificación</strong></label>
                                        <label id="nro_identificacion" class="full-width border-label"></label>
                                    </div>  
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Primer Nombre</strong></label>
                                        <label id="nombre1" class="full-width border-label"></label>
                                    </div>  
                                </div> 

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Segundo Nombre</strong></label>
                                        <label id="nombre2" class="full-width border-label"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Primer Apellido</strong></label>
                                        <label id="apellido1" class="full-width border-label"></label>
                                    </div>  
                                </div> 

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2" for=""><strong>Segundo Apellido</strong></label>
                                        <label id="apellido2" class="full-width border-label"></label>
                                    </div>
                                </div>   

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2" for=""><strong>Sexo</strong></label>
                                        <label id="genero" class="full-width border-label"></label>
                                    </div>
                                </div> 

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin Bloque -->

          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
                <div class="card border-dark-blue">
                    <div class="card-header-dark-blue">
                        INFORMACIÓN DEL ACUDIENTE
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-row">

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Tipo Documento de Identificación</strong></label>
                                        <label id="tipoDocumentoAcu" class="full-width border-label"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Número de Identificación</strong></label>
                                        <label id="numDocumentoAcu" class="full-width border-label"></label>
                                    </div>  
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Nombres</strong></label>
                                        <label id="nombresAcu" class="full-width border-label"></label>
                                    </div>  
                                </div> 

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Apellidos</strong></label>
                                        <label id="apellidosAcu" class="full-width border-label"></label>
                                    </div>  
                                </div>  

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2" for=""><strong>Correo</strong></label>
                                        <label id="correoAcu" class="full-width border-label"></label>
                                    </div>
                                </div> 

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2" for=""><strong>Celular</strong></label>
                                        <label id="celularAcu" class="full-width border-label"></label>
                                    </div>
                                </div> 

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2" for=""><strong>Parentesco</strong></label>
                                        <label id="parentescoAcu" class="full-width border-label"></label>
                                    </div>
                                </div> 

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin Bloque -->
            </div>
          <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
              
            <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
                <div class="card border-dark-blue">
                    <div class="card-header-dark-blue">
                        INFORMACIÓN ACADÉMICA
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-row">

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Institución</strong></label>
                                        <label id="institucion_info" class="full-width border-label"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Sede</strong></label>
                                        <label id="sede" class="full-width border-label"></label>
                                    </div>  
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Jornada</strong></label>
                                        <label id="jornada" class="full-width border-label"></label>
                                    </div>  
                                </div> 

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Grado</strong></label>
                                        <label id="grado_info" class="full-width border-label"></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 full-width" for=""><strong>Grupo</strong></label>
                                        <label id="grupo_info" class="full-width border-label"></label>
                                    </div>  
                                </div> 

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2" for=""><strong>Año Lectivo</strong></label>
                                        <label id="aniolectivo" class="full-width border-label"></label>
                                    </div>
                                </div>   

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin Bloque -->

          </div>
        </div>
        <div id="printArea"></div>
            
        <hr>

        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-dark-blue mb-2" data-dismiss="modal" aria-label="Close">
                <span class="oi oi-account-logout text-blue" title="icon name" aria-hidden="true"></span>
                Salir
            </button>
            <button type="button" class="btn btn-dark-blue mb-2" id="btn-print-detail">
                <i class="fa fa-print"></i> 
                Imprimir
            </button>
        </div>

    </div>  
