$(document).ready(function () {
    let idEstu;
    $("#formSearchStudents").submit(function (e) {
        e.preventDefault();

        let valid = 0
        $("#formSearchStudents :input").each(function (e) {
            if (this.type == 'text' || this.type == 'number') {
                if ($(this).val() != '') {
                    valid++
                }
            }
        })

        if (!valid) {
            alert("Debe usar al menos uno de los filtros para hacer la búsqueda")
            return false
        }

        $('#results').DataTable().destroy();

        let dataForm = {
            documento: $("#documento").val(),
            nombre1: $("#primer-nombre").val(),
            nombre2: $("#segundo-nombre").val(),
            apellido1: $("#primer-apellido").val(),
            apellido2: $("#segundo-apellido").val(),
            vigencia: $("#vigencia").val()
        }

        $('#fullpage-loader').fadeIn(200);

        $('#results').DataTable( {
            "processing": true,
            "serverSide": true,
            "searching": false,
            dom: "Bfrtip",
            columnDefs: [
                {
                    targets: 1,
                    className: "noVis"
                }
            ],
            buttons: [
                { extend: "print", text: "Vista Impresión", exportOptions: { columns: ':visible' } },
                { extend: "colvis", columns: ":not(.noVis)", text: "Mostrar/Ocultar Columnas" },
                { extend: "excel", text: "Excel", exportOptions: { columns: ':visible' } },
                { extend: "csv", text: "CSV", exportOptions: { columns: ':visible' } },
            ],
            "ajax": {
                url: "ajax.php?router=listar-estudiantes",
                type: "POST",
                data: dataForm,
                error: function(e){
                    $('#loader-error').fadeIn(200);
                    $('#loader-icon').removeClass('fa-spin').addClass('text-danger');
                },
                complete: function (){
                    $(".showDetail").on('click', function(e){
                        $.ajax({
                            url: 'detail.php?id='+$(this).attr('data-id'),
                            method: 'GET'
                        }).then(function (response) {
                            $("#modal-body").html(response);
                            $("#load-modal").modal('show');
                        })

                    })
                },
                dataSrc: function(json){
                    $('#fullpage-loader').fadeOut(200);
                    return json.data;
                }
            },
            "columns": [
                { "data": "documento" },
                { "data": "nombre" },
                { "data": "grado" },
                { "data": "institucion" },
                { "data": "sede" },
                { "data": "jornada" },
                { "data": "acciones" },
            ],
            "language": {
                "emptyTable":			"<div class='alert alert-warning alert-dismissible fade show animated bounceInDown' role='alert'>" +
                "<span class='oi oi-warning' title='icon name' aria-hidden='true'></span>" +
                "Lo sentimos!. No se encontraron registros que cumplan los criterios de búsqueda especificados.</div>",
                "info":		   			"Del _START_ al _END_ de _TOTAL_ ",
                "infoEmpty":			"Mostrando 0 registros de un total de 0.",
                "infoFiltered":			"(filtrados de un total de _MAX_ registros)",
                "infoPostFix":			"(actualizados)",
                "lengthMenu":			"Mostrar _MENU_ registros",
                "loadingRecords":		"Cargando...",
                "processing":			"Cargando...",
                "search":				"Buscar:",
                "zeroRecords":			"No se han encontrado coincidencias.",
                "paginate": {
                    "first":			"Primera",
                    "last":				"Última",
                    "next":				"Siguiente",
                    "previous":			"Anterior"
                },
                "aria": {
                    "sortAscending":	"Ordenación ascendente",
                    "sortDescending":	"Ordenación descendente"
                }
            },
        } );
    })
})