<fieldset>
    <legend>
        Datos del Auxiliar
    </legend>
</fieldset>
<div class="row">
    <div class="col-md-12">
        <form action="" id="formAuxiliar">
            <input type="hidden" name="idAuxiliar" id="idAuxiliar">
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
                        <input type="number" class="form-control" name="documentoAux" id="documentoAux" required/>
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
                        <input type="text" class="form-control" name="segundoApellidoAux" id="segundoApellidoAux" maxlength="45"/>
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
                        <input type="text" class="form-control" name="segundoNombreAux" id="segundoNombreAux" maxlength="45"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Dirección de Residencia</label>
                        <input type="text" class="form-control" name="direccionResidenciaAux" id="direccionResidenciaAux" required maxlength="100"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">No. de Celular</label>
                        <input type="text" class="form-control" name="numCelularAux" id="numCelularAux" maxlength="10"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Formación Académica</label>
                        <input type="text" class="form-control" name="formacionAcadeAux" id="formacionAcadeAux" maxlength="100"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button class="btn btn-dark-blue mb-2" type="submit" id="btn-save-auxiliar">Guardar</button>
                    <button class="btn btn-dark-blue mb-2" type="button" id="btn-edit-auxiliar">Editar</button>
                    <button class="btn btn-dark-blue mb-2" type="button" id="btn-cancel-update-auxiliar">salir</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $.ajax({
        url: 'index.php?router=get-auxiliar&id=' + idRoute,
        method: 'GET'
    }).then(function (response) {
        $("#idAuxiliar").val(response.id)
        $("#tipoDocumentoAux").val(response.tipodoc_id).attr("disabled", "disabled")
        $("#documentoAux").val(response.documento).attr("disabled", "disabled")
        $("#primerApellidoAux").val(response.primerapellido).attr("disabled", "disabled")
        $("#segundoApellidoAux").val(response.segundoapellido).attr("disabled", "disabled")
        $("#primerNombreAux").val(response.primernombre).attr("disabled", "disabled")
        $("#segundoNombreAux").val(response.segundonombre).attr("disabled", "disabled")
        $("#direccionResidenciaAux").val(response.direccion).attr("disabled", "disabled")
        $("#numCelularAux").val(response.celular).attr("disabled", "disabled")
        $("#formacionAcadeAux").val(response.formacion).attr("disabled", "disabled")
    }).catch(function (error) {
        alert(error)
    })

    $("#btn-save-auxiliar, #btn-cancel-update-auxiliar").hide()
    $("#btn-edit-auxiliar").click(function () {
        $("#btn-save-auxiliar, #btn-cancel-update-auxiliar").show();
        $(this).hide()
        enabledFieldsAux()
    })
    $("#btn-cancel-update-auxiliar").click(function () {
        $("#btn-save-auxiliar, #btn-cancel-update-auxiliar").hide()
        $("#btn-edit-auxiliar").show()
        disabledFieldsAux()
    })

    $("#formAuxiliar").submit(function (e) {
        e.preventDefault()
        $.ajax({
            url: 'index.php?router=update-auxiliar',
            method: 'POST',
            data: $(this).serialize()
        }).then(function (response) {
            if (!response.success) {
                $("#alert-error").text("No se ha podido actualizar el conductor").show("slow", function () {
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

            $("#btn-save-auxiliar, #btn-cancel-update-auxiliar").hide()
            $("#btn-edit-auxiliar").show()
            disabledFieldsAux()

        }).catch(function (error) {
            alert(error);
        })
    })

    function disabledFieldsAux() {
        $("#tipoDocumentoAux").attr("disabled", "disabled")
        $("#documentoAux").attr("disabled", "disabled")
        $("#primerApellidoAux").attr("disabled", "disabled")
        $("#segundoApellidoAux").attr("disabled", "disabled")
        $("#primerNombreAux").attr("disabled", "disabled")
        $("#segundoNombreAux").attr("disabled", "disabled")
        $("#direccionResidenciaAux").attr("disabled", "disabled")
        $("#numCelularAux").attr("disabled", "disabled")
        $("#formacionAcadeAux").attr("disabled", "disabled")
    }

    function enabledFieldsAux() {
        $("#tipoDocumentoAux").removeAttr("disabled")
        $("#documentoAux").removeAttr("disabled")
        $("#primerApellidoAux").removeAttr("disabled")
        $("#segundoApellidoAux").removeAttr("disabled")
        $("#primerNombreAux").removeAttr("disabled")
        $("#segundoNombreAux").removeAttr("disabled")
        $("#direccionResidenciaAux").removeAttr("disabled")
        $("#numCelularAux").removeAttr("disabled")
        $("#formacionAcadeAux").removeAttr("disabled")
    }
</script>