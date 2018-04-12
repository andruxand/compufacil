// Función para envío del formulario, la idea de manejarlo de este modo es incluir validaciones 
// en la función antes del envío.
function fhSubmit() {
    $('test-fm').submit();
}
// Función basada en mootols que administra las peticiones ajax
function getDataFm() {
// Se crea un nuevo objeto de petición
    new Request.HTML({
// Se define el archivo de procesamiento y respuesta
        url: 'ajax_rsp.php',
// Se define una acción para mostrar mientras se espera la respuesta
        onRequest: function(){
            $('dspInput').set('text', 'Estamos procesando su respuesta...');
        },
// Se define la acción de respuesta
        onComplete: function(response){
            $('dspInput').empty().adopt(response);
        },
// Se define las variables enviadas
        data: {
            // variables
            gender: $('optSelId').value
        }
// Se envía.
    }).send();
}