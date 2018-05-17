<?php
	
	require_once '../config/autoload.php';

	switch ($_GET['action']) {

		case 'intituciones':

		    $parameter = $_GET['search']; //filter_var($parameter, FILTER_SANITIZE_STRING);

		    $sql = "SELECT sede.id ID,
					CONCAT(ie.descripcion IEO, ' / ', sede.descripcion) SEDEIEO 
					FROM
				    mat_ie_usuarios miu,
				    mat_sedes sede
					LEFT JOIN mat_instituciones ie ON
					ie.coddane = sede.daneinstitucion
				    WHERE
				    sede.daneinstitucion = miu.institucion_coddane
				    AND miu.user_id = {$parameter}
					ORDER BY ie.descripcion ASC";

		    $resultado = $db->sql_exec($sql);

		    $data = [];
		    while ($row = mysqli_fetch_object($resultado)) {
		      $data[] = array(
		        "id" => $row->ID,
		        "text" => $row->SEDEIEO
		      );
		    }

		    echo json_encode($data);

	    break;

	}

?>