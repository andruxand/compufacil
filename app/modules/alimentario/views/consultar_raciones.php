    <script src="js/registrar_raciones.js" type="text/javascript"></script>
    <script type="text/javascript">
        
    $(document).ready(function() {

        consultar_raciones('<?= $_POST['id']; ?>');
        consulta_mensual_raciones('<?= $_POST['id']; ?>', '<?= date('Y-m'); ?>');

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
                CONSULTAR RACIONES POR FECHA (MES Y AÑO)
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
                INFORMACIÓN DE REGISTRO DE RACIONES MENSUAL
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
                                <label class="mb-2 mr-sm-2" for="proveedor"><strong>Operador</strong></label>
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
                                <label class="mb-2 mr-sm-2" for="raciones"><strong>Jornada Única</strong></label>
                                <label id="raciones_programadas_pp" class="full-width border-label"></label>
                            </div>  
                        </div>
                        <div class="col-md-2">
                            <div class="form-group-custom">
                                <label class="mb-2 mr-sm-2" for="raciones"><strong>Complemento Alimentario</strong></label>
                                <label id="raciones_programadas_s" class="full-width border-label"></label>
                            </div>  
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table id="results" class="table table-hover table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" rowspan="2" scope="col">DÍA</th>
                                        <th class="text-center" colspan="5" scope="col">PRIMERA SEMANA</th>
                                        <th class="text-center" colspan="5" scope="col">SEGUNDA SEMANA</th>
                                        <th class="text-center" colspan="5" scope="col">TERCERA SEMANA</th>
                                        <th class="text-center" colspan="5" scope="col">CUARTA SEMANA</th>
                                        <th class="text-center" colspan="5" scope="col">QUINTA SEMANA</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" scope="col">1</th>
                                        <th class="text-center" scope="col">2</th>
                                        <th class="text-center" scope="col">3</th>
                                        <th class="text-center" scope="col">4</th>
                                        <th class="text-center" scope="col">5</th>
                                        <th class="text-center" scope="col">1</th>
                                        <th class="text-center" scope="col">2</th>
                                        <th class="text-center" scope="col">3</th>
                                        <th class="text-center" scope="col">4</th>
                                        <th class="text-center" scope="col">5</th>
                                        <th class="text-center" scope="col">1</th>
                                        <th class="text-center" scope="col">2</th>
                                        <th class="text-center" scope="col">3</th>
                                        <th class="text-center" scope="col">4</th>
                                        <th class="text-center" scope="col">5</th>
                                        <th class="text-center" scope="col">1</th>
                                        <th class="text-center" scope="col">2</th>
                                        <th class="text-center" scope="col">3</th>
                                        <th class="text-center" scope="col">4</th>
                                        <th class="text-center" scope="col">5</th>
                                        <th class="text-center" scope="col">1</th>
                                        <th class="text-center" scope="col">2</th>
                                        <th class="text-center" scope="col">3</th>
                                        <th class="text-center" scope="col">4</th>
                                        <th class="text-center" scope="col">5</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-center" scope="col">JORNADA ÚNICA</th>
                                        <td class="text-center" scope="col"><label id="pp_0_1"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_0_2"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_0_3"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_0_4"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_0_5"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_1_1"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_1_2"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_1_3"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_1_4"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_1_5"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_2_1"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_2_2"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_2_3"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_2_4"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_2_5"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_3_1"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_3_2"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_3_3"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_3_4"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_3_5"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_4_1"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_4_2"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_4_3"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_4_4"></label></td>
                                        <td class="text-center" scope="col"><label id="pp_4_5"></label></td>  
                                    </tr>  
                                    <tr>
                                        <th class="text-center" scope="col">COMPLEMENTO ALIMENTARIO</th>
                                        <td class="text-center" scope="col"><label id="s_0_1"></label></td>
                                        <td class="text-center" scope="col"><label id="s_0_2"></label></td>
                                        <td class="text-center" scope="col"><label id="s_0_3"></label></td>
                                        <td class="text-center" scope="col"><label id="s_0_4"></label></td>
                                        <td class="text-center" scope="col"><label id="s_0_5"></label></td>
                                        <td class="text-center" scope="col"><label id="s_1_1"></label></td>
                                        <td class="text-center" scope="col"><label id="s_1_2"></label></td>
                                        <td class="text-center" scope="col"><label id="s_1_3"></label></td>
                                        <td class="text-center" scope="col"><label id="s_1_4"></label></td>
                                        <td class="text-center" scope="col"><label id="s_1_5"></label></td>
                                        <td class="text-center" scope="col"><label id="s_2_1"></label></td>
                                        <td class="text-center" scope="col"><label id="s_2_2"></label></td>
                                        <td class="text-center" scope="col"><label id="s_2_3"></label></td>
                                        <td class="text-center" scope="col"><label id="s_2_4"></label></td>
                                        <td class="text-center" scope="col"><label id="s_2_5"></label></td>
                                        <td class="text-center" scope="col"><label id="s_3_1"></label></td>
                                        <td class="text-center" scope="col"><label id="s_3_2"></label></td>
                                        <td class="text-center" scope="col"><label id="s_3_3"></label></td>
                                        <td class="text-center" scope="col"><label id="s_3_4"></label></td>
                                        <td class="text-center" scope="col"><label id="s_3_5"></label></td>
                                        <td class="text-center" scope="col"><label id="s_4_1"></label></td>
                                        <td class="text-center" scope="col"><label id="s_4_2"></label></td>
                                        <td class="text-center" scope="col"><label id="s_4_3"></label></td>
                                        <td class="text-center" scope="col"><label id="s_4_4"></label></td>
                                        <td class="text-center" scope="col"><label id="s_4_5"></label></td>  
                                    </tr> 
                                    <tr>
                                        <th class="text-center" scope="col">TOTAL ENTREGADOS</th>
                                        <td class="text-center" scope="col"><label id="t_0_1"></label></td>
                                        <td class="text-center" scope="col"><label id="t_0_2"></label></td>
                                        <td class="text-center" scope="col"><label id="t_0_3"></label></td>
                                        <td class="text-center" scope="col"><label id="t_0_4"></label></td>
                                        <td class="text-center" scope="col"><label id="t_0_5"></label></td>
                                        <td class="text-center" scope="col"><label id="t_1_1"></label></td>
                                        <td class="text-center" scope="col"><label id="t_1_2"></label></td>
                                        <td class="text-center" scope="col"><label id="t_1_3"></label></td>
                                        <td class="text-center" scope="col"><label id="t_1_4"></label></td>
                                        <td class="text-center" scope="col"><label id="t_1_5"></label></td>
                                        <td class="text-center" scope="col"><label id="t_2_1"></label></td>
                                        <td class="text-center" scope="col"><label id="t_2_2"></label></td>
                                        <td class="text-center" scope="col"><label id="t_2_3"></label></td>
                                        <td class="text-center" scope="col"><label id="t_2_4"></label></td>
                                        <td class="text-center" scope="col"><label id="t_2_5"></label></td>
                                        <td class="text-center" scope="col"><label id="t_3_1"></label></td>
                                        <td class="text-center" scope="col"><label id="t_3_2"></label></td>
                                        <td class="text-center" scope="col"><label id="t_3_3"></label></td>
                                        <td class="text-center" scope="col"><label id="t_3_4"></label></td>
                                        <td class="text-center" scope="col"><label id="t_3_5"></label></td>
                                        <td class="text-center" scope="col"><label id="t_4_1"></label></td>
                                        <td class="text-center" scope="col"><label id="t_4_2"></label></td>
                                        <td class="text-center" scope="col"><label id="t_4_3"></label></td>
                                        <td class="text-center" scope="col"><label id="t_4_4"></label></td>
                                        <td class="text-center" scope="col"><label id="t_4_5"></label></td> 
                                    </tr> 
                                </tbody>
                            </table>
                        </div>     

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