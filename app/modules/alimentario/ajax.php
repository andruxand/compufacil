<?php
	
	require_once '../../config/autoload.php';

	switch ($_POST['action']) {
    
	    case 'listar_registros':

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

			$sql = " SELECT sc.coddane dane, p.nombre_proveedor proveedor, CONCAT(i.descripcion, ' / ', sc.descripcion) institucion, sc.direccion, 
					 cc.descripcion comuna, s.descripcion sector, c.numero_contrato, c.tipo_racion, mti.descripcion formacion
		             FROM mat_instituciones i, mat_sectores s, ali_contrato c, mat_sedes sc, ali_proveedor p,
		             mat_comunas_corregimientos cc, mat_tipo_instituciones mti
		             WHERE
		             i.id_sectores = s.id
		             AND sc.id_instituciones = i.id
		             AND c.sede_id = sc.id
		             AND p.id = c.proveedor_id
		             AND cc.id = sc.id_comunas_corregimientos 
		             AND i.id_tipo_instituciones = mti.id
		             AND c.user_id = ".$current_userID."";

		    if($_POST["is_custom_search"] == "yes")
			{
				if( !empty($_POST["institucion"]) ){
					$sql .= ' AND sc.coddane LIKE "'.$_POST["institucion"].'"';
				}
			}         

			if(!empty($_POST["search"]["value"]))
			{
				$sql .= ' AND (sc.coddane LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR p.nombre_proveedor LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR sc.descripcion LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR sc.descripcion LIKE "%'.$_POST["search"]["value"].'%"
			  				OR sc.direccion LIKE "%'.$_POST["search"]["value"].'%"
			  				OR cc.descripcion LIKE "%'.$_POST["search"]["value"].'%"
			  				OR s.descripcion LIKE "%'.$_POST["search"]["value"].'%"
			  				OR c.tipo_racion LIKE "%'.$_POST["search"]["value"].'%"
			  				OR mti.descripcion LIKE "%'.$_POST["search"]["value"].'%"
			  				OR c.numero_contrato LIKE "%'.$_POST["search"]["value"].'%") ';
			}

			if(isset($_POST["order"]))
			{
				$sql .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$sql .= ' ORDER BY sc.coddane DESC ';
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
							$columns[0]    => $row["dane"],
							$columns[1]    => $row["proveedor"],
							$columns[2]    => $row["institucion"],
							$columns[3]    => $row["direccion"],
							$columns[4]    => $row["comuna"],
							//$columns[5]    => "tipo_zona",
							$columns[6]    => $row["sector"],
							//$columns[7]    => "zona",
							$columns[8]    => $row["tipo_racion"],
							$columns[9]    => $row["formacion"],
							$columns[10]   => "<div style='width:100px'>
											   <a class='btn btn-outline-primary' data-url='views/registrar_raciones.php' data-title='Registrar Raciones' 
			                                   data-toggle='modal' data-target='#load-modal' data-backdrop='static' data-id='" . $row["dane"] . "' href='#''>
			                                   <span class='oi oi-plus text-blue' title='icon name' aria-hidden='true'></span>
			                                   </a>
			                                   <a class='btn btn-outline-primary' data-url='views/consultar_raciones.php' data-title='Consultar Raciones' 
			                                   data-toggle='modal' data-target='#load-modal' data-backdrop='static' data-id='" . $row["dane"] . "' href='#''>
			                                   <span class='oi oi-magnifying-glass text-blue' title='icon name' aria-hidden='true'></span>
			                                   </a>
			                                   </div>"
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
			} 

	        break;

	    case 'consultar_raciones':

	    	$sql = " SELECT p.nombre_proveedor proveedor, sc.id_instituciones institucionid, i.descripcion institucion, sc.id sedeid, 
	    			 sc.descripcion sede, sc.direccion, cc.descripcion comuna, c.numero_contrato, c.raciones_programadas_primaria, 
	    			 c.raciones_programadas_secundaria, c.tipo_racion, sc.coddane
		             FROM mat_instituciones i, ali_contrato c, mat_sedes sc, ali_proveedor p,
		             mat_comunas_corregimientos cc
		             WHERE
		             sc.id_instituciones = i.id
		             AND c.sede_id = sc.id
		             AND p.id = c.proveedor_id
		             AND cc.id = sc.id_comunas_corregimientos
		             AND sc.coddane LIKE '" .$_POST['dane']. "' ";

		    $instituciones = $db->sql_exec($sql); 

		    $sql_s = " SELECT ar.id, ar.primaria, ar.secundaria, ar.observaciones, ar.total
		               FROM  ali_registros ar, mat_sedes ms
		               WHERE
		               ms.id = ar.sede_id
		               AND ms.coddane LIKE '" .$_POST['dane']. "'
                       AND date_format(str_to_date(ar.fecha_registro, '%d/%m/%Y'), '%Y-%m-%d') = CURDATE() ";

            $raciones = $db->sql_exec($sql_s);  
            
            if ( $raciones ){
            	$num_raciones = mysqli_num_rows($raciones); 
            	$row_racion = mysqli_fetch_array($raciones); 

            	$valida_raciones = ($num_raciones > 0) ? true : false;

            	$json_raciones = array(
            		'id_racion' => $row_racion['id'],
            		'primaria' => $row_racion['primaria'], 
            		'secundaria' => $row_racion['secundaria'],
        			'observaciones' => $row_racion['observaciones'], 
        			'total_entregadas' => $row_racion['total']
            	);

            }      
		    
		    if( $instituciones ){

		    	$totalFiltered = mysqli_num_rows($instituciones);  

			    if( $totalFiltered > 0 ){

			    	$row = mysqli_fetch_array($instituciones);

			    	$json_data = array(
			        	"success"               => true,     
						"proveedor"             => $row['proveedor'],
						"institucion"           => $row['institucion'],
						"sede"                  => $row['sede'],
						"direccion"             => $row['direccion'],
						"comuna"                => $row['comuna'],
						"numero_contrato"       => $row['numero_contrato'],
						"raciones_programadas_pp"  => $row['raciones_programadas_primaria'],
						"raciones_programadas_s"  => $row['raciones_programadas_secundaria'],
						"tipo_racion"           => $row['tipo_racion'],
						"sede_id"               => $row['sedeid'],
						"institucion_id"        => $row['institucionid'],
						"dane"					=> $row['coddane'],
						"racion"				=> $valida_raciones,
						"datos_racion"			=> $json_raciones,
					);


			    }else{

			    	$json_data = array(
			        	"success"     => false,     
						"message"    => 'No hay datos asignados',
					);

			    }

		    }else{

		    	$json_data = array(
			        "success"     => false,     
					"message"    => 'Problemas al ejecutar la consulta para cargar datos de la institución',
				);	

		    }        

			echo json_encode($json_data);

	        break;

	    	case 'consulta_mensual_raciones':

	    	$sql = "SELECT ar.primaria, ar.secundaria,
					WEEK(date_format(str_to_date(ar.fecha_registro, '%d/%m/%Y'), '%Y/%m/%d'), 5) - WEEK(DATE_SUB(date_format(str_to_date(ar.fecha_registro, '%d/%m/%Y'), '%Y/%m/%d'), INTERVAL DAYOFMONTH(date_format(str_to_date(ar.fecha_registro, '%d/%m/%Y'), '%Y/%m/%d')) - 1 DAY), 5) semana,
					(ELT(WEEKDAY(date_format(str_to_date(ar.fecha_registro, '%d/%m/%Y'), '%Y/%m/%d')) + 1, '1', '2', '3', '4', '5', '6', '7')) dia_semana
					FROM ali_registros ar, mat_sedes ms
					WHERE 
					ar.sede_id = ms.id
					AND ms.coddane LIKE '" . $_POST['dane'] . "' 
					AND date_format(str_to_date(ar.fecha_registro, '%d/%m/%Y'), '%Y-%m') = '" . $_POST['mes'] ."' ";

		    $raciones = $db->sql_exec($sql); 
		    
		    if( $raciones ){

		    	$totalFiltered = mysqli_num_rows($raciones);  

			    if( $totalFiltered > 0 ){

			    	while( $row = mysqli_fetch_array($raciones) ) { 

				    	$primaria[] = array(
				        	"campo"             => "pp_" . $row['semana'] .'_' . $row['dia_semana'],     
							"valor"             => $row['primaria'],
						);

						$secundaria[] = array(
				        	"campo"             => "s_" . $row['semana'] .'_'. $row['dia_semana'],     
							"valor"             => $row['secundaria'],
						);

						$totales[] = array(
							"campo"             => "t_" . $row['semana'] .'_'. $row['dia_semana'],     
							"valor"             => $row['primaria'] + $row['secundaria'],
						);

			    	}

			    	$json_data = array(
			        	"success"     => true,
			        	"primaria"    => $primaria,
			        	"secundaria"  => $secundaria,
			        	"totales"     => $totales,
					);

			    }else{

			    	$json_data = array(
			        	"success"     => false,     
						"message"    => 'No se encontraron resultados',
					);

			    }

		    }else{

		    	$json_data = array(
			        "success"     => false,     
					"message"    => 'Problemas al ejecutar la consulta para cargar datos de la institución',
				);	

		    }        

			echo json_encode($json_data);
	        
	        break;

	    	case 'registrar_raciones':

	    	if(empty($_POST["id_registro_racion"])){

		    	$db_data = array(
		    		"sede_usuario_user_id"	=> $_POST["fuser"],
		    		"institucion_id"		=> $_POST["finstitucion"],
		    		"sede_id"				=> $_POST["fsede"],
		    		"fecha_registro"		=> $_POST["fregistro"],
		    		"contrato_numero"		=> $_POST["fcontrato"],
		    		"tipo_racion"			=> $_POST["fmodalidad"],
		    		"primaria"				=> $_POST["racion-pp"],
		    		"secundaria"			=> $_POST["racion-s"],
		    		"total" 				=> $_POST["racion-total"],
		    		"observaciones" 		=> $_POST["observaciones"],
		    	);

		    	//insert
			    $raciones = $db->insert("ali_registros", $db_data);
			    
			    if( $raciones ){

				    $json_data = array(
				       	"success"     => true,
				       	"message"    => "Raciones registradas satisfactoriamente!",
					);

			    }else{

			    	$json_data = array(
				        "success"     => false,     
						"message"    => 'Problemas al ejecutar la inserción para cargar datos de la institución',
					);	

			    } 

			}else{

				$sql = " UPDATE ali_registros set 
						 primaria = " . $_POST["racion-pp"] . " 
						 , secundaria = " . $_POST["racion-s"] ." 
						 , observaciones = '" . $_POST["observaciones"] . "' 
						 , total = '" . $_POST["racion-total"] . "' 
						 WHERE
						 id = " . $_POST["id_registro_racion"] . " ";

				$raciones = $db->sql_exec($sql);
				
				 if( $raciones ){

				    $json_data = array(
				       	"success"     => true,
				       	"message"    => "Raciones actualizadas satisfactoriamente!",
					);

			    }else{

			    	$json_data = array(
				        "success"     => false,     
						"message"    => 'Problemas al ejecutar la actualización para cargar datos de la institución',
					);	

			    } 	 

			}       

			echo json_encode($json_data);
	        
	        break;

	        case 'listar_registros_proveedor':

			$columns = array(
				"ieo",
				"tipo_racion",
				"raciones_primaria",
				"raciones_secundaria",
				"total_raciones",
				"dias_atendidos"
			);


			$sql = " SELECT * FROM (SELECT  i.descripcion ieo, c.tipo_racion, p.nombre_proveedor, 
					 ar.fecha_registro, 
					 c.numero_contrato, 
			         SUM(ar.primaria) raciones_primaria,
					 SUM(ar.secundaria) raciones_secundaria,
			         ( (ar.primaria + ar.secundaria) * COUNT(ar.contrato_numero) ) as total_raciones, 
			         COUNT(ar.contrato_numero) as dias_atendidos
					 FROM ali_contrato c, ali_proveedor p, ali_registros ar, mat_instituciones i
					 WHERE
					 c.proveedor_id = p.id
					 AND c.numero_contrato = ar.contrato_numero
					 AND ar.institucion_id = i.id
					 GROUP BY i.descripcion, c.tipo_racion, p.nombre_proveedor) ra 
					 WHERE 1 = 1";

		    if($_POST["is_custom_search"] == "yes")
			{
				if( !empty($_POST["proveedor"]) ){
					$sql .= ' AND ra.numero_contrato LIKE "'.$_POST["proveedor"].'"';
				}

				if( (!empty($_POST["fechaIni"])) && (!empty($_POST["fechaFin"])) ){
					$sql .= ' AND STR_TO_DATE(ra.fecha_registro, "%d/%m/%Y")
					          BETWEEN DATE("'.$_POST["fechaIni"].'" ) AND DATE("'.$_POST["fechaFin"].'") ';
				}
			}         

			if(!empty($_POST["search"]["value"]))
			{
				$sql .= ' AND (ra.ieo LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR ra.tipo_racion LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR ra.nombre_proveedor LIKE "%'.$_POST["search"]["value"].'%") ';
			}

			if(isset($_POST["order"]))
			{
				$sql .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$sql .= ' ORDER BY ra.descripcion DESC ';
			}

			$proveedores = $db->sql_exec($sql);

			if( $proveedores ){
			 	$totalglobal = mysqli_num_rows($proveedores); 
			} 
			 
			if($_POST["length"] != -1)
			{
				$sql .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

		    $proveedores = $db->sql_exec($sql);

		    if( $proveedores ){
			    $totalFiltered = mysqli_num_rows($proveedores);  

			    if( $totalFiltered > 0 ){
					$data = array();
					
					while( $row = mysqli_fetch_array($proveedores) ) { 
					 // preparing an array

						$nestedData[] = array(
							$columns[0]    => $row["ieo"],
							$columns[1]    => $row["tipo_racion"],
							$columns[2]    => $row["raciones_primaria"],
							$columns[3]    => $row["raciones_secundaria"],
							$columns[4]    => $row["total_raciones"],
							$columns[5]    => $row["dias_atendidos"]
						);

					}

					$data = $nestedData;

					$json_data = array(
						"draw"            => intval($_POST["draw"]),
						"recordsTotal"    => intval( $totalFiltered ), 
						"recordsFiltered" => intval( $totalglobal ),
						"data"            => $data 
					);


				}else{
					$json_data = array(
						"draw"            => intval($_POST["draw"]),
						"recordsTotal"    => intval( 0 ), 
						"recordsFiltered" => intval( 0 ),
						"data"            => '' 
					);

				}

			}else{

				$json_data = array(
						"draw"            => intval($_POST["draw"]),
						"recordsTotal"    => intval( 0 ), 
						"recordsFiltered" => intval( 0 ),
						"data"            => '' 
				);	
			} 

			echo json_encode($json_data);

	        break;

	        case 'listar_raciones_general':

			$columns = array(
				"nombre_proveedor",
				"zona",
				"tipo_racion",
				"raciones_primaria",
				"raciones_secundaria",
				"total_raciones",
				"dias_atendidos"
			);


			$sql = " SELECT * FROM (SELECT  i.descripcion ieo, c.tipo_racion, p.nombre_proveedor, 
					 ar.fecha_registro,
					 c.numero_contrato, 
			         SUM(ar.primaria) raciones_primaria,
					 SUM(ar.secundaria) raciones_secundaria,
			         ( (ar.primaria + ar.secundaria) * COUNT(ar.contrato_numero) ) as total_raciones,  
			         COUNT(ar.contrato_numero) as dias_atendidos
					 FROM ali_contrato c, ali_proveedor p, ali_registros ar, mat_instituciones i
					 WHERE
					 c.proveedor_id = p.id
					 AND c.numero_contrato = ar.contrato_numero
					 AND ar.institucion_id = i.id
					 GROUP BY i.descripcion, c.tipo_racion, p.nombre_proveedor) ra 
					 WHERE 1 = 1 ";

		    if($_POST["is_custom_search"] == "yes")
			{
				if( !empty($_POST["proveedor"]) ){
					$sql .= ' AND ra.numero_contrato LIKE "'.$_POST["proveedor"].'"';
				}

				if( (!empty($_POST["fechaIni"])) && (!empty($_POST["fechaFin"])) ){
					$sql .= ' AND STR_TO_DATE(ra.fecha_registro, "%d/%m/%Y")
					          BETWEEN DATE("'.$_POST["fechaIni"].'" ) AND DATE("'.$_POST["fechaFin"].'") ';
				}
			}         

			if(!empty($_POST["search"]["value"]))
			{
				$sql .= ' AND (ra.tipo_racion LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR ra.nombre_proveedor LIKE "%'.$_POST["search"]["value"].'%") ';
			}

			if(isset($_POST["order"]))
			{
				$sql .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$sql .= ' ORDER BY ra.nombre_proveedor DESC ';
			}

			$raciones = $db->sql_exec($sql);

			if( $raciones ){
			 	$totalglobal = mysqli_num_rows($raciones); 
			} 
			 
			if($_POST["length"] != -1)
			{
				$sql .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

		    $raciones = $db->sql_exec($sql);

		    if( $raciones ){
			    $totalFiltered = mysqli_num_rows($raciones);  

			    if( $totalFiltered > 0 ){
					$data = array();
					
					while( $row = mysqli_fetch_array($raciones) ) { 
					 // preparing an array

						$nestedData[] = array(
							$columns[0]    => $row["nombre_proveedor"],
							$columns[1]    => "zona",
							$columns[2]    => $row["tipo_racion"],
							$columns[3]    => $row["raciones_primaria"],
							$columns[4]    => $row["raciones_secundaria"],
							$columns[5]    => $row["total_raciones"],
							$columns[6]    => $row["dias_atendidos"]
						);

					}

					$data = $nestedData;

					$json_data = array(
						"draw"            => intval($_POST["draw"]),
						"recordsTotal"    => intval( $totalFiltered ), 
						"recordsFiltered" => intval( $totalglobal ),
						"data"            => $data 
					);


				}else{
					$json_data = array(
						"draw"            => intval($_POST["draw"]),
						"recordsTotal"    => intval( 0 ), 
						"recordsFiltered" => intval( 0 ),
						"data"            => ''
					);

				}

			}else{

				$json_data = array(
						"draw"            => intval($_POST["draw"]),
						"recordsTotal"    => intval( 0 ), 
						"recordsFiltered" => intval( 0 ),
						"data"            => ''
				);	
			} 

			echo json_encode($json_data);

	        break;

	        case 'listar_proveedores_registrados':

			$columns = array(
				"ieo",
				"tipo_racion",
				"raciones_primaria",
				"raciones_secundaria",
				"total_raciones",
			);


			$sql = " SELECT * FROM (SELECT  i.descripcion ieo, c.tipo_racion, p.nombre_proveedor, p.nit, 
			         SUM(ar.primaria) raciones_primaria,
					 SUM(ar.secundaria) raciones_secundaria,
			         ( (ar.primaria + ar.secundaria) * COUNT(ar.contrato_numero) ) as total_raciones, 
					 FROM ali_contrato c, ali_proveedor p, ali_registros ar, mat_instituciones i
					 WHERE
					 c.proveedor_id = p.id
					 AND c.numero_contrato = ar.contrato_numero
					 AND ar.institucion_id = i.id
					 GROUP BY i.descripcion, c.tipo_racion, p.nombre_proveedor) ra 
					 WHERE 1 = 1";

		    if($_POST["is_custom_search"] == "yes")
			{
				if( !empty($_POST["proveedor"]) ){
					$sql .= ' AND ra.nit LIKE "'.$_POST["proveedor"].'"';
				}
			}         

			if(!empty($_POST["search"]["value"]))
			{
				$sql .= ' AND (ra.ieo LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR ra.tipo_racion LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR ra.nombre_proveedor LIKE "%'.$_POST["search"]["value"].'%") ';
			}

			if(isset($_POST["order"]))
			{
				$sql .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$sql .= ' ORDER BY ra.descripcion DESC ';
			}

			$proveedores = $db->sql_exec($sql);

			if( $proveedores ){
			 	$totalglobal = mysqli_num_rows($proveedores); 
			} 
			 
			if($_POST["length"] != -1)
			{
				$sql .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

		    $proveedores = $db->sql_exec($sql);

		    if( $proveedores ){
			    $totalFiltered = mysqli_num_rows($proveedores);  

			    if( $totalFiltered > 0 ){
					$data = array();
					
					while( $row = mysqli_fetch_array($proveedores) ) { 
					 // preparing an array

						$nestedData[] = array(
							$columns[0]    => $row["ieo"],
							$columns[1]    => $row["tipo_racion"],
							$columns[2]    => $row["raciones_primaria"],
							$columns[3]    => $row["raciones_secundaria"],
							$columns[4]    => $row["total_raciones"],
						);

					}

					$data = $nestedData;

					$json_data = array(
						"draw"            => intval($_POST["draw"]),
						"recordsTotal"    => intval( $totalFiltered ), 
						"recordsFiltered" => intval( $totalglobal ),
						"data"            => $data 
					);


				}else{
					$json_data = array(
						"draw"            => intval($_POST["draw"]),
						"recordsTotal"    => intval( 0 ), 
						"recordsFiltered" => intval( 0 ),
						"data"            => '' 
					);

				}

			}else{

				$json_data = array(
						"draw"            => intval($_POST["draw"]),
						"recordsTotal"    => intval( 0 ), 
						"recordsFiltered" => intval( 0 ),
						"data"            => '' 
				);	
			} 

			echo json_encode($json_data);

	        break;

	        case 'consultar_raciones_por_usuario':

	    	$sql = " SELECT p.nombre_proveedor proveedor, sc.id_instituciones institucionid, i.descripcion institucion, sc.id sedeid, 
	    			 sc.descripcion sede, sc.direccion, cc.descripcion comuna, c.numero_contrato, c.raciones_programadas_primaria, 
	    			 c.raciones_programadas_secundaria, c.tipo_racion, i.coddane
		             FROM mat_instituciones i, ali_contrato c, mat_sedes sc, ali_proveedor p,
		             mat_comunas_corregimientos cc
		             WHERE
		             sc.coddane = i.coddane
		             AND c.sede_id = sc.id
		             AND p.id = c.proveedor_id
		             AND cc.id = sc.id_comunas_corregimientos
		             AND c.user_id = " .$_POST['user']. " ";

		    $instituciones = $db->sql_exec($sql);     
		    
		    if( $instituciones ){

		    	$totalFiltered = mysqli_num_rows($instituciones);  

			    if( $totalFiltered > 0 ){

			    	$row = mysqli_fetch_array($instituciones);

			    	$json_data = array(
			        	"success"               => true,     
						"proveedor"             => $row['proveedor'],
						"institucion"           => $row['institucion'],
						"sede"                  => $row['sede'],
						"direccion"             => $row['direccion'],
						"comuna"                => $row['comuna'],
						"numero_contrato"       => $row['numero_contrato'],
						"raciones_programadas_pp"  => $row['raciones_programadas_primaria'],
						"raciones_programadas_s"  => $row['raciones_programadas_secundaria'],
						"tipo_racion"           => $row['tipo_racion'],
						"sede_id"               => $row['sedeid'],
						"institucion_id"        => $row['institucionid'],
						"dane"					=> $row['coddane'],
					);

			    }else{

			    	$json_data = array(
			        	"success"     => false,     
						"message"    => 'No hay datos asignados',
					);

			    }

		    }else{

		    	$json_data = array(
			        "success"     => false,     
					"message"    => 'Problemas al ejecutar la consulta para cargar datos de la institución',
				);	

		    }        

			echo json_encode($json_data);

	        break;

	        case 'consulta_entrega_raciones':

	    	$sql = " SELECT ar.institucion_id, ms.descripcion ieo, ar.tipo_racion, ms.coddane,
					 SUM(ar.primaria) raciones_primaria,
					 SUM(ar.secundaria) raciones_secundaria,
			         ( (ar.primaria + ar.secundaria) * COUNT(ar.contrato_numero) ) as total_raciones,  
			         COUNT(ar.contrato_numero) as dias_atendidos,
			         'institucion' as tipo
					 FROM ali_contrato c, ali_registros ar, mat_instituciones i, mat_sedes ms
					 WHERE
					 c.numero_contrato = ar.contrato_numero
					 AND ar.institucion_id = i.id
					 AND i.coddane = ms.coddane
					 AND ms.id = ar.sede_id
                     AND ms.id = c.sede_id
					 AND c.user_id = ".$current_userID."
					 AND date_format(str_to_date(ar.fecha_registro, '%d/%m/%Y'), '%Y-%m') = '" . $_POST['mes'] . "'
                     GROUP BY ar.institucion_id, ar.tipo_racion
					 UNION
					 SELECT ar.sede_id,  ms.descripcion ieo, ar.tipo_racion, ms.coddane,
					 SUM(ar.primaria) raciones_primaria,
					 SUM(ar.secundaria) raciones_secundaria,
			         ( (ar.primaria + ar.secundaria) * COUNT(ar.contrato_numero) ) as total_raciones, 
			         COUNT(ar.contrato_numero) as dias_atendidos,
			         'sede' as tipo
					 FROM ali_contrato c, ali_registros ar, mat_sedes ms, mat_instituciones i
					 WHERE
					 c.numero_contrato = ar.contrato_numero
					 AND ar.sede_id = ms.id
                     AND ar.institucion_id = i.id
                     AND ms.coddane <> i.coddane
                     ANd ms.id = c.sede_id
                     AND c.user_id = ".$current_userID."
                     AND date_format(str_to_date(ar.fecha_registro, '%d/%m/%Y'), '%Y-%m') = '" . $_POST['mes'] . "'
					 GROUP BY ar.sede_id, ar.tipo_racion ";

		    $raciones = $db->sql_exec($sql); 
		    
		    if( $raciones ){

		    	$totalFiltered = mysqli_num_rows($raciones);  

			    if( $totalFiltered > 0 ){			    

			    	while( $row = mysqli_fetch_array($raciones) ) { 

			    			$sqlArchivo = " SELECT adjunto from ali_Cer_EntregasR_D
			    				    WHERE consecut LIKE '" . $row['coddane'] . $row['tipo_racion'] . $_POST['mes'] . "' ";

					    	$row_archivo = $db->sql_exec($sqlArchivo); 
					    	
					    	$row_arch = mysqli_fetch_array($row_archivo);

					    	$institucion[] = array(
					        	"institucion_id"             => $row['institucion_id'],     
								"institucion"             	 => $row['ieo'],
								"coddane"             	     => $row['coddane'],
								"tipo_racion"             	 => $row['tipo_racion'],
								"raciones_primaria"			 => $row['raciones_primaria'],
								"raciones_secundaria"		 => $row['raciones_secundaria'],
								"total_raciones"			 => $row['total_raciones'],
								"dias_atendidos"			 => $row['dias_atendidos'],
								"tipo"			 			 => $row['tipo'],
								"archivo"					 => (!empty($row_arch['adjunto']))?$row_arch['adjunto']:'',
							);

			    	}

			    	$json_data = array(
			        	"success"     => true,
			        	"instituciones"    => $institucion,
					);

			    }else{

			    	$json_data = array(
			        	"success"     => false,     
						"message"    => 'No se encontraron resultados',
					);

			    }

		    }else{

		    	$json_data = array(
			        "success"     => false,     
					"message"    => 'Problemas al ejecutar la consulta para cargar datos de la institución',
				);	

		    }        

			echo json_encode($json_data);
	        
	        break;

	        case 'registra_entrega_raciones':
	        	try{

	        		$target_path = "uploads/";
	        		$error = 0;

		        	for($i=0; $i<count($_FILES['soporte_anexo']['name']); $i++){

						if( !empty($_FILES['soporte_anexo']['name'][$i]) ){

							$tipo_racion = "";
							$coddane = "";
							$new_path = "";
							$mesanio = "";
							$id_archivo = "";
							$nombre_archivo = "";

							$mesanio = str_replace("/", "-", $_POST['mes']);
							$tipo_racion = str_replace("/", "-", $_POST['tipo_racion'][$i]);
							$coddane = $_POST['coddane'][$i];
							$id_archivo = $coddane . $tipo_racion;
							$consecutivo = $coddane . $_POST['tipo_racion'][$i] . $mesanio;

							$ext = explode('.', basename( $_FILES['soporte_anexo']['name'][$i]));

							$new_path = $target_path . $coddane . $tipo_racion . $mesanio . "." . $ext[count($ext)-1]; 
							$nombre_archivo = $coddane . $tipo_racion . $mesanio . "." . $ext[count($ext)-1];

							if($_FILES['soporte_anexo']['size'][$i] <= 2097152) {							

								try{

									if(move_uploaded_file($_FILES['soporte_anexo']['tmp_name'][$i], $new_path)) {

										$db_data = array(
								    		"consecut"				=> $consecutivo,
								    		"tipo_racion"			=> $_POST['tipo_racion'][$i],
								    		"adjunto"				=> $nombre_archivo,
								    		"fecha_ingreso"			=> date("Y-m-d"),
								    	);

										$archivos = $db->insert("ali_Cer_EntregasR_D", $db_data);

										if($archivos){
										    $json_archivo[] = array(  
										    	"success"    => true, 
												"message"    => 'se ha subido satisfactoriamente el archivo',
												"id_archivo" => $id_archivo,
												"nombre_archivo" => $nombre_archivo,
											);
										}else{
											$json_archivo[] = array(  
										    	"success"    => false, 
												"message"    => 'No es posible subir el archivo',
												"id_archivo" => $id_archivo,
												"nombre_archivo" => $nombre_archivo,
											);

											$error++;

										}
									} else{
									    $json_archivo[] = array(
									    	"success"    => false,     
											"message"    => 'No es posible subir el archivo',
											"id_archivo" => $id_archivo,
											"nombre_archivo" => $nombre_archivo,
										);

										$error++;
									}

								} catch (Exception $e) {
									$json_archivo[] = array(
											"success"    => false,     
											"message"    => $e->getMessage(),
											"id_archivo" => $id_archivo,
											"nombre_archivo" => $nombre_archivo,
										);

									$error++;

								    exit;
								}
							}else{
								$json_archivo[] = array(
										"success"    => false,    
										"message"    => "Archivo excede el tamaño permitido",
										"id_archivo" => $id_archivo,
										"nombre_archivo" => $nombre_archivo,
								);	

								$error++;
							}
						}
					}

				} catch (Exception $e) {
					$json_data = array(
					       	"success"     => false,     
							"message"    => $e->getMessage()
						);
				    exit;
				}

				if($error == 0){

					$json_data = array(
						"success"     => true,
						"archivos"    => $json_archivo,     
					);

				}else{

					$json_data = array(
						"success"     => false,
						"archivos"    => $json_archivo,     
					);

				}

				echo json_encode($json_data);
					
	        break;
} 

?>