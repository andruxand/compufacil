<?php
	
	require_once '../../config/autoload.php';

	$columns = array(
		"dane",
		"proveedor",
		"institucion",
		"direccion",
		"comuna",
		"tipo_zona",
		"sector",
		"zona",
		"modalidad",
		"formacion",
		"acciones"
	);

	$sql = " SELECT i.coddane dane, p.nombre_proveedor proveedor, CONCAT(i.descripcion, ' / ', sc.descripcion) institucion, sc.direccion, cc.descripcion comuna,
             s.descripcion sector, c.numero_contrato
             FROM mat_instituciones i, mat_sectores s, ali_contrato c, mat_sedes sc, ali_proveedor p,
             mat_comunas_corregimientos cc
             WHERE
             i.id_sectores = s.id
             AND sc.id_instituciones = i.id
             AND c.sede_id = sc.id
             AND p.id = c.proveedor_id
             AND cc.id = sc.id_comunas_corregimientos ";

    if($_POST["is_custom_search"] == "yes")
	{
		if( !empty($_POST["institucion"]) ){
			$sql .= ' AND i.coddane LIKE "'.$_POST["institucion"].'"';
		}
	}         

	if(!empty($_POST["search"]["value"]))
	{
		$sql .= ' AND (i.coddane LIKE "%'.$_POST["search"]["value"].'%" 
	  				OR p.nombre_proveedor LIKE "%'.$_POST["search"]["value"].'%" 
	  				OR i.descripcion LIKE "%'.$_POST["search"]["value"].'%" 
	  				OR sc.descripcion LIKE "%'.$_POST["search"]["value"].'%"
	  				OR sc.direccion LIKE "%'.$_POST["search"]["value"].'%"
	  				OR cc.descripcion LIKE "%'.$_POST["search"]["value"].'%"
	  				OR s.descripcion LIKE "%'.$_POST["search"]["value"].'%"
	  				OR c.numero_contrato LIKE "%'.$_POST["search"]["value"].'%") ';
	}

	if(isset($_POST["order"]))
	{
		$sql .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
	}else{
		$sql .= ' ORDER BY i.coddane DESC ';
	}
	 
	if($_POST["length"] != -1)
	{
		$sql .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

    $instituciones = $db->sql_exec($sql);

    if( $instituciones ){
	    $totalFiltered = mysqli_num_rows($instituciones);  

	    if( $totalFiltered > 0 ){
			$data = array();
			
			while( $row = mysqli_fetch_array($instituciones) ) { 
			 // preparing an array

				$nestedData[] = array(
					$columns[0]    => $row["dane"],
					$columns[1]    => $row["proveedor"],
					$columns[2]    => $row["institucion"],
					$columns[3]    => $row["direccion"],
					$columns[4]    => $row["comuna"],
					$columns[5]    => "tipo_zona",
					$columns[6]    => $row["sector"],
					$columns[7]    => "zona",
					$columns[8]    => "modalidad",
					$columns[9]    => "formacion",
					$columns[10]   => "<a class='btn btn-outline-primary' data-url='registrar_raciones.php' data-title='Registrar Raciones' 
	                                   data-toggle='modal' data-target='#load-modal' data-backdrop='static' href='#''>
	                                   <span class='oi oi-plus text-blue' title='icon name' aria-hidden='true'></span>
	                                   </a>"
				);

			}

			$data = $nestedData;

			$json_data = array(
				"draw"            => intval($_POST["draw"]),
				"recordsTotal"    => intval( $totalFiltered ), 
				"recordsFiltered" => intval( $totalFiltered ),
				"data"            => $data 
			);

			echo json_encode($json_data); 
			//echo $sql;

		}else{
			$json_data = array(
				"draw"            => intval($_POST["draw"]),
				"recordsTotal"    => intval( 0 ), 
				"recordsFiltered" => intval( 0 ),
				"data"            => '' 
			);

			echo json_encode( $json_data );
			//echo json_encode( array( "message" => $db->show_nan_rows() ) );
		}
	}  

?>