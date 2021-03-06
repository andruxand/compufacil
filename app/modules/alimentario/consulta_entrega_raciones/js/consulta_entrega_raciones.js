
function consultar_raciones(id){

	$(".alert").hide();

	$.ajax({
        url: '../ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {action: 'consultar_raciones_por_usuario', user: id},
    })
    .done(function(data) {
        if ( data.success ) {
	        console.log( "La solicitud se ha completado correctamente." );
	        $('#proveedor').text(data.proveedor);
	        $('#nombre-institucion').text(data.institucion);
	        $('#sede').text(data.sede);
	        $('#direccion').text(data.direccion);
	        $('#comuna').text(data.comuna);
	        $('#contrato').text(data.numero_contrato);
	        $('#raciones_programadas_pp').text(data.raciones_programadas_pp);
	        $('#raciones_programadas_s').text(data.raciones_programadas_s);
	        $('#tipo_racion').text(data.tipo_racion);
	        $('#dane').text(data.dane);

	    }else{
	        console.log( "La solicitud NO se ha completado correctamente." );
	    }

	    $('#fullpage-loader').fadeOut(200);
    })
    .fail(function(XMLHttpRequest, textStatus, errorThrown) {
	    if ( console && console.log ) {
	        console.log( "La solicitud a fallado: " +  textStatus);
	    }    
	});

}

function consulta_entrega_raciones_por_usuario(mes){

	$('td > label, textarea').empty();
	$('#results tbody').html('');
	$(".alert").hide();

	$.ajax({
        url: '../ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {action: 'consulta_entrega_raciones', mes: mes},
    })
    .done(function(data) {
        if ( data.success ) {
	        console.log( "La solicitud se ha completado correctamente." );
	        console.log(data);
	        var partialTable = '';
	        var partialTableObs = '';
	        var esIntitucion = '';
	        var tipoFila = '';

	        for(var i in data.instituciones) {
    			console.log("nuevo campo" + data.instituciones[i].institucion);  // (o el campo que necesites)
				esIntitucion = (data.instituciones[i].tipo === 'institucion') ? '<span class="oi oi-caret-right"></span>' : ''; 
				tipoFila = (data.instituciones[i].tipo === 'institucion') ? 'th' : 'td';

    			partialTable += ' <tr> ' +
			                	' <' + tipoFila + ' class="text-center" scope="col">' + esIntitucion + data.instituciones[i].institucion + '</' + tipoFila + '> ' +
			                    ' <td class="text-center" scope="col">' + data.instituciones[i].tipo_racion + '</td> ' +
			                    ' <td class="text-center" scope="col">' + data.instituciones[i].raciones_primaria + '</td> ' +
			                    ' <td class="text-center" scope="col">' + data.instituciones[i].raciones_secundaria + '</td> ' +
			                    ' <td class="text-center" scope="col">' + data.instituciones[i].dias_atendidos + '</td> ' +
			                    ' <td class="text-center" scope="col">' + data.instituciones[i].total_raciones + '</td> ' +
			                    ' <td class="text-center" scope="col"> ';

			    if(data.instituciones[i].archivo == ''){
			    	partialTable +=	'<input class="anexa-soporte" type="file" name="soporte_anexo[]" '+
				                		' id="' + data.instituciones[i].coddane + data.instituciones[i].tipo_racion.replace('/', '-') + '" accept="application/pdf" >' + 
				                		' <input type="hidden" value="' + data.instituciones[i].tipo_racion + '" name="tipo_racion[]" id="tipo_racion" > ' + 
				                		' <input type="hidden" value="' + data.instituciones[i].coddane + '" name="coddane[]" id="coddane" >'; 
				}else{

					partialTable +='<strong><a href="../uploads/'+data.instituciones[i].archivo +'" target="_blank"> ' + data.instituciones[i].archivo + '</a></strong>';

				}  

			    partialTable += ' </td></tr>';
			}

			$('#results tbody').html(partialTable);

			var currentSede_id; 
			if(data.observaciones){
				var check = "<span class='oi oi-check text-blue' title='icon name' aria-hidden='true'></span>";
				var noCheck = "<span class='oi oi-x text-blue' title='icon name' aria-hidden='true'></span>";

				for(var i in data.observaciones) {

					if(data.observaciones[i].sede_id !== currentSede_id){

						partialTableObs += '<table id="results-observations" class="table table-hover table-sm table-bordered">'+
                                    '<thead>'+
                                    '	<tr>'+
                                    '        <th class="text-center" colspan="5" scope="col">' + data.observaciones[i].sede + '</th>'+
                                    '    </tr>'+
                                    '    <tr>'+
                                    '        <th class="text-center" scope="col">OBSERVACIONES</th>'+
                                    '       <th class="text-center" scope="col">CERTIFICA COORDINADOR</th>'+
                                    '        <th class="text-center" scope="col">CERTIFICA PERSONERO</th>'+
                                    '        <th class="text-center" scope="col">CERTIFICA PROVEEDOR</th>'+
                                    '        <th class="text-center" scope="col">FECHA_REGISTRO</th>'+
                                    '    </tr>'+
                                    '</thead>'+
                                    '<tbody>';

					}

					var checkCoordinador = "";
					var checkPersonero = "";
					var checkProveedor = "";

					if(data.observaciones[i].confirm_coordinador == 1){
						checkCoordinador = check;	
					}else{
						checkCoordinador = noCheck;	
					}

					if(data.observaciones[i].confirm_personero == 1){
						checkPersonero = check;	
					}else{
						checkPersonero = noCheck;	
					}

					if(data.observaciones[i].confirm_proveedor == 1){
						checkProveedor = check;	
					}else{
						checkProveedor = noCheck;	
					}

					partialTableObs += ' <tr> ' +
				                    ' <td class="text-center" scope="col">' + data.observaciones[i].observaciones + '</td> ' +
				                    ' <td class="text-center" scope="col">' + checkCoordinador + '</td> ' +
				                    ' <td class="text-center" scope="col">' + checkPersonero + '</td> ' +
				                    ' <td class="text-center" scope="col">' + checkProveedor + '</td> ' +
				                    ' <td class="text-center" scope="col">' + data.observaciones[i].fecha_registro + '</td></tr>';

				    currentSede_id = data.observaciones[i].sede_id;                

					if(data.observaciones[i].sede_id !== currentSede_id){

						partialTableObs += '</tbody>'+
                                       '</table>';

					}

				    
				}

			}	

			$('#observaciones').html(partialTableObs);

	    }else{
	        console.log( "La solicitud NO se ha completado correctamente." );
	        $('#info-msg').text(data.message);
	        $('.alert-info').show();
	    }

	    $('#fullpage-loader').fadeOut(200);
    })
    .fail(function(XMLHttpRequest, textStatus, errorThrown) {
	    if ( console && console.log ) {
	        console.log( "La solicitud a fallado: " +  errorThrown);
	    }    
	});

}

