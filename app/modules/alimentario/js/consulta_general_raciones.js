var fechaInicial = moment().format('YYYY-MM-DD');
var fechaFinal = moment().format('YYYY-MM-DD');

$(document).ready(function() {

	var proveedor = $('#proveedor');
	var fechas = $('input#daterange');

	proveedor.select2();

	fechas.daterangepicker({
		locale: configDataPicker

		},
		function(start, end) {
	        fechaInicial = start.format('YYYY-MM-DD');
	        fechaFinal = end.format('YYYY-MM-DD'); 
	    }
	);

	CargaResutlados('no');

	function CargaResutlados(is_custom_search, proveedor = '', fechaIni = '', fechaFin = ''){

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
            	{ extend: "print", text: "Vista Impresión" },
            	{ extend: "colvis", columns: ":not(.noVis)", text: "Mostrar/Ocultar Columnas" }
       		],
			//"sort": false,
   			//"order" : ["ieo", "tipo_racion"],
	        "ajax": {
	        	url: "ajax.php",
	        	type: "post",
	        	data: { action: 'listar_raciones_general', is_custom_search: is_custom_search, proveedor: proveedor, fechaIni: fechaIni, fechaFin: fechaFin },
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
	            { "data": "nombre_proveedor" },
	            { "data": "zona" },
	            { "data": "tipo_racion" },
	            { "data": "raciones_primaria" },
	            { "data": "raciones_secundaria" },
	            { "data": "dias_atendidos" },
	            { "data": "total_raciones" }
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
		
		$('#results').DataTable().destroy();
		CargaResutlados('yes', proveedor.val(), fechaInicial, fechaFinal);
		console.log(fechaInicial + ' - ' + fechaFinal);

	});

	$('#reset').click(function(){
		
		$("#results").DataTable().destroy();
		CargaResutlados('no');
		proveedor.val('').trigger('change.select2');
		fechas.val('');
		fechaInicial = '';
		fechaFinal = '';
	});


});

