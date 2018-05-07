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

});