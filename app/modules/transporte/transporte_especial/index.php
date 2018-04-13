<?php
include('../../../hooks/head.php')
?>

    <div class="container-fluid">
        <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                Consulta transporte especial
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <form action="" class="form-row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="search">Nombre de Ruta</label>
                                <input type="search" class="form-control" id="nameRoute"
                                       name="nameRoute"/>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="">Operador</label>
                                <input type="search" class="form-control" id="operator"
                                       name="operator"/>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-dark-blue mb-2">Buscar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- Fin Bloque -->

        <hr/>

        <!-- Bloque de listado de operadores -->
        <div class="row d-none">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="">Operadores</a>
                    </li>
                </ul>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th></th>
                        <th>No. contrato</th>
                        <th>No. Pasajeros</th>
                        <th>Jornada</th>
                        <th>Nombre de operador</th>
                        <th>Institución educativa</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fin bloque -->


        <!-- Bloque de toda la información -->
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-vehicle" data-toggle="tab" href="#vehicle" role="tab"
                           aria-controls="vehicle" aria-selected="true">Vehículo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-conductor" data-toggle="tab" href="#conductor" role="tab"
                           aria-controls="conductor" aria-selected="true">Conductor</a>
                    </li>
                    <li class="nav-item">
                        <a href="#auxiliar" class="nav-link" id="tab-auxiliar" data-toggle="tab" role="tab"
                           aria-controls="auxiliar" aria-selected="true">Auxiliar</a>
                    </li>
                    <li class="nav-item">
                        <a href="#recorrido" class="nav-link" id="tab-recorrido" data-toggle="tab" role="tab"
                           aria-controls="recorrido" aria-selected="true">Recorrido</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="vehicle" role="tabvehicle" aria-labelledby="tab-vehicle">
                        <fieldset>
                            <legend>
                                Datos del vehículo
                            </legend>
                        </fieldset>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Tipo de vehículo</label>
                                                <select name="tipoVehiculo" id="" class="form-control">
                                                    <option value="1">Bus</option>
                                                    <option value="2">Carro</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Placa Vehículo</label>
                                                <input type="text" class="form-control" name="placaVehiculo"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Marca del Vehículo</label>
                                                <input type="text" class="form-control" name="marcaVehiculo"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Fecha Revisión Técnico Mecánica</label>
                                                <input type="date" class="form-control" name="fecharevitecnomec"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">No. Revisión Técnico Mecánica</label>
                                                <input type="number" class="form-control" name="numrevitecnomec"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Estado del Contrato</label>
                                                <select class="form-control" name="estadoContrato" id="">
                                                    <option value="1">Activo</option>
                                                    <option value="2">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Fecha Vencimiento SOAT</label>
                                                <input type="date" class="form-control" name="fechavencisoat"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">No. SOAT</label>
                                                <input type="text" class="form-control" name="numsoat"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Número de Pasajeros</label>
                                                <input type="number" class="form-control" name="numpasajeros"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Propietario del Vehículo</label>
                                                <input type="text" class="form-control" name="propietarioVehiculo"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">No. De Contrato</label>
                                                <input type="text" class="form-control" name="numcontrato"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">No. Tarjeta de Operación</label>
                                                <input type="text" class="form-control" name="numtarjetaope"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Seguro Contractual</label>
                                                <input type="text" class="form-control" name="seguroContractual"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Seguro Extra Contractual</label>
                                                <input type="text" class="form-control" name="seguroExtraContractual"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Tipo de Zona</label>
                                                <select class="form-control" name="tipoZona" id="">
                                                    <option value="1">Urbana</option>
                                                    <option value="2">Rural</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">No. Contrato</label>

                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="">Observaciones</label>

                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="button" class="btn btn-dark-blue">Guardar</button>
                                            <button type="button" class="btn btn-dark-blue">Salir</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="conductor" role="tabconductor" aria-labelledby="tab-conductor">
                        <fieldset>
                            <legend>
                                Datos del Conductor
                            </legend>
                        </fieldset>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Tipo de Documento</label>
                                                <select class="form-control" name="tipoDocumento" id="">
                                                    <option value="1">Tarjeta de Identidad</option>
                                                    <option value="2">Cedula de ciudadania</option>
                                                    <option value="3">Otro</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Documento</label>
                                                <input type="number" class="form-control" name="document"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Primer Apellido</label>
                                                <input type="text" class="form-control" name="primerApellido"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Segundo Apellido</label>
                                                <input type="text" class="form-control" name="segundoApellido"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Primer Nombre</label>
                                                <input type="text" class="form-control" name="primerNombre"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Segundo Nombre</label>
                                                <input type="text" class="form-control" name="SegundoNombre"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Dirección de Residencia</label>
                                                <input type="text" class="form-control" name="direccionResidencia"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">No. de Celular</label>
                                                <input type="text" class="form-control" name="numCelular"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Jornada</label>
                                                <select class="form-control" name="jornada" id="">
                                                    <option value="1">Mañana</option>
                                                    <option value="2">Tarde</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Licencia de conducción No.</label>
                                                <input type="text" class="form-control" name="licenciaConduccion"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Categoría Autorizada</label>
                                                <input type="text" class="form-control" name="categoriaAutorizada"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Fecha Vencimiento Licencia</label>
                                                <input type="text" class="form-control" name="fechavencilince"/>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="button" class="btn btn-dark-blue">Editar</button>
                                            <button type="button" class="btn btn-dark-blue">Salir</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="auxiliar" role="tabauxiliar" aria-labelledby="tab-auxiliar">
                        <fieldset>
                            <legend>
                                Datos del Auxiliar
                            </legend>
                        </fieldset>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Tipo de Documento</label>
                                                <select class="form-control" name="tipoDocumento" id="">
                                                    <option value="1">Tarjeta de identidad</option>
                                                    <option value="2">Cedula</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Documento</label>
                                                <input type="number" class="form-control" name="documento" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Primer Apellido</label>
                                                <input type="text" class="text" name="primerApellido" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Segundo Apellido</label>
                                                <input type="text" class="form-control" name="segundoApellido"  />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Primer Nombre</label>
                                                <input type="text" class="form-control" name="primerNombre" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Segundo Nombre</label>
                                                <input type="text" class="form-control" name="primerNombre" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Dirección de Residencia</label>
                                                <input type="text" class="form-control" name="direccionResidencia" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">No. de Celular</label>
                                                <input type="number" class="form-control" name="numCelular" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Formación Académica</label>
                                                <input type="text" class="form-control" name="formacionAcade" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button class="btn btn-dark-blue mb-2" type="button">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="recorrido" role="tabarecorrido" aria-labelledby="tab-recorrido">
                        Recorrido
                    </div>
                </div>
            </div>
        </div>
        <!-- Bloque de toda la información -->
    </div>


    <script>
        $('#myTab a').on('click', function (e) {
            e.preventDefault()
            $(this).tab('show')
        })
    </script>


<?php
include('../../../hooks/footer.php')
?>