$(document).ready(function() {

    $("#vista-impresion").on( "click", function(){

        var mode = "iframe";
        var close = false;

        //printerDiv("area-impresion", "Registro Mensual de Raciones");

        var headElements = '<meta charset="utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge"/>';

        var options = { mode : mode, popClose : close, extraHead : headElements, popHt: 500, popWd: 800, popTitle: "Registro Mensual de Raciones" };

        $( '#area-impresion' ).printArea( options );
    });

    $('#buscar_raciones').on("click", function(){
		consulta_entrega_raciones_por_usuario($('#mes').val());
	});

	$("#entrega-raciones-form").on('submit', function (e) {

		e.preventDefault();

		$('.alert').hide();

		var filedata = $('input[type=file]');

	    var i = 1, len = filedata.length, file, error = 0;

	    console.log('cuantos:' + len);

	    /*$('input[type=file]').each(function(){
        	alert($(this).files.size)
        });*/

	   /* for (; i < len; i++) {
	        file = filedata[i].files[0];

	        console.log('tamaño:' + file.size);

	        if (file.size > 2097152) {
	            filedata[i].css('border-color: #000;');
	            filedata[i].val('');
	            error = error + 1;
	            alert('Archivo muy grande');
	        }

	    }*/

		var form = $(this);
   		var formdata = false;
    	if (window.FormData){
        	formdata = new FormData(form[0]);
        	formdata.append('mes', $('#mes').val());
    	}

        /*for (var value of formdata.values()) {
   			console.log(value); 
		}*/

		$.ajax({
        url: '../ajax.php',
        type: 'POST',
        data: formdata,
        processData: false,
        contentType: false,
	    })
	    .done(function(data) {
	    	
	    	$('#fullpage-loader').fadeOut(200);
	    	var data = jQuery.parseJSON( data );
	    	console.log('respuesta: ' + data);

	        if ( data.success ) {

	        	var mensajes = '';

		        $.each(data.archivos, function(index, data) {
		            mensajes += '<span class="oi oi-check"></span>' + data.message + ' ' + data.nombre_archivo + '<br>';
		            $('#' + data.id_archivo).parent('td').html('<strong><a href="../uploads/'+ data.nombre_archivo +'" target="_blank">' + data.nombre_archivo + '</a></strong>');
	       		 });

		        $('#success-msg').html(mensajes);
		        $('.alert-success').show();

		    }else{

				var mensajes = '';

		        $.each(data.archivos, function(index, data) {
		            
		            if(data.success){
		            	mensajes += '<span class="oi oi-check"></span>' + data.message + ' ' + data.nombre_archivo + '<br>';
		            	$('#' + data.id_archivo).parent('td').html('<strong><a href="../uploads/'+ data.nombre_archivo +'" target="_blank">' + data.nombre_archivo + '</a></strong>');	
		            }else{
		            	mensajes += '<span class="oi oi-x"></span>' + data.message + ' ' + data.nombre_archivo + '<br>';
		            }

	       		 });

		        $('#info-msg').html(mensajes);
		        $('.alert-info').show();

		    }

		    $('#fullpage-loader').fadeOut(200);
	    })
	    .fail(function(XMLHttpRequest, textStatus, errorThrown) {
		    if ( console && console.log ) {
		        console.log( "La solicitud a fallado: " +  errorThrown);
		    } 
		    $('#loader-error').fadeIn(200);
    		$('#loader-icon').removeClass('fa-spin').addClass('text-danger');   
		});


            
    });

});
