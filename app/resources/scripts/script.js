    var configDataPicker = {
          "format": 'DD-MM-YYYY',
          "applyLabel": "Aplicar",
          "cancelLabel": "Cancelar",
          "fromLabel": "Desde",
          "toLabel": "Hasta",
          "daysOfWeek": [
              "Dom",
              "Lun",
              "Mar",
              "Mie",
              "Jue",
              "Vie",
              "Sáb"
          ],
          "monthNames": [
              "Enero",
              "Febrero",
              "Marzo",
              "Abril",
              "Mayo",
              "Junio",
              "Julio",
              "Agusto",
              "Septiembre",
              "Octubre",
              "Noviembre",
              "Diciembre"
          ],
          "firstDay": 1
    }

$( document ).ready(function() {
          
    $( document ).on( "click", "[data-toggle='modal']", function(e) {
    	var url = "";
    	var title = "";
      var id = "";

      url = $(this).attr("data-url");
      title = $(this).attr("data-title");
      id = $(this).attr("data-id");

      console.log('contrato: ' + id);

    	$(".modal-body").load(url, { id: id }, function(response, status, xhr) {
			if (status == "error") {
				var msg = "<div class='alert alert-danger' role='alert'>" +
                          "	<span class='oi oi-circle-x' title='icon name' aria-hidden='true'></span>" +
                          "	Error al cargar el formulario: " + xhr.status + " " + xhr.statusText +
                          "</div>";
				$(".modal-body").html(msg);
			}
		});

    	if(title){
			$( ".modal-title font" ).text(title);
    	}else{
    		$( ".modal-title font" ).text('Gestionar');	
    	}

		$('#load-modal').modal({
			 backdrop: "static"
		})
        
    });

    $('#load-modal').on('hidden.bs.modal', function (e) {
      $(".modal-body").html('');  
    })

    // Fullpage loader
    $(document).on('click', '.ajax-loader', function () {
        $('#loader-icon').addClass('fa-spin').removeClass('text-danger');
        $('#fullpage-loader').fadeIn(200);
    });

    // for error in ajax calls
    //$('#loader-error').fadeIn(200);
    //$('#loader-icon').removeClass('fa-spin').addClass('text-danger');

    $(document).on('click', '.fullpage-loader-close', function () {
        $('#fullpage-loader').fadeOut(200);
        $('#loader-error').hide();
        $('#loader-icon').addClass('fa-spin').removeClass('text-danger');
    });

    $('input[type=file]').change(function(){
      var filename = $(this).val().split('\\').pop();
      var idname = $(this).attr('id');
      console.log($(this));
      console.log(filename);
      console.log(idname);
      $('span.'+idname).next().find('span').html(filename);
    });

});

function printerDiv(divID, title) {
  
  //Get the HTML of div
  var divElements = document.getElementById(divID).innerHTML;

  //Get the HTML of whole page
  var oldPage = document.body.innerHTML;

  //Reset the pages HTML with divs HTML only
  document.body.innerHTML = "<html><head><title>" + title + "</title></head><body>" + divElements + "</body>";

  //Print Page
  window.print();

  //Restore orignal HTML
  document.body.innerHTML = oldPage;

}