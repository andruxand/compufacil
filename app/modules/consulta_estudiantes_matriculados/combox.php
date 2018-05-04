<?php
	
	require_once '../../config/autoload.php';

	switch ($_GET['action']) {

		case 'intituciones':

		    $parameter = $_GET['search']; //filter_var($parameter, FILTER_SANITIZE_STRING);

		    $sql = "SELECT sc.coddane, CONCAT(sc.coddane, ' - ', CONCAT(sc.descripcion, ' / ', sc.descripcion) ) NOMBRE"
                   ." FROM mat_sedes sc"
                   ." WHERE"
                   ." sc.coddane LIKE  '%{$parameter}%' "
                   ." OR sc.descripcion LIKE '%{$parameter}%' ";

		    $resultado = $db->sql_exec($sql);

		    $data = [];
		    while ($row = mysqli_fetch_object($resultado)) {
		      $data[] = array(
		        "id" => $row->coddane,
		        "text" => $row->NOMBRE
		      );
		    }

		    echo json_encode($data);

	    break;

	}

?>