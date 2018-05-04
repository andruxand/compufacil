
function consultar_raciones(id){

	$(".alert").hide();

	$.ajax({
        url: 'ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {action: 'consultar_raciones', dane: id},
    })
    .done(function(data) {
    	console.log(data);
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
		        $('#confirm').attr("disabled", true);
		        $('#confirm').attr("checked", true);

		        $('#id_registro_racion').val(data.datos_racion.id_racion);
	        	$('#racion-pp').val(data.datos_racion.primaria);
		        $('#racion-s').val(data.datos_racion.secundaria);
		        $('#racion-total').val(data.datos_racion.total_entregadas);

		        if(data.datos_racion.observaciones !== ''){
		        	$('#observaciones').val(data.datos_racion.observaciones);
		        	$('#observaciones-block').show();
		        }

		        $('#registrar_raciones').hide();
		        $('#editar-registro').show();

	    	}else{

	    		console.log('No tiene raciones registradas para hoy');

	    		var total_raciones = parseInt(data.raciones_programadas_pp) + parseInt(data.raciones_programadas_s);

	    		$('#info-racion').show();
		        $('#racion-pp').val(data.raciones_programadas_pp);
		        $('#racion-s').val(data.raciones_programadas_s);
		        $('#racion-total').val(total_raciones);
		        $('#registrar_raciones').attr("disabled", true);

	    	}

	    }else{
	        console.log( "La solicitud NO se ha completado correctamente." );
	    }

	    $('#fullpage-loader').fadeOut(200);
    })
    .fail(function(XMLHttpRequest, textStatus, errorThrown) {

    	$(".alert-danger").show();
	    $("#danger-msg").text(data.message);

	    if ( console && console.log ) {
	        console.log( "La solicitud a fallado: " +  textStatus);
	    }    
	});

}

function registra_raciones(datos){

	console.log(datos + '&action=registrar_raciones');
	$('.alert').hide();

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

	        $('#racion-pp').attr("readonly", true);
		    $('#racion-s').attr("readonly", true);
		    $('#observaciones').attr("readonly", true);
		    $('#confirm').attr("disabled", true);

		    $('#registrar_raciones').hide();
		    $('#cancelar-registro').hide();

	    }else{
	        console.log( "La solicitud NO se ha completado correctamente." );
	    }

		$('#fullpage-loader').fadeOut(200);

    })
    .fail(function(XMLHttpRequest, textStatus, errorThrown) {
    	
    	$(".alert-danger").show();
	    $("#danger-msg").text(data.message);


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
        data: {action: 'consulta_mensual_raciones', dane: id, mes: mes},
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

function habilitaEditarRacion(habilitar){

	if(habilitar === 1){

		$('#registrar_raciones').text('Registrar Cambios');
		$('#registrar_raciones').attr("readonly", false);
		$('#registrar_raciones').show();

		$('#editar-registro').hide();
		$('#cancelar-registro').show();

		$('#racion-pp').attr("readonly", false);
		$('#racion-s').attr("readonly", false);

		$('#observaciones').attr("readonly", false);
		$('#observaciones').attr("required", true);
		$('#observaciones-block').show();

	}else{

		$('#registrar_raciones').hide();

		$('#editar-registro').show();
		$('#cancelar-registro').hide();

		$('#racion-pp').attr("readonly", true);
		$('#racion-s').attr("readonly", true);

		$('#observaciones').attr("readonly", true);

		if($('#observaciones').val() === ''){
			$('#observaciones-block').hide();				
		}

	}

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

    $('#confirm').on("change", function(e){

    	if( $(this).is(':checked') ) {
	         $('#registrar_raciones').attr('disabled', false);
	         console.log('habilita registro');
	    } else {
	        $('#registrar_raciones').attr('disabled', true);
	        console.log('NO habilita registro');
	    }

	});

    $('#registrar_raciones').on("click", function(e){
    	var data = $('#raciones-form').serialize();

    	$(".alert").hide();
    	$(this).attr('disabled', true);

    	e.preventDefault();

    	if ($('#observaciones').attr('required')){

    		if($('#observaciones').val() === ''){

		    	$.confirm({
				    title: 'Confirmar Registro',
				    content: 'Debe ingresar una observación',
				    type: 'yellow',
				    typeAnimated: true,
				    buttons: {
					    close: {
				            text: 'Cerrar',
				            action: function(){

				            }
				        }
				    }
				});

			}else{

				$.confirm({
				    title: 'Confirmar Registro',
				    content: 'Está seguro de que la información ingresada es correcta ?',
				    type: 'yellow',
				    typeAnimated: true,
				    buttons: {
				    	confirm: {
				            text: 'Confirmar',
				            action: function(){
				            	registra_raciones(data);
				            }
				        },
					    close: {
				            text: 'Cerrar',
				            action: function(){

				            }
				        }
				    }
				});

			}

    	}else{

			$.confirm({
			    title: 'Confirmar Registro',
			    content: 'Está seguro de que la información ingresada es correcta ?',
			    type: 'yellow',
			    typeAnimated: true,
			    buttons: {
			    	confirm: {
			            text: 'Confirmar',
			            action: function(){
			            	registra_raciones(data);
			            }
			        },
				    close: {
			            text: 'Cerrar',
			            action: function(){

			            }
			        }
			    }
			});

		}

	});

	$('#editar-registro').on("click", function(e){

		e.preventDefault();

		habilitaEditarRacion(1);

	});

	$('#cancelar-registro').on("click", function(e){

		e.preventDefault();

		habilitaEditarRacion(0);

	});

    $('#buscar_raciones').on("click", function(){
		consulta_mensual_raciones($('#contrato').text(), $('#mes').val());
	});

});
