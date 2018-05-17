$(document).ready(function() {

	$( document ).on( "click", "#asignar_zona", function(e) {

	  $(".alert").hide();

      var ieo = "";
      var coddane = "";
      var id_zona = "";

      ieo = $(this).attr("data-ieo");
      coddane = $(this).attr("data-id");
      id_zona = $(this).attr("data-zona");

      $('#info-ieo').val(ieo);
      $('#info-coddane').val(coddane);
      $('#info-zona').val(id_zona);


      console.log('contrato: ' + ieo);

  		$('#load-modal-zonas').modal({
  			 backdrop: "static",
  			 show: true,
  		})
        
    });

	var institucion = $('#institucion');

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
        placeholder: 'DANE o Sede',
        minimumInputLength: 6,
        language: 'es'
    });


	$("#guardar-zona").on( "click", function(){
		
		$(".alert").hide();

    	$.ajax({
	        url: 'ajax.php',
	        type: 'POST',
	        dataType: 'json',
	        data: { coddane: $("#info-coddane").val(), id_zona: $("#info-zona").val(),  action: 'asignar_zona' },
	    })
	    .done(function(data) {
	        if ( data.success ) {
		        console.log( "La solicitud se ha completado correctamente." );
		        $(".alert-success").show();
		        $("label#" + data.dane).text(data.zona);
		        $("a[data-id='" + data.dane + "']").attr("data-zona", data.zona);

		    }else{
		    	$(".alert-danger").show();
		        console.log( "La solicitud NO se ha completado correctamente." );
		    }

	    })
	    .fail(function(XMLHttpRequest, textStatus, errorThrown) {
	    
		    if ( console && console.log ) {
		        console.log( "La solicitud a fallado: " +  textStatus);
		    }    
		});


	});

	function CargaResutlados(is_custom_search, institucion = '', zona = ''){

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
	        	data: { action: 'listar_registros', is_custom_search: is_custom_search, institucion: institucion, zona: zona },
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
	            { "data": "coddane" },
	            { "data": "descripcion" },
	            { "data": "direccion" },
	            { "data": "id_zonas" },
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
		
			$('#fullpage-loader').fadeIn(200);
			$('#results').DataTable().destroy();
			CargaResutlados('yes', institucion.val(), $('#zona').val());

	});

	$('#reset').click(function(){
		
		$("#results").DataTable().destroy();
		institucion.val('').trigger('change.select2');
		 $('#zona').val('');

	});

});