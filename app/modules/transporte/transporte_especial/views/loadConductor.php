<fieldset>
    <legend>
        Carga masiva de conductores
    </legend>
</fieldset>
<form name="formLoadConductor" id="formLoadConductor">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="lConductor"></label>
                <input type="file" class="form-control-file load" name="lConductor" id="lConductor" accept=".csv"
                       required/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary load">Cargar</button>
            </div>
        </div>
        <div class="col-md-6">
            <h4>Recomendaciones</h4>
            <ul>
                <li>Debe ser un archivo separado por punto y coma (.csv)</li>
                <li>Debe tener la siguiente estructura (documento; primernombre; segundonombre; primerapellido; segundoapellido; licencia)</li>
                <li>El archivo puede tener un tamaño máximo de 2MB</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <i class="fa fa-refresh fa-spin fa-5x ml-4 mt-1 d-none" id="loader-load-conductor"></i>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $("#formLoadConductor").submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $(".load").attr("disabled", "disabled")
            $.ajax({
                url: 'index.php?router=load-conductores',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $("#loader-load-conductor").removeClass("d-none")
                }
            }).then(function (response) {
                if (response.success) {
                    $("#loader-load-conductor").addClass("d-none")
                    $("#container").html('')
                    notificationSuccess(response.message)
                    return false;
                }

                $("#loader-load-conductor").addClass("d-none")
                $("#container").html('')
                notificationError(response.message);
            }).catch(function (error) {
                notificationError(error.message);
            })
        })
    })
</script>