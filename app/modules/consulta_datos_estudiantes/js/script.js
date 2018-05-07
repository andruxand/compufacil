function consulta_datos_estudiantes(nui){

	$(".alert").hide();

	$.ajax({
        url: 'ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {action: 'consulta_datos_estudiantes', id: nui},
    })
    .done(function(data) {
        if ( data.success ) {
	        console.log(data);
	        $('#tipodoc').text(data.tipodoc);
	        $('#nro_identificacion').text(data.documento);
	        $('#nombre1').text(data.nombre1);
	        $('#nombre2').text(data.nombre2);
	        $('#apellido1').text(data.apellido1);
	        $('#apellido2').text(data.apellido2);
	        $('#genero').text(data.genero);

	        $('#infoNombre').text(data.nombre1 + ' ' + data.nombre2 + ' ' + data.apellido1 + ' ' + data.apellido2);
	        $('#infoTipoIdentificacion').text(data.tipodoc);
	        $('#infoIdentificacion').text(data.documento);

	        $('#tipoDocumentoAcu').text(data.tipoDocumentoAcu);
	        $('#numDocumentoAcu').text(data.numDocumentoAcu);
	        $('#nombresAcu').text(data.nombresAcu);
	        $('#apellidosAcu').text(data.apellidosAcu);
	        $('#correoAcu').text(data.correoAcu);
	        $('#celularAcu').text(data.celularAcu);
	        $('#parentescoAcu').text(data.parentescoAcu);

	        $('#institucion_info').text(data.institucion);
	        $('#sede').text(data.sede);
	        $('#jornada').text(data.jornada);
	        $('#grado_info').text(data.grado);
	        $('#grupo_info').text(data.grupo);
	        $('#aniolectivo').text(data.anio_lectivo);

	    }else{
	        console.log( "La solicitud NO se ha completado correctamente." );
	        $('#info-msg').text(data.message);
	        $('.alert-info').show();
	    }

    })
    .fail(function(XMLHttpRequest, textStatus, errorThrown) {
	    if ( console && console.log ) {
	        console.log( "La solicitud a fallado: " +  errorThrown);
	    }    
	});

}


$(document).ready(function() {

	var institucion = $('#institucion');

	//institucion.select2();

	institucion.select2({
        ajax: {
            url: 'combox.php',
            dataType: 'json',
            data: function (params) {
                const query = {
                    action: 'intituciones',
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
        placeholder: 'DANE, Institución o Sede',
        minimumInputLength: 6,
        language: 'es'
    });


	$('#grado').select2();

	//CargaResutlados('no');

	function CargaResutlados(is_custom_search, institucion = '', grado = '', grupo= '', vigencia = ''){

		var dataTable = $('#results').DataTable( {
			"processing": true,
			"serverSide": true,
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
			//"sort": false,
   			//"order" : [],
	        "ajax": {
	        	url: "ajax.php",
	        	type: "post",
	        	data: { action: 'listar_registros', is_custom_search: is_custom_search, institucion: institucion, grado: grado, grupo: grupo, vigencia: vigencia },
	        	error: function(e){  // error handling
	        		$('#loader-error').fadeIn(200);
    				$('#loader-icon').removeClass('fa-spin').addClass('text-danger');
					console.log(e);				
				},
				dataSrc: function(json){
					$('#fullpage-loader').fadeOut(200);
					console.log(json);
					return json.data;
				}
	        },
	        "columns": [
	            { "data": "tipodoc" },
	            { "data": "documento" },
	            { "data": "apellido1" },
	            { "data": "apellido2" },
	            { "data": "nombre1" },
	            { "data": "nombre2" },
	            { "data": "grado" },
	            { "data": "grupo" },
	            { "data": "institucion" },
	            { "data": "sede" },
	            { "data": "jornada" },
	            { "data": "lectivo" },
	            { "data": "acciones" }
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
					"searchPlaceholder":	"Búsqueda Global",
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

	}

	$('#buscar').click(function(){

		if( $('#grado').val() !== '' || $('#grupo').val() !== '' || $('#vigencia').val() !== '' || institucion.val() !== ''){
		
			$('#fullpage-loader').fadeIn(200);
			$('#results').DataTable().destroy();
			CargaResutlados('yes', institucion.val(), $('#grado').val(), $('#grupo').val(), $('#vigencia').val());

		}else{

			alert('Por favor ingrese datos de búsqueda');

		}

	});

	$('#reset').click(function(){
		
		$("#results").DataTable().destroy();
		$('#grado').val('').trigger('change.select2');;
		$('#grupo').val('');
		$('#vigencia').val('');
		//CargaResutlados('no');
		institucion.val('').trigger('change.select2');

	});

	$("#btn-print-detail").click(function (e) {
            //$("#printArea").append("<h2>Datos de estudiante</h2>")
            $("#printArea").append($("#home").html())
            $("#printArea").append("<br>")
            //$("#printArea").append("<h2>Datos de acudiente</h2>")
            $("#printArea").append($("#profile").html())
            $("#printArea").append("<br>")
            //$("#printArea").append("<h2>Transporte MIO</h2>")
            $("#printArea").append($("#contact").html())
            $("#printArea").append("<br>")
            $("#printArea").printArea({
                mode: "iframe",
                popClose: true,
                popTitle: "Impresión Datos Del Estudiante",
                popHt: 820,
                popWd: 1024,
                popX: 0,
                popY: 0

            })
            $("#printArea").html('')
    })

});