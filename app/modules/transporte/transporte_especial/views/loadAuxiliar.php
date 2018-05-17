<fieldset>
  <legend>
    Carga masiva de auxiliares
  </legend>
</fieldset>
<form name="formLoadAuxiliar" id="formLoadAuxiliar">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="lAuxiliar"></label>
        <input type="file" class="form-control-file load" name="lAuxiliar" id="lAuxiliar" accept=".csv"
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
        <li>Debe tener la siguiente estructura (tipodoc, documento, primernombre, segundonombre, primerapellido, segundoapellido, direccion, celular, formacion)
        </li>
        <li>Debe tener en cuenta que el TIPO DE DOCUMENTO de auxiliar de cada registro del CSV debe existir como tipos de documento en el sistema previamente</li>
        <li>El archivo puede tener un tamaño máximo de 2MB</li>
      </ul>
    </div>
  </div>
</form>
<script>
    $(document).ready(function () {
        $("#formLoadAuxiliar").submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $(".load").attr("disabled", "disabled")
            $.ajax({
                url: 'index.php?router=load-auxiliares',
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