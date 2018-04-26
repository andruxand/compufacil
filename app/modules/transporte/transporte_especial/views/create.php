<h3>Información de ruta</h3>
<form action="" id="newRoute">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="vigencia">Vigencia</label>
                <select name="vigencia" id="vigencia" class="form-control" required>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2010</option>
                    <option value="2020">2020</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="nombreRuta">Nombre de ruta</label>
                <input type="text" name="nombreRuta" id="nombreRuta" class="form-control" required/>
            </div>
        </div>
        <div class="col-md-3">
            <label for="Proveedor">Proveedor</label>
            <select name="proveedor" id="proveedor" class="form-control" required>
                <option value=""></option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="ieo">Institución educativa</label>
            <select name="ieo" id="ieo" class="form-control" required>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label for="vehiculo">Vehículo</label>
            <select name="vehiculo" id="vehiculo" class="form-control" required>
                <option value=""></option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="conductor">Conductor</label>
            <select name="conductor" id="conductor" class="form-control" required>
                <option value=""></option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="auxiliar">Auxiliar</label>
            <select name="auxiliar" id="auxiliar" class="form-control" required>
                <option value=""></option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="numPasajero">Capacidad de ruta</label>
            <input type="number" name="numPasajeros" id="numPasajeros" class="form-control" required/>
        </div>
    </div>
    <h3>Paradas</h3>
    <div id="paradas">

    </div>
    <div class="row">
        <div class="col-md-6">
            <button type="button" class="btn btn-dark-blue" id="btn-add-parada">Agregar Parada</button>
        </div>
        <div class="col-md-6 text-right">
            <div class="dropdown">
                <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Acciones
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#" id="btn-create-vehiculo">Crear vehículo</a>
                    <a class="dropdown-item" href="#" id="btn-create-conductor">Crear conductor</a>
                    <a class="dropdown-item" href="#" id="btn-create-auxiliar">Crear auxiliar</a>
                </div>
                <button type="submit" class="btn btn-dark-blue" id="btn-crear-ruta">Guardar Ruta</button>
            </div>
        </div>
    </div>
</form>

