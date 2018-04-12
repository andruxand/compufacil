$( document ).ready(function() {
          
    $( "[data-toggle='modal']" ).on( "click", function(e) {
    	var url = $(this).attr("data-url");
    	var title = $(this).attr("data-title");

    	$(".modal-body").load(url, { id:'primer valor' }, function(response, status, xhr) {
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

});