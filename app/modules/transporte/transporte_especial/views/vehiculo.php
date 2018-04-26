<fieldset>
    <legend>
        Datos del vehículo
    </legend>
</fieldset>
<div class="row">
    <div class="col-md-12">
        <form action="" id="formVehiculo">
            <input type="hidden" name="idVehiculo" id="idVehiculo"/>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Tipo de vehículo</label>
                        <select name="tipoVehiculo" id="tipoVehiculo" class="form-control">
                            <option value="1">Bus</option>
                            <option value="2">Mini Ban</option>
                            <option value="3">Buseta</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Placa Vehículo</label>
                        <input type="text" class="form-control" name="placaVehiculo" id="placaVehiculo" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Marca del Vehículo</label>
                        <input type="text" class="form-control" name="marcaVehiculo" id="marcaVehiculo" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Fecha Revisión Técnico Mecánica</label>
                        <input type="date" class="form-control" name="fecharevitecnomec" id="fecharevitecnomec"
                               required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">No. Revisión Técnico Mecánica</label>
                        <input type="number" class="form-control" name="numrevitecnomec" id="numrevitecnomec" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Fecha Vencimiento SOAT</label>
                        <input type="date" class="form-control" name="fechavencisoat" id="fechavencisoat" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">No. SOAT</label>
                        <input type="text" class="form-control" name="numsoat" id="numsoat" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Asignaciones disponibles</label>
                        <input type="number" class="form-control" name="numpasajeros" id="numpasajeros" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Propietario del Vehículo</label>
                        <input type="text" class="form-control" name="propietarioVehiculo" id="propietarioVehiculo"
                               required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">No. Tarjeta de Operación</label>
                        <input type="text" class="form-control" name="numtarjetaope" id="numtarjetaope" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Seguro Contractual</label>
                        <input type="text" class="form-control" name="seguroContractual" id="seguroContractual"
                               required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Seguro Extra Contractual</label>
                        <input type="text" class="form-control" name="seguroExtraContractual"
                               id="seguroExtraContractual" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Tipo de Zona</label>
                        <select class="form-control" name="tipoZona" id="tipoZona" required>
                            <option value="Urbana">Urbana</option>
                            <option value="Rural">Rural</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">No. De Contrato</label>
                        <input type="text" class="form-control" name="numcontrato" id="numcontrato" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="proveedorCond">Proveedor</label>
                    <select name="proveedorCond" id="proveedorCond" class="form-control" required>
                        <option value=""></option>
                    </select>
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
                    <button type="submit" class="btn btn-dark-blue" id="btn-save-vehiculo">Guardar</button>
                    <button type="button" class="btn btn-dark-blue" id="btn-edit-vehiculo">Editar</button>
                    <button type="button" class="btn btn-dark-blue" id="btn-cancel-update-vehiculo">Salir</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        let proveedoresArray
        $.ajax({
            url: 'index.php?router=get-proveedores',
            method: 'GET'
        }).then(function (response) {
            proveedoresArray = response
            $("#proveedorCond").select2({
                data: response,
                placeholder: "Seleccione un proveedor",
                language: 'es',
                theme: 'bootstrap'
            });
            $.ajax({
                url: 'index.php?router=get-vehiculo&id=' + idRoute,
                method: 'GET'
            }).then(function (response) {
                $("#idVehiculo").val(response.id)
                $("#tipoVehiculo").val(response.tipo_vehiculo).attr("disabled","disabled")
                $("#proveedorCond").val(response.id_proveedor).trigger('change').attr("disabled","disabled")
                $("#numcontrato").val(response.numero_contrato).attr("disabled","disabled")
                $("#placaVehiculo").val(response.placa).attr("disabled", "disabled")
                $("#marcaVehiculo").val(response.marca_vehiculo).attr("disabled", "disabled")
                $("#fecharevitecnomec").val(response.fecha_soat).attr("disabled", "disabled")
                $("#numrevitecnomec").val(response.tecnico_mecanica).attr("disabled", "disabled")
                $("#fechavencisoat").val(response.fecha_soat).attr("disabled", "disabled")
                $("#numsoat").val(response.soat).attr("disabled", "disabled")
                $("#numpasajeros").val(response.num_pasajeros).attr("disabled", "disabled")
                $("#propietarioVehiculo").val(response.propietario).attr("disabled", "disabled")
                $("#numtarjetaope").val(response.tarjeta_operacion).attr("disabled", "disabled")
                $("#seguroContractual").val(response.seguro_contractual).attr("disabled", "disabled")
                $("#seguroExtraContractual").val(response.seguro_extracontractual).attr("disabled", "disabled")
                $("#tipoZona").val(response.tipo_zona).attr("disabled", "disabled")
            }).catch(function (error) {
                alert(error)
            })
        })


        $("#btn-save-vehiculo, #btn-cancel-update-vehiculo").hide()

        $("#btn-edit-vehiculo").click(function () {
            enabledFieldsVehiculo()
            $("#btn-save-vehiculo, #btn-cancel-update-vehiculo").show()
            $(this).hide()
        })

        $("#btn-cancel-update-vehiculo").click(function () {
            $("#btn-save-vehiculo, #btn-cancel-update-vehiculo").hide()
            $("#btn-edit-vehiculo").show()
            disabledFieldsVehiculo()
        })


        $("#proveedorCond").change(function (e) {
            let arLength = proveedoresArray.length
            for(let i = 0; i < arLength; i++) {
                if (proveedoresArray[i].id = $(this).val()){
                    $("#numcontrato").val(proveedoresArray[i].numero_contrato)
                    break
                }
            }
        })


        $("#formVehiculo").submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: 'index.php?router=update-vehiculo',
                method: 'POST',
                data: $(this).serialize()
            }).then(function (response) {
                if (!response.success) {
                    $("#alert-error").text("No se ha podido actualizar el vehiculo").show("slow", function () {
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
                disabledFieldsVehiculo()
                $("#btn-edit-vehiculo").show()
                $("#btn-save-vehiculo, #btn-cancel-update-vehiculo").hide()
            }).catch(function (error) {
                alert(error)
            })
            $("#btn-save-vehiculo").show()
        });

        function enabledFieldsVehiculo() {
            $("#tipoVehiculo").removeAttr("disabled")
            $("#proveedorCond").removeAttr("disabled")
            $("#placaVehiculo").removeAttr("disabled")
            $("#marcaVehiculo").removeAttr("disabled")
            $("#fecharevitecnomec").removeAttr("disabled")
            $("#numrevitecnomec").removeAttr("disabled")
            $("#fechavencisoat").removeAttr("disabled")
            $("#numsoat").removeAttr("disabled")
            $("#numpasajeros").removeAttr("disabled")
            $("#propietarioVehiculo").removeAttr("disabled")
            $("#numtarjetaope").removeAttr("disabled")
            $("#seguroContractual").removeAttr("disabled")
            $("#seguroExtraContractual").removeAttr("disabled")
            $("#tipoZona").removeAttr("disabled")
        }

        function disabledFieldsVehiculo() {
            $("#tipoVehiculo").attr("disabled", "disabled")
            $("#proveedorCond").attr("disabled", "disabled")
            $("#placaVehiculo").attr("disabled", "disabled")
            $("#marcaVehiculo").attr("disabled", "disabled")
            $("#fecharevitecnomec").attr("disabled", "disabled")
            $("#numrevitecnomec").attr("disabled", "disabled")
            $("#fechavencisoat").attr("disabled", "disabled")
            $("#numsoat").attr("disabled", "disabled")
            $("#numpasajeros").attr("disabled", "disabled")
            $("#propietarioVehiculo").attr("disabled", "disabled")
            $("#numtarjetaope").attr("disabled", "disabled")
            $("#seguroContractual").attr("disabled", "disabled")
            $("#seguroExtraContractual").attr("disabled", "disabled")
            $("#tipoZona").attr("disabled", "disabled")
        }
    })
</script>