<div class="modal fade bd-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1" id="modal-forms"
     role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <span class="oi oi-browser icon-window" title="icon name" aria-hidden="true"></span>
                <h4 class="modal-title" id="myLargeModalLabel">
                    Parada
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body-modal-forms">

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        const temp = function (id) {
            return `<div class="row" data-id="${id}">
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" name="parada[]" class="form-control" placeholder="Nombre de ruta" required/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" name="direccion[]" class="form-control" placeholder="Dirección" required/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="number" name="secuencia[]" class="form-control" placeholder="secuencia" required/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" name="hora_llegada[]" class="form-control time" placeholder="Hora llegada"
                           required/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" name="hora_partida[]" class="form-control time" placeholder="Hora partida"
                           required/>
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-dark-blue mt-1 btn-clear" data-id="${id}"><span class="oi oi-circle-x"></span></button>
            </div>
        </div>`
        }

        $(".time").timepicker({
            icons: {
                up: 'oi oi-chevron-top',
                down: 'oi oi-chevron-bottom'
            },
            minuteStep: 1,
            defaultTime: false
        })

        $.ajax({
            url: 'index.php?router=get-proveedores',
            method: 'GET'
        }).then(function (response) {
            $("#proveedor").select2({
                data: response,
                placeholder: "Seleccione un proveedor",
                language: 'es'
            });
        })

        $("#ieo").select2({
            ajax: {
                url: 'index.php',
                dataType: 'json',
                data: function (params) {
                    const query = {
                        router: 'get-ieo',
                        search: params.term
                    };

                    return query;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            },
            placeholder: 'Búsqueda de rutas',
            minimumInputLength: 3,
            language: 'es'
        });

        getVehiculos();

        getConductores();

        getAuxiliares();

        let idParada = 0

        $(".time").timepicker({
            icons: {
                up: 'oi oi-chevron-top',
                down: 'oi oi-chevron-bottom'
            },
            minuteStep: 1,
            defaultTime: false
        })

        $("#btn-add-parada").click(function (e) {
            idParada++
            $("#paradas").append(temp(idParada))
            $(".time").timepicker({
                icons: {
                    up: 'oi oi-chevron-top',
                    down: 'oi oi-chevron-bottom'
                },
                minuteStep: 1,
                defaultTime: false
            })
            $(".btn-clear").click(function (e) {
                $("div[data-id='" + $(this).attr("data-id") + "']").remove();
                console.log($("#newRoute").serialize())
            });
        })

        $("#newRoute").submit(function (e) {
            $.ajax({
                url: 'index.php?router=create-ruta',
                method: 'POST',
                data: $("#newRoute").serialize()
            }).then(function (response) {
                if (!response.success) {
                    $("#alert-error").text(response.message).show("slow", function () {
                        setTimeout(function () {
                            $("#alert-error").hide('slow');
                        }, 5000)
                    });
                    return false;
                }
                $("#alert-success").text(response.message).show("slow", function () {
                    setTimeout(function () {
                        $("#alert-success").hide('slow');
                    }, 5000)
                });
                $("#container").html('');
            }).catch(function (error) {
                $("#alert-error").text(response.message).show("slow", function () {
                    setTimeout(function () {
                        $("#alert-success").hide('slow');
                    }, 5000)
                });
            })
            e.preventDefault();
        })


        const tempVehi = `<form action="" id="formCreateVehiculo">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Tipo de vehículo</label>
                        <select name="tipoVehiculo" id="" class="form-control">
                            <option value="1">Bus</option>
                            <option value="2">Carro</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Placa Vehículo</label>
                        <input type="text" class="form-control" name="placaVehiculo" id="placaVehiculo" required maxlength="6"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Marca del Vehículo</label>
                        <input type="text" class="form-control" name="marcaVehiculo" id="marcaVehiculo" required maxlength="45"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Fecha Revisión Tecnomécanica</label>
                        <input type="date" class="form-control" name="fecharevitecnomec" id="fecharevitecnomec"
                               required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">No. Revisión Técnico Mecánica</label>
                        <input type="number" class="form-control" name="numrevitecnomec" id="numrevitecnomec" required maxlength="20"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Estado del Contrato</label>
                        <select class="form-control" name="estadoContrato" id="" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Fecha Vencimiento SOAT</label>
                        <input type="date" class="form-control" name="fechavencisoat" id="fechavencisoat" required maxlength="20"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">No. SOAT</label>
                        <input type="text" class="form-control" name="numsoat" id="numsoat" required maxlength="20"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Asignaciones disponibles</label>
                        <input type="number" class="form-control" name="numpasajeros" id="numpasajeros" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Propietario del Vehículo</label>
                        <input type="text" class="form-control" name="propietarioVehiculo" id="propietarioVehiculo"
                               required maxlength="60"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">No. De Contrato</label>
                        <input type="text" class="form-control" name="numcontrato" id="numcontrato" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">No. Tarjeta de Operación</label>
                        <input type="text" class="form-control" name="numtarjetaope" id="numtarjetaope" required maxlength="20"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Seguro Contractual</label>
                        <input type="text" class="form-control" name="seguroContractual" id="seguroContractual"
                               required maxlength="45"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Seguro Extra Contractual</label>
                        <input type="text" class="form-control" name="seguroExtraContractual"
                               id="seguroExtraContractual" required maxlength="45"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Tipo de Zona</label>
                        <select class="form-control" name="tipoZona" id="tipoZona" required>
                            <option value="Urbana">Urbana</option>
                            <option value="Rural">Rural</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-dark-blue" id="btn-create-vehiculo">Guardar</button>
                    <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </form>`;
        $("#btn-create-vehiculo").click(function (e) {
            e.preventDefault();
            $("#body-modal-forms").html(tempVehi)
            $("#modal-forms").modal('show')
            $("#formCreateVehiculo").submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: 'index.php?router=create-vehiculo',
                    method: 'POST',
                    data: $(this).serialize()
                }).then(function (response) {
                    if (!response.success) {
                        $("#alert-error").text(error).show("slow", function () {
                            setTimeout(function () {
                                $("#alert-error").hide('slow');
                            }, 5000)
                        });
                    } else {
                        $("#alert-success").text(response.message).show("slow", function () {
                            setTimeout(function () {
                                $("#alert-success").hide('slow');
                            }, 5000)
                        });
                    }
                    getVehiculos()
                    $("#modal-forms").modal('hide')
                    $("#body-modal-forms").html('')
                }).catch(function (error) {
                    $("#alert-success").text(response.message).show("slow", function () {
                        setTimeout(function () {
                            $("#alert-success").hide('slow');
                        }, 5000)
                    });
                    $("#modal-forms").modal('hide')
                    $("#body-modal-forms").html('')
                })
            })
        })

        const tempCond = `<form action="" id="formCreateConductor">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Tipo de Documento</label>
                        <select class="form-control" name="tipoDocumentoCond" id="tipoDocumentoCond" required>
                            <option value="1">Cédula de ciudadanía</option>
                            <option value="2">Nuip</option>
                            <option value="3">Cédula extranjera</option>
                            <option value="4">Tarjeta de identidad</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Documento</label>
                        <input type="number" class="form-control" name="documentCond" id="documentCond" required maxlength="12"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Primer Apellido</label>
                        <input type="text" class="form-control" name="primerApellidoCond" id="primerApellidoCond" required maxlength="45" "/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Segundo Apellido</label>
                        <input type="text" class="form-control" name="segundoApellidoCond" id="segundoApellidoCond" required maxlength="45"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Primer Nombre</label>
                        <input type="text" class="form-control" name="primerNombreCond" id="primerNombreCond" required maxlength="45"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Segundo Nombre</label>
                        <input type="text" class="form-control" name="segundoNombreCond" id="segundoNombreCond" required maxlength="45"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Dirección de Residencia</label>
                        <input type="text" class="form-control" name="direccionResidenciaCond" id="direccionResidenciaCond" required maxlength="70"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">No. de Celular</label>
                        <input type="text" class="form-control" name="numCelularCond" id="numCelularCond" maxlength="10" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Licencia de conducción No.</label>
                        <input type="text" class="form-control" name="licenciaConduccion" id="licenciaConduccion" required maxlength="45"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Categoría Autorizada</label>
                        <input type="text" class="form-control" name="categoriaAutorizada" id="categoriaAutorizada" required maxlength="2"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Fecha Vencimiento Licencia</label>
                        <input type="date" class="form-control" name="fechavencilince" id="fechavencilince" required/>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-dark-blue" id="btn-create-conductor">Guardar</button>
                    <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </form>`;
        $("#btn-create-conductor").click(function (e) {
            e.preventDefault()
            $("#body-modal-forms").html(tempCond)
            $("#modal-forms").modal('show')
            $("#formCreateConductor").submit(function (e) {
                e.preventDefault()
                $.ajax({
                    url: 'index.php?router=create-conductor',
                    method: 'POST',
                    data: $(this).serialize()
                }).then(function (response) {
                    if (!response.success) {
                        $("#alert-error").text(error).show("slow", function () {
                            setTimeout(function () {
                                $("#alert-error").hide('slow');
                            }, 5000)
                        });
                    } else {
                        $("#alert-success").text(response.message).show("slow", function () {
                            setTimeout(function () {
                                $("#alert-success").hide('slow');
                            }, 5000)
                        });
                    }
                    getConductores()
                    $("#modal-forms").modal('hide')
                    $("#body-modal-forms").html('')
                }).catch(function (error) {
                    $("#alert-success").text(response.message).show("slow", function () {
                        setTimeout(function () {
                            $("#alert-success").hide('slow');
                        }, 5000)
                    });
                    $("#modal-forms").modal('hide')
                    $("#body-modal-forms").html('')
                })
            })
        })

        const tempAux = `<form action="" id="formCreateAuxiliar">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Tipo de Documento</label>
                        <select class="form-control" name="tipoDocumentoAux" id="tipoDocumentoAux" required>
                            <option value="1">Cédula de ciudadanía</option>
                            <option value="2">Nuip</option>
                            <option value="3">Cédula extranjera</option>
                            <option value="4">Tarjeta de identidad</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Documento</label>
                        <input type="number" class="form-control" name="documentoAux" id="documentoAux" required maxlength="12"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Primer Apellido</label>
                        <input type="text" class="form-control" name="primerApellidoAux" id="primerApellidoAux" required maxlength="45"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Segundo Apellido</label>
                        <input type="text" class="form-control" name="segundoApellidoAux" id="segundoApellidoAux" required maxlength="45"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Primer Nombre</label>
                        <input type="text" class="form-control" name="primerNombreAux" id="primerNombreAux" required maxlength="45"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Segundo Nombre</label>
                        <input type="text" class="form-control" name="segundoNombreAux" id="segundoNombreAux" required maxlength="45"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Dirección de Residencia</label>
                        <input type="text" class="form-control" name="direccionResidenciaAux" id="direccionResidenciaAux" required maxlength="70"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">No. de Celular</label>
                        <input type="text" class="form-control" name="numCelularAux" id="numCelularAux" maxlength="10" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Formación Académica</label>
                        <input type="text" class="form-control" name="formacionAcadeAux" id="formacionAcadeAux" required maxlength="100"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button class="btn btn-dark-blue mb-2" type="submit" id="btn-create-auxiliar">Guardar</button>
                    <button class="btn btn-dark-blue mb-2" type="button" data-dismiss="modal">salir</button>
                </div>
            </div>
        </form>`;
        $("#btn-create-auxiliar").click(function (e) {
            e.preventDefault()
            $("#body-modal-forms").html(tempAux)
            $("#modal-forms").modal('show')
            $("#formCreateAuxiliar").submit(function (e) {
                e.preventDefault()
                $.ajax({
                    url: 'index.php?router=create-auxiliar',
                    method: 'POST',
                    data: $(this).serialize()
                }).then(function (response) {
                    if (!response.success) {
                        $("#alert-error").text(error).show("slow", function () {
                            setTimeout(function () {
                                $("#alert-error").hide('slow');
                            }, 5000)
                        });
                    } else {
                        $("#alert-success").text(response.message).show("slow", function () {
                            setTimeout(function () {
                                $("#alert-success").hide('slow');
                            }, 5000)
                        });
                    }
                    getAuxiliares()
                    $("#modal-forms").modal('hide')
                    $("#body-modal-forms").html('')
                }).catch(function (error) {
                    $("#alert-success").text(response.message).show("slow", function () {
                        setTimeout(function () {
                            $("#alert-success").hide('slow');
                        }, 5000)
                    });
                    $("#modal-forms").modal('hide')
                    $("#body-modal-forms").html('')
                })
            });
        });


        function getVehiculos() {
            $.ajax({
                url: 'index.php?router=get-vehiculos',
                method: 'GET'
            }).then(function (response) {
                $("#vehiculo").select2({
                    data: response,
                    placeholder: 'Seleccione un vehículo',
                    language: 'es'
                })
            })
        }

        function getConductores() {
            $.ajax({
                url: 'index.php?router=get-conductores',
                method: 'GET'
            }).then(function (response) {
                $("#conductor").select2({
                    data: response,
                    placeholder: 'Seleccione un conductor',
                    language: 'es'
                })
            })
        }

        function getAuxiliares() {
            $.ajax({
                url: 'index.php?router=get-auxiliares',
                method: 'GET'
            }).then(function (response) {
                $("#auxiliar").select2({
                    data: response,
                    placeholder: 'Seleccione un auxiliar',
                    language: 'es'
                })
            })
        }

    })
</script>