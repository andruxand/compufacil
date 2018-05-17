<?php
	
	require_once '../../config/autoload.php';

	switch ($_POST['action']) {
    
	    case 'listar_registros':

			$columns = array(
				"coddane",
				"descripcion",
				"direccion",
				"id_zonas",
				"acciones",
			);

			$sql = " SELECT ms.coddane, ms.descripcion, ms.direccion, ms.id_zonas
			         FROM mat_sedes ms
			         WHERE
			         1=1 ";

		    if($_POST["is_custom_search"] == "yes")
			{
				if( !empty($_POST["institucion"]) ){
					$sql .= ' AND ms.coddane LIKE "'.$_POST["institucion"].'"';
				}

				if( !empty($_POST["zona"]) ){
					$sql .= ' AND ms.id_zonas = '.$_POST["zona"].' ';
				}else{
					$sql .= ' AND ms.id_zonas = "" OR ms.id_zonas IS NULL ';	
				}

			}         

			if(!empty($_POST["search"]["value"]))
			{
				$sql .= ' AND (ms.coddane LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR ms.descripcion LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR ms.direccion LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR ms.id_zonas LIKE "%'.$_POST["search"]["value"].'%") ';
			}

			if(isset($_POST["order"]))
			{
				$sql .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$sql .= ' ORDER BY ms.coddane DESC ';
			}

			$instituciones = $db->sql_exec($sql);
			
			if( $instituciones ){
			 	$totalglobal = mysqli_num_rows($instituciones); 
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
							$columns[0]    => $row["coddane"],
							$columns[1]    => $row["descripcion"],
							$columns[2]    => $row["direccion"],
							$columns[3]    => '<label id="' . $row["coddane"] . '" > ' . $row["id_zonas"] . '</label>',
							$columns[4]    => "<a class='btn btn-outline-primary' data-ieo='" . $row["descripcion"] . "' data-zona='" . $row["id_zonas"] . "' 
						                        id='asignar_zona' data-backdrop='static' data-id='" . $row["coddane"] . "' href='#''>
						                     	  <span class='oi oi-magnifying-glass text-blue' title='icon name' aria-hidden='true'></span>
						                       </a>",
						);

					}

					$data = $nestedData;

					$json_data = array(
						"draw"            => intval($_POST["draw"]),
						"recordsTotal"    => intval( $totalFiltered ), 
						"recordsFiltered" => intval( $totalglobal ),
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

				}
			}else{

				$json_data = array(
						"draw"            => intval($_POST["draw"]),
						"recordsTotal"    => intval( 0 ), 
						"recordsFiltered" => intval( 0 ),
						"data"            => ''
				);

				echo json_encode( $json_data );

			} 

	    break;

	    case "asignar_zona":

	    	if( !empty($_POST['id_zona']) ){
	    		$sql_s = " UPDATE mat_sedes SET 
							 id_zonas = " . $_POST['id_zona'] . "
							 WHERE
							 coddane = '" . $_POST["coddane"] . "' ";
	    	}else{
	    		$sql_s = " UPDATE mat_sedes SET 
							 id_zonas = NULL
							 WHERE
							 coddane = '" . $_POST["coddane"] . "' ";
	    	}

	    	

		    $zonas = $db->sql_exec($sql_s);  
		            
		    if ( $zonas ){

		       	$json_data = array(
			        "success"     => true,     
					"message"     => 'Zona asignada satisfactoriamente',
					"dane"        => $_POST["coddane"],
					"zona"        => $_POST["id_zona"],
				);

            }else{

		    	$json_data = array(
			        "success"     => false,     
					"message"    => $sql_s,
				);	
		    } 

		    echo json_encode( $json_data );

	    break;

	} 

?>