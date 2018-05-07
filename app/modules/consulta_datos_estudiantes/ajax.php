<?php
	
	require_once '../../config/autoload.php';

	switch ($_POST['action']) {
    
	    case 'listar_registros':

			$columns = array(
				"tipodoc",
				"documento",
				"apellido1",
				"apellido2",
				"nombre1",
				"nombre2",
				"grado",
				"grupo",
				"institucion",
				"sede",
				"jornada",
				"lectivo",
				"acciones"
			);

			$sql = " SELECT DISTINCT
                                    est.abr_tipo_identificacion tipodoc
                                    ,est.numero_identificacion  documento
                                    ,est.apellido1              apellido1
                                    ,est.apellido2              apellido2
                                    ,est.nombre1                nombre1
                                    ,est.nombre2                nombre2                                    
                                    ,niv.descripcion            grado
                                    ,par.descripcion            grupo
                                    ,inst.descripcion           institucion
                                    ,se.descripcion             sede
                                    ,jor.descripcion            jornada
                                    ,mtr.anio_lectivo           anio_lectivo
                                    FROM 
                                    mat_estudiantes                             est
                                    LEFT OUTER JOIN mat_matriculas              mtr  ON  mtr.id_estudiantes            =  est.id
                                    LEFT OUTER JOIN mat_paralelos               par  ON  mtr.id_paralelos              =  par.id
                                    LEFT OUTER JOIN mat_sedes_niveles           sn   ON  par.id_sedes_niveles          =   sn.id
                                    LEFT OUTER JOIN mat_sedes                   se   ON   sn.id_sedes                  =   se.id
                                    LEFT OUTER JOIN mat_instituciones           inst ON   se.id_instituciones          = inst.id
                                    LEFT OUTER JOIN mat_sectores                sec  ON inst.id_sectores               =  sec.id
                                    LEFT OUTER JOIN mat_niveles                 niv  ON   sn.id_niveles                =  niv.id
                                    LEFT OUTER JOIN mat_barrios_veredas         bv   ON   se.id_barrios_veredas        =   bv.id
                                    LEFT OUTER JOIN mat_comunas_corregimientos  cc   ON   bv.id_comunas_corregimientos =   cc.id
                                    LEFT OUTER JOIN mat_sedes_jornadas          sj   ON  par.id_sedes_jornadas         =   sj.id
                                    LEFT OUTER JOIN mat_jornadas                jor  ON   sj.id_jornadas               =  jor.id

                                    LEFT OUTER JOIN mat_ie_usuarios us     ON inst.coddane = us.institucion_coddane

                                    WHERE 
                                        sec.descripcion = 'OFICIAL' ";
                                    /*AND  us.user_id     = $userId

                                    AND inst.descripcion like '%xinstitucion%'
                                    AND inst.coddane     like '%xdanesede%'
                                    AND se.descripcion   like '%xsede%'
                                    AND niv.descripcion  like '%xgrado%'
                                    AND par.descripcion  like '%xgrupo%' ";*/

		    if($_POST["is_custom_search"] == "yes")
			{
				if( !empty($_POST["institucion"]) ){
					$sql .= ' AND se.coddane LIKE "'.$_POST["institucion"].'"';
				}

				if( !empty($_POST["grado"]) ){
					$sql .= ' AND niv.descripcion LIKE "'.$_POST["grado"].'"';
				}

				if( !empty($_POST["grupo"]) ){
					$sql .= ' AND par.descripcion LIKE "'.$_POST["grupo"].'"';
				}

				if( !empty($_POST["vigencia"]) ){
					$sql .= ' AND mtr.anio_lectivo LIKE "'.$_POST["vigencia"].'"';
				}
			}         

			if(!empty($_POST["search"]["value"]))
			{
				$sql .= ' AND (est.abr_tipo_identificacion LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR est.numero_identificacion LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR est.apellido1 LIKE "%'.$_POST["search"]["value"].'%" 
			  				OR est.apellido2 LIKE "%'.$_POST["search"]["value"].'%"
			  				OR est.nombre1 LIKE "%'.$_POST["search"]["value"].'%"
			  				OR est.nombre2 LIKE "%'.$_POST["search"]["value"].'%"
			  				OR niv.descripcion LIKE "%'.$_POST["search"]["value"].'%"
			  				OR par.descripcion LIKE "%'.$_POST["search"]["value"].'%"
			  				OR inst.descripcion LIKE "%'.$_POST["search"]["value"].'%"
			  				OR se.descripcion LIKE "%'.$_POST["search"]["value"].'%"
			  				OR jor.descripcion LIKE "%'.$_POST["search"]["value"].'%"
			  				OR mtr.anio_lectivo LIKE "%'.$_POST["search"]["value"].'%") ';
			}

			if(isset($_POST["order"]))
			{
				$sql .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$sql .= ' ORDER BY se.coddane DESC ';
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
							$columns[0]    => $row["tipodoc"],
							$columns[1]    => $row["documento"],
							$columns[2]    => $row["apellido1"],
							$columns[3]    => $row["apellido2"],
							$columns[4]    => $row["nombre1"],
							$columns[5]    => $row["nombre2"],
							$columns[6]    => $row["grado"],
							$columns[7]    => $row["grupo"],
							$columns[8]    => $row["institucion"],
							$columns[9]    => $row["sede"],
							$columns[10]   => $row["jornada"],
							$columns[11]   => $row["anio_lectivo"],
							$columns[12]   => "<div style='width:100px'> 
			                                   <a class='btn btn-outline-primary' data-url='views/info_estudiante.php' data-title='Información Estudiante' 
			                                   data-toggle='modal' data-target='#load-modal' data-backdrop='static' data-id='" . $row["documento"] . "' href='#''>
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

	} 

?>