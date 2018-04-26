<div class="card" id="card-route">
    <div class="card-body">
        <span id="nomRuta" class="mr-2"><b>Nombre de ruta:</b> </span>
        <span id="operador" class="mr-2"><b>Operador:</b> </span><br><br>
        <span id="ieo" class="mr-2"><b>Institución educativa:</b> </span>
    </div>
</div>

<br>

<!-- Bloque de toda la información -->
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-vehicle" data-toggle="tab" href="#content-vehicle" role="tab"
                   aria-controls="vehicle" aria-selected="true">Vehículo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-conductor" data-toggle="tab" href="#content-conductor" role="tab"
                   aria-controls="conductor" aria-selected="true">Conductor</a>
            </li>
            <li class="nav-item">
                <a href="#content-auxiliar" class="nav-link" id="tab-auxiliar" data-toggle="tab" role="tab"
                   aria-controls="auxiliar" aria-selected="true">Auxiliar</a>
            </li>
            <li class="nav-item">
                <a href="#recorrido" class="nav-link" id="tab-recorrido" data-toggle="tab" role="tab"
                   aria-controls="recorrido" aria-selected="true">Recorrido</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="content-vehicle" role="tabvehicle" aria-labelledby="tab-vehicle">

            </div>
            <div class="tab-pane fade " id="content-conductor" role="tabconductor" aria-labelledby="tab-conductor">

            </div>
            <div class="tab-pane fade" id="content-auxiliar" role="tabauxiliar" aria-labelledby="tab-auxiliar">

            </div>
            <div class="tab-pane fade" id="recorrido" role="tabarecorrido" aria-labelledby="tab-recorrido">
                <fieldset>
                    <legend>
                        Recorrido
                    </legend>
                </fieldset>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-dark-blue" id="btn-crear-parada">Crear parada</button>
                    </div>
                </div>
                <br>
                <div class="table-responsive d-none">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Secuencia</th>
                            <th>Punto</th>
                            <th>Dirección</th>
                            <th>Horario</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody id="bodyTableRecorrido">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bloque de toda la información -->
<script>
    $(document).ready(function () {
        $("#card-route").hide();

        $.ajax({
            url: 'index.php?router=get-data-route&id='+idRoute,
            method: 'GET'
        }).then(function (response) {
            $("#nomRuta").append(response.nombre_ruta)
            $("#operador").append(response.nombre_proveedor)
            $("#ieo").append(response.ieo)
            $("#card-route").show('slow');
        }).catch(function (error) {
            console.log(error)
        })


        $.ajax({
            url: 'views/vehiculo.php',
            method: 'GET'
        }).then(function (response) {
            $("#content-vehicle").html(response);
        }).catch(function (error) {
            alert(error);
        })
    })

    $("#tab-conductor").click(function () {
        if ($("#content-conductor").html().trim() == '') {
            $.ajax({
                url: 'views/conductor.php',
                method: 'GET'
            }).then(function (response) {
                $("#content-conductor").html(response);
            }).catch(function (error) {
                alert(error)
            })
        }
    });

    $("#tab-auxiliar").click(function () {
        if ($("#content-auxiliar").html().trim() == '') {
            $.ajax({
                url: 'views/auxiliar.php',
                method: 'GET'
            }).then(function (response) {
                $("#content-auxiliar").html(response)
            }).catch(function (error) {
                alert(error)
            })
        }
    })


    $("#btn-crear-parada").click(function () {
        $("#id_ruta").val($("#searchRoute").val())
        $("#id_parada").val();
        //cleanFields();
        $("#id_parada").val('')
        $("#nom_parada").val('')
        $("#direccion").val('')
        $("#hora_llegada").val('')
        $("#hora_partida").val('')
        $("#secuencia").val('')
        $("#load-modal").modal('show');
    })
</script>