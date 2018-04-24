
function consultar_raciones(id){

	$(".alert").hide();

	$.ajax({
        url: 'ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {action: 'consultar_raciones', contrato: id},
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

	        $('#fcontrato').val(data.numero_contrato);
		    $('#fmodalidad').val(data.tipo_racion);
		    $('#fsede').val(data.sede_id);
		    $('#finstitucion').val(data.institucion_id);

	        if( data.racion ){

	        	$('#existe-racion').show();

	        	$('#racion-pp').attr("readonly", true);
		        $('#racion-s').attr("readonly", true);
		        $('#observaciones').attr("readonly", true);

	        	$('#racion-pp').val(data.datos_racion.primaria_pp);
		        $('#racion-s').val(data.datos_racion.secundaria_s);
		        $('#racion-total').val(data.datos_racion.total_entregadas);
		        $('#observaciones').val(data.datos_racion.observaciones);
		        $('#registrar_raciones').attr('disabled', true);

	    	}else{

	    		console.log('No tiene raciones registradas para hoy');

	    		var total_raciones = parseInt(data.raciones_programadas_pp) + parseInt(data.raciones_programadas_s);

	    		$('#info-racion').show();
		        $('#racion-pp').val(data.raciones_programadas_pp);
		        $('#racion-s').val(data.raciones_programadas_s);
		        $('#racion-total').val(total_raciones);

	    	}

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

function registra_raciones(datos){

	console.log(datos + '&action=registrar_raciones');

	$.ajax({
        url: 'ajax.php',
        type: 'POST',
        dataType: 'json',
        data: datos + '&action=registrar_raciones',
    })
    .done(function(data) {
        if ( data.success ) {
	        console.log( "La solicitud se ha completado correctamente." );
	        $(".alert-success").show();
	        $("#success-msg").text(data.message);

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

function consulta_mensual_raciones(id, mes){

	$('td > label, textarea').empty();
	$(".alert").hide();

	$.ajax({
        url: 'ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {action: 'consulta_mensual_raciones', contrato: id, mes: mes},
    })
    .done(function(data) {
        if ( data.success ) {
	        console.log( "La solicitud se ha completado correctamente." );
	        console.log(data);

	        console.log("Primaria");
	        $.each(data.primaria, function(index, data) {
	            console.log("campo: " + data.campo);
	            console.log("Valor: " + data.valor);
	            $('#' + data.campo).text(data.valor);
       		 });

	        console.log("Secundaria");
	        $.each(data.secundaria, function(index, data) {
	            console.log("campo: " + data.campo);
	            console.log("Valor: " + data.valor);
	            $('#' + data.campo).text(data.valor);
       		 });

	        console.log("Totales");
	        $.each(data.totales, function(index, data) {
	            console.log("campo: " + data.campo);
	            console.log("Valor: " + data.valor);
	            $('#' + data.campo).text(data.valor);
       		 });

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

	$( ':input[type="number"]' ).on( "keyup mouseup", function(e) {

		var racion_pp = ( $('#racion-pp').val() !== '' ) ? parseInt( $('#racion-pp').val() ) : 0;
		var racion_s = ( $('#racion-s').val() !== '' ) ? parseInt( $('#racion-s').val() ) : 0;

		$('#racion-total').val(racion_pp + racion_s);
        
    });

    $("#vista-impresion").on( "click", function(){

            var mode = "iframe";
            var close = false;

            //printerDiv("area-impresion", "Registro Mensual de Raciones");

            var headElements = '<meta charset="utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge"/>';

            var options = { mode : mode, popClose : close, extraHead : headElements, popHt: 500, popWd: 800, popTitle: "Registro Mensual de Raciones" };

            $( '#area-impresion' ).printArea( options );
    });

    $('#registrar_raciones').on("click", function(e){
    	var data = $('#raciones-form').serialize();

    	$(".alert").hide();

    	e.preventDefault();
		registra_raciones(data);
	});

    $('#buscar_raciones').on("click", function(){
		consulta_mensual_raciones($('#contrato').text(), $('#mes').val());
	});

});
