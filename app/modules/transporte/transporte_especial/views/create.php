<form action="" id="newRoute">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="vigencia">Vigencia</label>
                <select name="vigencia" id="vigencia" class="form-control" required>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2010</option>
                    <option value="2020">2020</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="nombreRuta">Nombre de ruta</label>
                <input type="text" name="nombreRuta" id="nombreRuta" class="form-control" required/>
            </div>
        </div>
        <div class="col-md-3">
            <label for="Proveedor">Proveedor</label>
            <select name="proveedor" id="proveedor" class="form-control" required>
                <option value=""></option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="ieo">Institución educativa</label>
            <select name="ieo" id="ieo" class="form-control" required>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label for="vehiculo">Vehículo</label>
            <select name="vehiculo" id="vehiculo" class="form-control" required>
                <option value=""></option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="conductor">Conductor</label>
            <select name="conductor" id="conductor" class="form-control" required>
                <option value=""></option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="auxiliar">Auxiliar</label>
            <select name="auxiliar" id="auxiliar" class="form-control" required>
                <option value=""></option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="numPasajero">Número de pasajeros</label>
            <input type="number" name="numPasajeros" id="numPasajeros" class="form-control" required/>
        </div>
    </div>
    <h3>Paradas</h3>
    <div id="paradas">

    </div>
    <div class="row">
        <div class="col-md-6">
            <button type="button" class="btn btn-dark-blue" id="btn-add-parada">Agregar Parada</button>
        </div>
        <div class="col-md-6 text-right">
            <button type="submit" class="btn btn-dark-blue" id="btn-crear-ruta">Guardar Ruta</button>
        </div>
    </div>
</form>


<script>
    $(document).ready(function () {

        const temp = function (id) {
            return `<div class="row" data-id="${id}">
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" name="parada[]" class="form-control" placeholder="Nombre de ruta" required/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" name="direccion[]" class="form-control" placeholder="Dirección" required/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="number" name="secuencia[]" class="form-control" placeholder="secuencia" required/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" name="hora_llegada[]" class="form-control time" placeholder="Hora llegada"
                           required/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" name="hora_partida[]" class="form-control time" placeholder="Hora partida"
                           required/>
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-dark-blue mt-1 btn-clear" data-id="${id}"><span class="oi oi-circle-x"></span></button>
            </div>
        </div>`
        }

        $(".time").timepicker({
            icons: {
                up: 'oi oi-chevron-top',
                down: 'oi oi-chevron-bottom'
            },
            minuteStep: 1,
            defaultTime: false
        })

        $.ajax({
            url: 'index.php?router=get-proveedores',
            method: 'GET'
        }).then(function (response) {
            $("#proveedor").select2({
                data: response,
                placeholder: "Seleccione un proveedor",
                language: 'es'
            });
        })

        $("#ieo").select2({
            ajax: {
                url: 'index.php',
                dataType: 'json',
                data: function (params) {
                    const query = {
                        router: 'get-ieo',
                        search: params.term
                    };

                    return query;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            },
            placeholder: 'Búsqueda de rutas',
            minimumInputLength: 3,
            language: 'es'
        });

        $.ajax({
            url: 'index.php?router=get-vehiculos',
            method: 'GET'
        }).then(function (response) {
            $("#vehiculo").select2({
                data: response,
                placeholder: 'Seleccione un vehículo',
                language: 'es'
            })
        })

        $.ajax({
            url: 'index.php?router=get-conductores',
            method: 'GET'
        }).then(function (response) {
            $("#conductor").select2({
                data: response,
                placeholder: 'Seleccione un conductor',
                language: 'es'
            })
        })

        $.ajax({
            url: 'index.php?router=get-auxiliares',
            method: 'GET'
        }).then(function (response) {
            $("#auxiliar").select2({
                data: response,
                placeholder: 'Seleccione un auxiliar',
                language: 'es'
            })
        })

        let idParada = 0
        let template = $("#paradas").append(temp(idParada))
        $(".time").timepicker({
            icons: {
                up: 'oi oi-chevron-top',
                down: 'oi oi-chevron-bottom'
            },
            minuteStep: 1,
            defaultTime: false
        })

        $("#btn-add-parada").click(function (e) {
            idParada++
            $("#paradas").append(temp(idParada))
            $(".time").timepicker({
                icons: {
                    up: 'oi oi-chevron-top',
                    down: 'oi oi-chevron-bottom'
                },
                minuteStep: 1,
                defaultTime: false
            })
            $(".btn-clear").click(function (e) {
                $("div[data-id='" + $(this).attr("data-id") + "']").remove();
                console.log($("#newRoute").serialize())
            });
        })

        $("#newRoute").submit(function (e) {
            $.ajax({
                url: 'index.php?router=create-ruta',
                method: 'POST',
                data: $("#newRoute").serialize()
            }).then(function (response) {
                $("#alert-success").text(response.message).show("slow", function () {
                    setTimeout(function () {
                        $("#alert-success").hide('slow');
                    }, 5000)
                });
                $("#container").html('');
            }).catch(function (error) {
                $("#alert-error").text(response.message).show("slow", function () {
                    setTimeout(function () {
                        $("#alert-success").hide('slow');
                    }, 5000)
                });
            })
            e.preventDefault();
        })


    })
</script>