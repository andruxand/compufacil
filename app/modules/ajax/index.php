<?php
// ESe incluye Hook Head.php para inicializar el API de Joomla
include('../../hooks/head.php');
?>
<fieldset>
<legend>Formulario</legend>
<form name="test" id="test-fm" method="post" acction="<?php echo $_SERVER['PHP_SELF']; ?>">
<label>Seleccione su G&eacute;nero<label>
<select name="optSel" id="optSelId" onChange="javascript:getDataFm()" >
<option value="-1">-- Selecionar --</option>
<option value="F">Femenino</option>
<option value="M">Masculino</option>
</select>
<br />
<div id="dspInput"></div>
<input type="button" name="ok" id="sndOk" value="Enviar" onClick="javascript:fhSubmit()" />
<input type="reset" name="cancel" id="cancel" value="Cancelar" />
<br />
</form>
</fieldset>
<?php
$optSel  = JRequest::getVar('optSel', NULL);
$optInpt = JRequest::getVar('optInpt', NULL);
// Este segmento se mostrará si se produce el envío de los datos del formulario
if (!empty($optSel) && !empty($optInpt)) {
// esta función nos permitirá calcular el tiempo de permanencia del usuario antes del envío
    function time_elapsed($secs){
        $bit = array(
            ' año'        => $secs / 31556926 % 12,
            ' semanas'        => $secs / 604800 % 52,
            ' día'        => $secs / 86400 % 7,
            ' hora'        => $secs / 3600 % 24,
            ' minuto'    => $secs / 60 % 60,
            ' segundo'    => $secs % 60
        );
        foreach($bit as $k => $v){
            if($v > 1)$ret[] = $v . $k . 's';
            if($v == 1)$ret[] = $v . $k;
        }
        array_splice($ret, count($ret)-1, 0, 'y');
        $ret[] = 'atrás.';
        return join(' ', $ret);
    }
// Aquí comienza lo bueno, Vamos a utilizar algunos objetos del API ya que lo hemos instanciado
// Establezcamos la conexión a la base de datos y la consulta para rescatar el tiempo de el último
// refresco de página. este dato se guarda en la tabla #__session en la columna time
    $db     = JFactory::getDBO();
    $qry    = $db->getQuery(true)
                        ->select('time')
                        ->from('#__session')
                        ->where('session_id = ' . $db->quote($idSessUser) . ' OR userid = ' . $db->quote($user->id));
    $db->setQuery($qry);
    $startSess  = $db->loadResult();
    $now        = time();
    $timeSpend  = time_elapsed($now - $startSess);
?>
<fieldset>
     <legend>Respuesta</legend>
     <h2>Gracias por su respuesta <?php echo $user->name;?></h2>
     <p>Confirmamos que los datos enviados son:</p>
     <p>G&eacute;nero: <?php echo ($optSel=='F')? 'Femenino' : 'Masculino'; ?></p>
     <p>Nombre de elemento: <?php echo $optInpt; ?></p>
     <p><?php echo 'Usted accedió a esta página hace '. $timeSpend; ?></p>
</fieldset>
<?php
 }
?>
 <!-- se llama arhivos js y css propios de la app -->
 <script src="js/fnc.js" type="text/javascript"></script>
 <link rel="stylesheet" href="css/style.css" type="text/css">
 <?php
// ESe incluye Hook Head.php para inicializar el API de Joomla
include('../../hooks/footer.php');
?>