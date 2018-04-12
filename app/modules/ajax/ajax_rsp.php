<?php
// función de php que transforma las variables de servidor $_REQUEST en variables de php
extract($_REQUEST);
if (isset($gender)) {
        if ($gender == 'F') {
                echo '<label>Escriba el nombre de un perfume<label><input type="text" name="optInpt" id="optInptId" value="" />';
        } elseif ($gender == 'M') {
                echo '<label>Escriba el nombre de un futbolista<label><input type="text" name="optInpt" id="optInptId" value="" />';
        } else {
                echo 'Seleccione un valor';
        }
}
?>