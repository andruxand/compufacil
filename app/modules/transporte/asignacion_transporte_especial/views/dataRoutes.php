<div class="table-responsive">
    <table class="table table-stripped">
        <thead>
        <th></th>
        <th>Ruta</th>
        <th>Zona</th>
        <th>Jornada</th>
        <th>No. de Pasajeros</th>
        </thead>
        <tbody id="body-table-routes">

        </tbody>
    </table>
</div>
<br>
<div class="row">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-primary" id="asignar-ruta" style="display: none;">Asignar ruta</button>
    </div>
</div>
<script>
    $(document).ready(function () {

        const row = function (obj) {
            return `<tr>
                        <td><input type="radio" name="idRuta" value="${obj.id}" /> </td>
                        <td>${obj.nombre_ruta}</td>
                        <td>${obj.zona}</td>
                        <td></td>
                        <td>${obj.numPasajeros}</td>
                    </tr>`;
        }

        $.ajax({
            url: 'index.php?router=get-routes',
            method: 'POST',
            data: {zona: $("#tipoZona").val()}
        }).then(function (response) {
            let resLength = response.length;
            $("#body-table-routes").html('')
            $("#asignar-ruta").show()
            if (resLength > 0) {
                for (let i = 0; i < resLength; i++) {
                    $("#body-table-routes").append(row(response[i]))
                }
            }else {
                $("#body-table-routes").html("<h2>No se encontraron rutas</h2>")
            }

        })


        $("#asignar-ruta").click(function (e) {
            if (typeof $('input[name=idRuta]:checked').val() == 'undefined') {
                alert("Debe escoger una ruta para hacer la asignación")
            } else if($("#caracterizacion").val() == ''){
                alert("Debe escoger una caracterización")
            }else {
                $.ajax({
                    url: 'index.php?router=asignar-ruta',
                    method: 'POST',
                    data: {
                        idStudent: idStudent,
                        idRuta: $('input[name=idRuta]:checked').val(),
                        caracterizacion: $("#caracterizacion").val()
                    }
                }).then(function (response) {
                    if (response.success) {
                        $("#container").html('')
                        $("#container-search").show();
                        notificationSuccess(response.message);
                    } else {
                        $("#container").html('')
                        $("#container-search").show();
                        notificationError(response.message)
                    }
                }).catch(function (error) {
                    $("#container").html('')
                    $("#container-search, #list-students").show();
                    notificationError(error.message)
                })
            }
        })
    })
</script>