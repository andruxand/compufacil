$(document).ready(function() {

	var institucion = $('#institucion');

	institucion.select2();

	CargaResutlados('no');

	function CargaResutlados(is_custom_search, institucion = ''){

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
            	{ extend: "print", text: "Vista Impresi&oacuten", exportOptions: { columns: ':visible' } },
            	{ extend: "colvis", columns: ":not(.noVis)", text: "Mostrar/Ocultar Columnas" }
       		],
			//"sort": false,
   			//"order" : [],
	        "ajax": {
	        	url: "ajax.php",
	        	type: "post",
	        	data: { action: 'listar_registros', is_custom_search: is_custom_search, institucion: institucion },
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
	            { "data": "dane" },
	            { "data": "proveedor" },
	            { "data": "institucion" },
	            { "data": "direccion" },
	            { "data": "comuna" },
	            //{ "data": "tipo_zona" },
	            { "data": "sector" },
	            //{ "data": "zona" },
	            { "data": "modalidad" },
	            { "data": "formacion" },
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
						"last":				"&Ucuteltima",
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
		
		$('#results').DataTable().destroy();
		CargaResutlados('yes', institucion.val());

	});

	$('#reset').click(function(){
		
		$("#results").DataTable().destroy();
		CargaResutlados('no');
		institucion.val('').trigger('change.select2');

	});

});