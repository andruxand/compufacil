
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

function consulta_entrega_raciones_por_usuario(id, mes){

	$('td > label, textarea').empty();
	$(".alert").hide();

	$.ajax({
        url: '../ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {action: 'consulta_entrega_raciones', user: id, mes: mes},
    })
    .done(function(data) {
        if ( data.success ) {
	        console.log( "La solicitud se ha completado correctamente." );
	        console.log(data);
	        var partialTable = '';
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
			                    ' <td class="text-center" scope="col"> ' +
			                    		'<input class="file-input" type="file" name="' + data.instituciones[i].institucion + '" '+
				                		' id="' + data.instituciones[i].institucion + '" accept="image/*,.doc,.docx,application/msword, ' +
				                		'application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.ms-excel" ></td>' +     
			                  ' </tr>';
    			/*for(var s in data.instituciones[i].sedes) {
    				console.log("nuevo campo dos" + data.instituciones[i].sedes[s].institucion); 
    				partialTable += ' <tr> ' +
				                	 ' <td class="text-center" scope="col">' + data.instituciones[i].sedes[s].institucion + '</td> ' +
				                     ' <td class="text-center" scope="col">' + data.instituciones[i].sedes[s].tipo_racion + '</td> ' +
				                     ' <td class="text-center" scope="col">' + data.instituciones[i].sedes[s].raciones_primaria + '</td> ' +
				                     ' <td class="text-center" scope="col">' + data.instituciones[i].sedes[s].raciones_secundaria + '</td> ' +
				                     ' <td class="text-center" scope="col">' + data.instituciones[i].sedes[s].dias_atendidos + '</td> ' +
				                     ' <td class="text-center" scope="col">' + data.instituciones[i].sedes[s].total_raciones + '</td> ' +
				                     ' <td class="text-center" scope="col"> ' +
			                    		'<input class="file-input" type="file" name="' + data.instituciones[i].sedes[s].institucion + '" '+
				                		' id="' + data.instituciones[i].sedes[s].institucion + '" accept="image/*,.doc,.docx,application/msword, ' +
				                		'application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.ms-excel" ></td>' +      
				                   ' </tr>';
    			}*/
			}

			$('#results tbody').html(partialTable);

	    }else{
	        console.log( "La solicitud NO se ha completado correctamente." );
	        $('#info-msg').text(data.message);
	        $('.alert-info').show();
	    }

	    $('#fullpage-loader').fadeOut(200);
    })
    .fail(function(XMLHttpRequest, textStatus, errorThrown) {
	    if ( console && console.log ) {
	        console.log( "La solicitud a fallado: " +  textStatus);
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
		consulta_entrega_raciones_por_usuario($('#contrato').text(), $('#mes').val());
	});

});