<fieldset>
    <legend>
        Datos del Conductor
    </legend>
</fieldset>
<div class="row">
    <div class="col-md-12">
        <form action="" id="formConductor">
            <input type="hidden" name="idConductor" id="idConductor">
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
                        <input type="number" class="form-control" name="documentCond" id="documentCond" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Primer Apellido</label>
                        <input type="text" class="form-control" name="primerApellidoCond" id="primerApellidoCond" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Segundo Apellido</label>
                        <input type="text" class="form-control" name="segundoApellidoCond" id="segundoApellidoCond" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Primer Nombre</label>
                        <input type="text" class="form-control" name="primerNombreCond" id="primerNombreCond" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Segundo Nombre</label>
                        <input type="text" class="form-control" name="segundoNombreCond" id="segundoNombreCond" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Dirección de Residencia</label>
                        <input type="text" class="form-control" name="direccionResidenciaCond" id="direccionResidenciaCond" required/>
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
                        <input type="text" class="form-control" name="licenciaConduccion" id="licenciaConduccion" required/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Categoría Autorizada</label>
                        <input type="text" class="form-control" name="categoriaAutorizada" id="categoriaAutorizada" required/>
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
                    <button type="submit" class="btn btn-dark-blue" id="btn-save-conductor">Guardar</button>
                    <button type="button" class="btn btn-dark-blue" id="btn-edit-conductor">Editar</button>
                    <button type="button" class="btn btn-dark-blue" id="btn-cancel-update-conductor">Salir</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $.ajax({
        url: 'index.php?router=get-conductor&id='+idRoute,
        method: 'GET'
    }).then(function (response) {
        $("#idConductor").val(response.id)
        $("#tipoDocumentoCond").val(response.tipodoc_id).attr("disabled", "disabled")
        $("#documentCond").val(response.documento).attr("disabled", "disabled")
        $("#primerApellidoCond").val(response.primerapellido).attr("disabled", "disabled")
        $("#segundoApellidoCond").val(response.segundonombre).attr("disabled", "disabled")
        $("#primerNombreCond").val(response.primernombre).attr("disabled", "disabled")
        $("#segundoNombreCond").val(response.segundonombre).attr("disabled", "disabled")
        $("#direccionResidenciaCond").val(response.direccion).attr("disabled", "disabled")
        $("#numCelularCond").val(response.celular).attr("disabled", "disabled")
        $("#licenciaConduccion").val(response.licencia).attr("disabled", "disabled")
        $("#categoriaAutorizada").val(response.categoria).attr("disabled", "disabled")
        $("#fechavencilince").val(response.fecha_vencimiento).attr("disabled", "disabled")
    }).catch(function (error) {
        alert(error)
    })

    $("#btn-save-conductor, #btn-cancel-update-conductor").hide()

    $("#btn-cancel-update-conductor").click(function () {
        disabaledFieldsConductor()
        $(this).hide()
        $("#btn-save-conductor").hide()
        $("#btn-edit-conductor").show()
    })

    $("#btn-edit-conductor").click(function () {
        $("#btn-cancel-update-conductor, #btn-save-conductor").show()
        enabledFeldsConductor();
        $(this).hide()
    })

    $("#formConductor").submit(function (e) {
        e.preventDefault()
        $.ajax({
            url: 'index.php?router=update-conductor',
            method: 'POST',
            data: $(this).serialize()
        }).then(function (response) {
            if(!response.success){
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
            $("#btn-save-conductor, #btn-cancel-update-conductor").hide()
            $("#btn-edit-conductor").show()
            disabaledFieldsConductor()
        }).catch(function (error) {
            alert(error)
        })
    });

    function disabaledFieldsConductor(){
        $("#tipoDocumentoCond").attr("disabled", "disabled")
        $("#documentCond").attr("disabled", "disabled")
        $("#primerApellidoCond").attr("disabled", "disabled")
        $("#segundoApellidoCond").attr("disabled", "disabled")
        $("#primerNombreCond").attr("disabled", "disabled")
        $("#segundoNombreCond").attr("disabled", "disabled")
        $("#direccionResidenciaCond").attr("disabled", "disabled")
        $("#numCelularCond").attr("disabled", "disabled")
        $("#licenciaConduccion").attr("disabled", "disabled")
        $("#categoriaAutorizada").attr("disabled", "disabled")
        $("#fechavencilince").attr("disabled", "disabled")
    }

    function enabledFeldsConductor() {
        $("#tipoDocumentoCond").removeAttr("disabled")
        $("#documentCond").removeAttr("disabled")
        $("#primerApellidoCond").removeAttr("disabled")
        $("#segundoApellidoCond").removeAttr("disabled")
        $("#primerNombreCond").removeAttr("disabled")
        $("#segundoNombreCond").removeAttr("disabled")
        $("#direccionResidenciaCond").removeAttr("disabled")
        $("#numCelularCond").removeAttr("disabled")
        $("#licenciaConduccion").removeAttr("disabled")
        $("#categoriaAutorizada").removeAttr("disabled")
        $("#fechavencilince").removeAttr("disabled")
    }
</script>