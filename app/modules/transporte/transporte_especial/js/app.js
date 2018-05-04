let idRoute

function notificationError(message) {
    $("#alert-error").text(message).show("slow", function () {
        setTimeout(function () {
            $("#alert-error").hide('slow');
        }, 5000)
    });
}

function notificationSuccess(message) {
    $("#alert-success").text(message).show("slow", function () {
        setTimeout(function () {
            $("#alert-success").hide('slow');
        }, 5000)
    });
}
$(document).ready(function () {
    $("#searchRoute").select2({
        ajax: {
            url: 'index.php',
            dataType: 'json',
            data: function (params) {
                const query = {
                    router: 'search-route',
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

    $("#hora_llegada, #hora_partida").timepicker({
        icons: {
            up: 'oi oi-chevron-top',
            down: 'oi oi-chevron-bottom'
        },
        minuteStep: 1,
        //defaultTime: false
    });

    $("#btn-search").click(function (e) {
        e.preventDefault()
        idRoute = $("#searchRoute").val()
        if (idRoute == null) {
            alert("Debe seleccionar una ruta para buscar")
            return false
        }

        $.ajax({
            url: 'views/edit.php',
            method: 'GET'
        }).then(function (response) {
            $("#container").html(response)
            getRecorridos(idRoute)
            $("#container-search").hide()
        }).catch(function (error) {
            console.log(error)
        })
    });



    $("#formRecorrido").submit(function (e) {
        e.preventDefault()
        $.ajax({
            url: 'index.php?router=guardar-recorrido',
            type: 'POST',
            dataType: 'json',
            data: $("#formRecorrido").serialize(),
            success: function (response) {
                if (!response.success) {
                    $("#alert-error").text(response.message).show("slow", function () {
                        setTimeout(function () {
                            $("#alert-error").hide('slow');
                        }, 5000)
                    });
                    $("#load-modal").modal('hide');
                    return false;
                }

                getRecorridos($("#searchRoute").val())
                $("#load-modal").modal('hide');
                cleanFields();
                $("#alert-success").text(response.message).show("slow", function () {
                    setTimeout(function () {
                        $("#alert-success").hide('slow');
                    }, 5000)
                });
            },
            error: function (xhr, status, error) {
                $("#alert-error").text(error).show("slow", function () {
                    setTimeout(function () {
                        $("#alert-error").hide('slow');
                    }, 5000)
                });
            }
        });
    });

    $("#btn-create-ruta").click(function (e) {
        $.ajax({
            url: 'views/create.php',
            method: 'GET',
            success: function (response) {
                $("#container").html(response)
            },
            error: function (xhr, status, error) {
                console.log(error)
            }
        })
    })

    if (!$("#searchRoute").val()) {
        $("#btn-crear-parada").hide();
    }

    $("#btn-load-conductores").click(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'views/loadConductor.php',
            method: 'GET'
        }).then(function (response) {
            $("#container").html(response);
        })
    })

    function cleanFields() {
        $("#id_parada").val('')
        $("#nom_parada").val('')
        $("#direccion").val('')
        $("#hora_llegada").val('')
        $("#hora_partida").val('')
        $("#secuencia").val('')
    }

    function getRecorridos($id) {
        $.ajax({
            url: 'index.php?router=get-recorridos&id=' + $id,
            dataType: 'json',
            success: function (response) {
                if (response) {
                    var len = response.length;
                    var html = "";
                    if (len > 0) {
                        for (let i = 0; i < len; i++) {
                            html += "<tr>" +
                                "<td>" +
                                response[i].secuencia +
                                "</td>" +
                                "<td>" +
                                response[i].nombre_parada +
                                "</td>" +
                                "<td>" +
                                response[i].direccion +
                                "</td>" +
                                "<td>" +
                                response[i].hora_llegada + " hasta " + response[i].hora_partida +
                                "</td>" +
                                "<td>" +
                                "<button type='button' class='btn btn-info btn-edit' " +
                                "data-id='" + response[i].id + "' " +
                                " id='btn-edit'>" +
                                "<span class='oi oi-pencil'></span>" +
                                "</button>" +
                                "<button type='button' class='btn btn-danger btn-delete ml-1' " +
                                " data-id='" + response[i].id + "' " +
                                "id='btn-delete'>" +
                                "<span class='oi oi-trash'></span>" +
                                "</button>" +
                                "</td>" +
                                "</tr>";
                        }

                        $("#bodyTableRecorrido").html($.parseHTML(html));
                        $(".table-responsive").removeClass('d-none').addClass('animated fadeIn');
                        $("#btn-crear-parada").show();
                        $(".btn-edit").click(function (e) {
                            getParada(this);
                        });
                        $(".btn-delete").click(function (e) {
                            deleteParada(this)
                        });
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log(error)
            }
        });
    }

    function getParada(e) {
        $.ajax({
            url: 'index.php?router=get-recorrido&id=' + $(e).attr('data-id'),
            dataType: 'json',
            success: function (response) {
                $("#id_parada").val(response.id)
                $("#nom_parada").val(response.nombre_parada)
                $("#direccion").val(response.direccion)
                //$("#hora_llegada").val(response.hora_llegada)
                $("#hora_llegada").timepicker('setTime', response.hora_llegada)
                //$("#hora_partida").val(response.hora_partida)
                $("#hora_partida").timepicker('setTime', response.hora_partida)
                $("#secuencia").val(response.secuencia)
                $("#id_ruta").val($("#searchRoute").val())
            },
            error: function (xhr, status, error) {
                console.log(error)
            }
        });

        $(e).attr('data-id')
        $("#load-modal").modal('show');
    }

    function deleteParada(e) {
        if (confirm("¿Está seguro de eliminar la parada?")) {
            var id_parada = $(e).attr('data-id');

            $.ajax({
                url: 'index.php?router=delete-parada&id=' + id_parada,
                dataType: 'json',
                type: 'DELETE',
                success: function (response) {
                    getRecorridos($("#searchRoute").val())
                    $("#alert-success").text(response.message).show("slow", function () {
                        setTimeout(function () {
                            $("#alert-success").hide('slow');
                        }, 5000)
                    });
                },
                error: function (xhr, status, error) {
                    $("#alert-error").text(error).show("slow", function () {
                        setTimeout(function () {
                            $("#alert-error").hide('slow');
                        }, 5000)
                    });
                }
            })
        }
    }

});