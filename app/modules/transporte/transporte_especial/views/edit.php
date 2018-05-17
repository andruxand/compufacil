<div class="card border-dark-blue" id="card-route">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <span id="nomRuta" class="mr-2"><b>Nombre de ruta:</b> </span>
                <span id="operador" class="mr-2"><b>Operador:</b> </span>
                <span id="num-pasajeros-disp" class="mr-2"><b>Cupos Disponibles:</b> </span>
                <span id="num-pasajeros-asig" class="mr-2"><b>Cupos Asignados:</b> </span> <br><br>
                <span id="ieo" class="mr-2"><b>Institución educativa:</b> </span>
            </div>
        </div>
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
<div class="row">
    <div class="col-md-12">
        <a  target="_blank" class="btn btn-dark-blue mt-2" id="btn-print-data-route">
            <span class="oi oi-print"></span>
            Imprimir
        </a>
        <button type="button" class="btn btn-dark-blue mt-2" id="btn-exit-data-route">
            <span class="oi oi-x"></span>
            Salir
        </button>
    </div>
</div>
<!-- Bloque de toda la información -->
<script>
    $(document).ready(function () {
        $("#card-route").hide();

        $.ajax({
            url: 'index.php?router=get-data-route&id=' + idRoute,
            method: 'GET'
        }).then(function (response) {
            $("#nomRuta").append(response.nombre_ruta)
            $("#operador").append(response.nombre_proveedor)
            $("#ieo").append(response.ieo)
            $("#num-pasajeros-disp").append(response.num_pasajeros_disp)
            $("#num-pasajeros-asig").append("<a href='../../transporte/listado_asignacion_transporte/?ruta="+idRoute+"' target='_blank' >"+response.pasajeros+"</a>")
            $("#card-route").show('slow');
            $("#btn-print-data-route").attr("href", "views/print.php?id="+idRoute)
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
            $("#load-modal-paradas").modal('show');
        })

        $("#btn-exit-data-route").click(function (e) {
            $("#container-search").show()
            $("#container").html('')
        })

    })


</script>