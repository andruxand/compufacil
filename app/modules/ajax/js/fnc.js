// Funci�n para env�o del formulario, la idea de manejarlo de este modo es incluir validaciones 
// en la funci�n antes del env�o.
function fhSubmit() {
    $('test-fm').submit();
}
// Funci�n basada en mootols que administra las peticiones ajax
function getDataFm() {
// Se crea un nuevo objeto de petici�n
    new Request.HTML({
// Se define el archivo de procesamiento y respuesta
        url: 'ajax_rsp.php',
// Se define una acci�n para mostrar mientras se espera la respuesta
        onRequest: function(){
            $('dspInput').set('text', 'Estamos procesando su respuesta...');
        },
// Se define la acci�n de respuesta
        onComplete: function(response){
            $('dspInput').empty().adopt(response);
        },
// Se define las variables enviadas
        data: {
            // variables
            gender: $('optSelId').value
        }
// Se env�a.
    }).send();
}