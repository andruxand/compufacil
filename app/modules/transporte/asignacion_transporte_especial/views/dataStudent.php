<div class="row">
    <div class="col-md-12" id="content-info">

    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12" id="content-route">

    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-dark-blue" type="button" id="exit-assign">Salir</button>
    </div>
</div>

<script>
    $(document).ready(function () {

        const temp = function (obj) {
            let naci = new Date(obj.fecha_nacimiento)
            let today = new Date()
            let edad = today.getFullYear() - naci.getFullYear();

            return `<div class="row">
                    <div class="col-md-12 text-center">
                      <h3>Asignación de ruta para: <b></b></h3>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="documento">Documento</label>
                        <input type="text" class="form-control" value="${obj.doc}" readonly />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="ieo">Institución educativa</label>
                        <input type="text" class="form-control" value="${obj.institucion}" readonly />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="sede">Sede</label>
                        <input type="text" class="form-control" value="${obj.sede}" readonly />
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="form-group">
                        <label for="grado">Grado</label>
                        <input type="text" class="form-control" value="${obj.grado_cod}" readonly />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="edad">Edad</label>
                        <input type="text" class="form-control" value="${edad}" readonly />
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="Sexo">Sexo</label>
                        <input type="text" class="form-control" value="${obj.genero}" readonly />
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="jornada">Jornada</label>
                        <input type="text" class="form-control" value="${obj.jornada}" readonly />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="direccion">Direccion</label>
                        <input type="text" class="form-control" value="${(obj.direccion ? obj.direccion : 'Sin asignar')}" readonly />
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="comuna">Comuna</label>
                        <input type="text" class="form-control" value="${obj.comuna}" readonly />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form group">
                        <label for="barrio">Barrio</label>
                        <input type="text" class="form-control" value="${obj.barrio}" readonly />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form group">
                        <label for="zona">Zona</label>
                        <select class="form-control" name="zona" id="tipoZona">
                            <option value="Urbana">Urbana</option>
                            <option value="Rural">Rural</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form group">
                        <label for="caracterizacion">Caracterización</label>
                        <select class="form-control" name="caracterizacion" id="caracterizacion">
                            <option value="">Seleccione caracterización</option>
                            <option value="Ninguna">Ninguna</option>
                            <option value="Distancia">Distancia</option>
                            <option value="Discapacidad">Discapacidad</option>
                            <option value="PJarillon">Plan Jarillón</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form group">
                         <button type="button" class="btn btn-primary btn-block mt-4" id="searchRoutes">Buscar Ruta</button>
                      </div>
                    </div>
                  </div>`
        }

        if (idStudent) {
            $.ajax({
                url: 'index.php?router=get-estudiante&id=' + idStudent,
                method: 'GET',
                beforeSend: function () {
                    $("#content-info").html(`<i class="fa fa-refresh fa-spin fa-5x"></i>`)
                }
            }).then(function (response) {
                $("#content-info").html(temp(response));
                $("#searchRoutes").click(function (e) {
                    $.ajax({
                        url: 'views/dataRoutes.php',
                        method: 'POST',
                        data: {zona: $("#tipoZona").val()}
                    }).then(function (response) {
                        $("#content-route").html(response)
                    })
                })
            })
        }
    })
</script>