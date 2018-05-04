<fieldset>
    <legend>
        Carga masiva de vehiculos
    </legend>
</fieldset>
<form name="formLoadVehiculo" id="formLoadVehiculo">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="lVehiculo"></label>
                <input type="file" class="form-control-file load" name="lVehiculo" id="lVehiculo" accept=".csv"
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
                <li>Debe tener la siguiente estructura (documento; primernombre; segundonombre; primerapellido;
                    segundoapellido; licencia)
                </li>
                <li>El archivo puede tener un tamaño máximo de 2MB</li>
            </ul>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $("#formLoadVehiculo").submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $(".load").attr("disabled", "disabled")
            $.ajax({
                url: 'index.php?router=load-vehiculos',
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