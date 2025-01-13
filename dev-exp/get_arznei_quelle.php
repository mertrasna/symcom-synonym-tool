<?php
	include '../config/route.php';
	include 'sub-section-config.php';
	/*
	* Fetching sources/quelle of a particular arznei 
	*/
?>
<?php
	$sourceArray = array();
	if(isset($_POST['arznei_id']) AND $_POST['arznei_id'] != ""){

		$quelleArzneiResult = mysqli_query($db,"SELECT AQ.quelle_id, Q.code, Q.titel, Q.jahr, Q.band, Q.nummer, Q.auflage, Q.quelle_type_id, Q.autor_or_herausgeber as bucher_autor_or_herausgeber, autor.suchname as zeitschriften_autor_suchname, autor.vorname as zeitschriften_autor_vorname, autor.nachname as zeitschriften_autor_nachname, QIM.is_symptoms_available_in_de, QIM.is_symptoms_available_in_en, QIM.is_synonyms_up_to_date, QIM.arznei_id FROM arznei_quelle as AQ JOIN quelle as Q ON AQ.quelle_id = Q.quelle_id LEFT JOIN quelle_autor ON Q.quelle_id = quelle_autor.quelle_id LEFT JOIN autor ON quelle_autor.autor_id = autor.autor_id JOIN quelle_import_master as QIM ON Q.quelle_id = QIM.quelle_id WHERE Q.is_materia_medica = 1 AND Q.comparison_save_status = 2 AND AQ.arznei_id = '".$_POST['arznei_id']."' AND QIM.arznei_id = '".$_POST['arznei_id']."' GROUP BY AQ.quelle_id ORDER BY Q.jahr ASC");
		while($quelleArzneiRow = mysqli_fetch_array($quelleArzneiResult)){
			$data = array();
			$preComMaster = $db->query("SELECT id FROM pre_comparison_master_data where arznei_id = '".$quelleArzneiRow['arznei_id']."' AND (initial_source = '".$quelleArzneiRow['quelle_id']."' OR FIND_IN_SET('".$quelleArzneiRow['quelle_id']."', comparing_sources) > 0)");
			if($preComMaster->num_rows == 0){

				// $quellen_value = $quelleArzneiRow['code'];
				// if(!empty($quelleArzneiRow['jahr'])) $quellen_value .= ($quellen_value != "") ? ', '.$quelleArzneiRow['jahr'] : $quelleArzneiRow['jahr'];
				// if($quelleArzneiRow['code'] != $quelleArzneiRow['titel'])
				// 	if(!empty($quelleArzneiRow['titel'])) $quellen_value .= ', '.$quelleArzneiRow['titel'];
				// if($quelleArzneiRow['quelle_type_id'] == 1){
				// 	if(!empty($quelleArzneiRow['bucher_autor_or_herausgeber'])) $quellen_value .= ', '.$quelleArzneiRow['bucher_autor_or_herausgeber'];
				// }else if($quelleArzneiRow['quelle_type_id'] == 2){
				// 	if(!empty($quelleArzneiRow['zeitschriften_autor_suchname']) ) 
				// 		$zeitschriften_autor = $quelleArzneiRow['zeitschriften_autor_suchname']; 
				// 	else 
				// 		$zeitschriften_autor = $quelleArzneiRow['zeitschriften_autor_vorname'].' '.$quelleArzneiRow['zeitschriften_autor_nachname'];
				// 	if(!empty($zeitschriften_autor)) $quellen_value .= ', '.$zeitschriften_autor;
				// }

				$quellen_value = "";
				if($quelleArzneiRow['quelle_type_id'] == 1 OR $quelleArzneiRow['quelle_type_id'] == 2){
					$quellen_value = "";
					$quellen_value = getQuelleAbbreviationForMainSection($quelleArzneiRow['quelle_id']);
					$quellen_value .= ($quellen_value != "") ? ', '.$quelleArzneiRow['titel'] : $quelleArzneiRow['titel'];
				} else {
					// $quellen_value = $quelleArzneiRow['code'];
					$quellen_value = getQuelleAbbreviationForMainSection($quelleArzneiRow['quelle_id']);
				}

				if($quelleArzneiRow['quelle_type_id'] == 3)
					$preparedQuelleCode = $quelleArzneiRow['code'];
				else{
					if($quelleArzneiRow['jahr'] != "" AND $quelleArzneiRow['code'] != "")
						$rowQuelleCode = trim(str_replace(trim($quelleArzneiRow['jahr']), '', $quelleArzneiRow['code']));
					else
						$rowQuelleCode = trim($quelleArzneiRow['code']);
					$preparedQuelleCode = trim($rowQuelleCode." ".$quelleArzneiRow['jahr']);
				}
				
				$data['source'] = $quellen_value;
				$data['quelle_type_id'] = $quelleArzneiRow['quelle_type_id'];
				$data['quelle_id'] = $quelleArzneiRow['quelle_id'];
				$data['is_symptoms_available_in_de'] = $quelleArzneiRow['is_symptoms_available_in_de'];
				$data['is_symptoms_available_in_en'] = $quelleArzneiRow['is_symptoms_available_in_en'];
				$data['is_synonyms_up_to_date'] = $quelleArzneiRow['is_synonyms_up_to_date'];
				$data['quelle_code'] = $preparedQuelleCode;
				$data['year'] = $quelleArzneiRow['jahr'];
				$sourceArray[] = $data;
			}
		}
	}

	echo json_encode( $sourceArray ); 
	exit;
?>