   <?php 

        require_once '../../../config/autoload.php'; 

        if( $db->verifyRoles($current_roles, $isCoordinador) ){

            $disabledField = "";

        }else{

            $disabledField = "disabled";

        }

        if( $db->verifyRoles($current_roles, $isPersonero) ){

            $disabledFieldPersonero = "";

        }else{

            $disabledFieldPersonero = "disabled";

        }

        if( $db->verifyRoles($current_roles, $isProveedor) ){

            $disabledFieldProveedor = "";

        }else{

            $disabledFieldProveedor = "disabled";

        }


    ?>

    <script src="js/registrar_raciones.js" type="text/javascript"></script>
    <script type="text/javascript">
        
    $(document).ready(function() {

        consultar_raciones('<?= $_POST['id']; ?>');

    });

    </script>

    <div class="container-fluid">
        <div style="display: none;" id="info-racion" class="alert alert-info alert-dismissible fade show animated bounceInDown" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <span class="oi oi-info" title="icon name" aria-hidden="true"></span>
                <?php if( $db->verifyRoles($current_roles, $isCoordinador) ){ ?>
                    La información se registrará con fecha <strong><?= date("d-m-Y"); ?></strong>
                <?php }else{ ?>
                    Aún no se ha registrado raciones para hoy. <strong><?= date("d-m-Y"); ?></strong>
                <?php } ?>
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
                                <label class="mb-2 mr-sm-2 full-width text-center" for="institucion"><strong>Institución Educativa</strong></label>
                                <label id="nombre-institucion" class="full-width border-label"></label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width text-center" for="sede"><strong>Sede</strong></label>
                                <label id="sede" class="full-width border-label"></label>
                            </div>  
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width text-center" for="registro"><strong>Fecha de Registro</strong></label>
                                <label class="full-width border-label text-center"><strong><?= date("d/m/Y"); ?></strong></label>
                            </div>  
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width text-center" for="direccion"><strong>Dirección</strong></label>
                                <label id="direccion" class="full-width border-label"></label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 full-width text-center" for="barrio"><strong>Barrio</strong></label>
                                <label id="barrio" class="full-width border-label"></label>
                            </div>  
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2 text-center" for="comuna"><strong>Comuna</strong></label>
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

        <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                REGISTRO DE RACIÓN
            </div>
            <div class="card-body">
                <div class="col-md-12">

                    <div style="display: none;" class="alert alert-success alert-dismissible fade show animated bounceInDown" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="oi oi-check" title="icon name" aria-hidden="true"></span>
                            <label id="success-msg"></label>
                    </div>

                    <div style="display: none;" class="alert alert-danger alert-dismissible fade show animated bounceInDown" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="oi oi-check" title="icon name" aria-hidden="true"></span>
                            <label id="danger-msg"></label>
                    </div>

                    <form id="raciones-form" method="post" class="form-row">

                        <input type="hidden" name="fcontrato" id="fcontrato">
                        <input type="hidden" name="fregistro" id="fregistro" value="<?= date("d/m/Y"); ?>">
                        <input type="hidden" name="finstitucion" id="finstitucion">
                        <input type="hidden" name="fmodalidad" id="fmodalidad">
                        <input type="hidden" name="fsede" id="fsede">
                        <input type="hidden" name="fuser" id="fuser" value="<?= $current_userID; ?>">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="primaria"><strong>Jornada Única</strong></label>
                                <input class="form-control" type="number" name="racion-pp" id="racion-pp" <?= $disabledField ?> >
                            </div>  
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="secundaria"><strong>Complemento Alimentario</strong></label>
                                <input class="form-control" type="number" name="racion-s" id="racion-s" <?= $disabledField ?> >
                            </div>  
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="total"><strong>Total Entregados</strong></label>
                                <input class="form-control disabled" type="text" name="racion-total" id="racion-total" readonly="readonly">
                                <input type="hidden" name="id_registro_racion" id="id_registro_racion">
                            </div>  
                        </div> 

                        <div class="col-md-12" id="observaciones-block" style="display: none;">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="observaciones"><strong>Observaciones</strong></label>
                                <textarea name="observaciones" class="form-control" placeholder="Observaciones" id="observaciones" rows="2"></textarea>
                            </div>  
                        </div> 

                        <div class="col-md-12">
                            <div class="form-group">
                                <!--<div class = "custom-switch custom-switch-label-yesno">-->
                                    <label class="mb-2 mr-sm-2" for="observaciones"><strong>Certifica Coordinador</strong></label>
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input class="custom-control-input" value="1" name="confirm_coordinador" id="confirm_coordinador" type="checkbox" <?= $disabledField; ?> >
                                        <label style="line-height: 24px;" id="confirma-coordinador" class="custom-control-label font-color" for="confirm_coordinador">
                                            No certifico que las raciones fueron entregadas a los niños y niñas inscritos en el programa.
                                        </label>
                                    </div>
                                    
                                    <!-- <label class="custom-switch-btn" for="confirm"> </label> -->
                                <!--</div>-->
                            </div>  
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <!--<div class = "custom-switch custom-switch-label-yesno">-->
                                    <label class="mb-2 mr-sm-2" for="observaciones"><strong>Certifica Personero</strong></label>
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input class="custom-control-input" value="1" name="confirm_personero" id="confirm_personero" type="checkbox" <?= $disabledFieldPersonero; ?> >
                                        <label style="line-height: 24px;" id="confirma-personero" class="custom-control-label font-color" for="confirm_personero">
                                            No certifico que las raciones fueron entregadas a los niños y niñas inscritos en el programa.
                                        </label>
                                    </div>
                                    
                                    <!-- <label class="custom-switch-btn" for="confirm"> </label> -->
                                <!--</div>-->
                            </div>  
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <!--<div class = "custom-switch custom-switch-label-yesno">-->
                                    <label class="mb-2 mr-sm-2" for="observaciones"><strong>Certifica Proveedor</strong></label>
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input class="custom-control-input" value="1" name="confirm_proveedor" id="confirm_proveedor" type="checkbox" <?= $disabledFieldProveedor; ?> >
                                        <label style="line-height: 24px;" id="confirma-proveedor" class="custom-control-label font-color" for="confirm_proveedor">
                                            No certifico que las raciones fueron entregadas a los niños y niñas inscritos en el programa.
                                        </label>
                                    </div>
                                    
                                    <!-- <label class="custom-switch-btn" for="confirm"> </label> -->
                                <!--</div>-->
                            </div>  
                        </div>
                        

                        <div class="col-md-12 text-right">

                            <?php 
                                if( ($db->verifyRoles($current_roles, $isPersonero)) || ($db->verifyRoles($current_roles, $isProveedor)) ){
                            ?>
                            <button name="certificar_racion" id="certificar_racion" class="btn btn-dark-blue mb-2">
                                <span class="oi oi-check text-blue" title="icon name" aria-hidden="true"></span>
                                Certificar
                            </button>
                            <?php
                                }
                            ?> 

                            <?php 
                                if( $db->verifyRoles($current_roles, $isCoordinador) ){
                            ?>
                            <button name="registrar_raciones" id="registrar_raciones" class="btn btn-dark-blue mb-2">
                                <span class="oi oi-check text-blue" title="icon name" aria-hidden="true"></span>
                                Registrar
                            </button>
                            <?php
                                }
                            ?> 

                            <button style="display: none;" name="cancelar-registro" id="cancelar-registro" class="btn btn-dark-blue mb-2">
                                <span class="oi oi-x text-blue" title="icon name" aria-hidden="true"></span>
                                Cancelar
                            </button>


                            <?php 
                                if( $db->verifyRoles($current_roles, $isCoordinador) ){
                            ?>
                                <button style="display: none;" name="editar-registro" id="editar-registro" class="btn btn-dark-blue mb-2">
                                    <span class="oi oi-pencil text-blue" title="icon name" aria-hidden="true"></span>
                                    Editar Registro
                                </button>
                            <?php
                                }
                            ?>    
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
