<?php
	include '../config/route.php';
	include 'sub-section-config.php';
	// include '../api/mainCall.php';
?>
<?php
	$masterId = (isset($_GET['mid']) AND $_GET['mid'] != "") ? $_GET['mid'] : ""; 
	if($masterId == ""){
		header('Location: '.$baseUrl);
		exit();
	}
?>
<?php
$_SESSION['current_page'] = $actual_link;
// $baseUrl = 'http://www.newrepertory.com/comparenew/';
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Symptoms</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/jasny-bootstrap/jasny-bootstrap.min.css">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/bootstrap/dist/css/bootstrap.min.css">
  <!-- dropify -->
  <link rel="stylesheet" type="text/css" href="<?php echo $absoluteUrl;?>plugins/dropify/css/dropify.min.css">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/font-awesome/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/font-awesome/css/fontawesome-all.min.css">
  <!-- <link rel="stylesheet" href="<?php echo $baseUrl;?>plugins/font-awesome/css/fontawesome-all.min.css"> -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/skins/_all-skins.min.css">
  <!-- Jquery UI-->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/jquery-ui/themes/base/jquery-ui.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- sweet alert 2 -->
  <link rel="stylesheet" type="text/css" href="<?php echo $absoluteUrl;?>plugins/sweetalert2/sweetalert2.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/AdminLTE.min.css"> -->
  <!-- custom css -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/custom.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <?php if(preg_match("/quellen/", $actual_link) || preg_match("/zeitschriften/", $actual_link)) {
  ?>
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/custom-datepicker.css">
  <?php } ?>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 symptoms-container">
            <?php
                $quellen_value = "";
                $importedLanguage = "";
                $quelleResult = mysqli_query($db,"SELECT quelle.quelle_id, quelle.code, quelle.titel, quelle.jahr, quelle.band, quelle.nummer, quelle.auflage, quelle.quelle_type_id, quelle.autor_or_herausgeber as bucher_autor_or_herausgeber, autor.suchname as zeitschriften_autor_suchname, autor.vorname as zeitschriften_autor_vorname, autor.nachname as zeitschriften_autor_nachname, quelle_import_master.importing_language FROM quelle JOIN quelle_import_master ON quelle.quelle_id = quelle_import_master.quelle_id LEFT JOIN quelle_autor ON quelle.quelle_id = quelle_autor.quelle_id LEFT JOIN autor ON quelle_autor.autor_id = autor.autor_id WHERE quelle_import_master.id = '".$masterId."' ORDER BY quelle.quelle_type_id ASC");
                if(mysqli_num_rows($quelleResult) > 0){
                    $quelleRow = mysqli_fetch_assoc($quelleResult);

                    $importedLanguage = $quelleRow['importing_language'];
                    $quellen_value = $quelleRow['code'];
                    if($quelleRow['quelle_type_id'] != 3){
                        // if(!empty($quelleRow['jahr'])) $quellen_value .= ', '.$quelleRow['jahr'];
                        // if(!empty($quelleRow['titel'])) $quellen_value .= ', '.$quelleRow['titel'];
                        // if($quelleRow['quelle_type_id'] == 1){
                        // 	if(!empty($quelleRow['bucher_autor_or_herausgeber'])) $quellen_value .= ', '.$quelleRow['bucher_autor_or_herausgeber'];
                        // }else if($quelleRow['quelle_type_id'] == 2){
                        // 	if(!empty($quelleRow['zeitschriften_autor_suchname']) ) 
                        // 		$zeitschriften_autor = $quelleRow['zeitschriften_autor_suchname']; 
                        // 	else 
                        // 		$zeitschriften_autor = $quelleRow['zeitschriften_autor_vorname'].' '.$quelleRow['zeitschriften_autor_nachname'];
                        // 	if(!empty($zeitschriften_autor)) $quellen_value .= ', '.$zeitschriften_autor;
                        // }

                        $quellen_value = (!empty($quelleRow['titel'])) ? $quelleRow['titel'] : "";
                        if($quelleRow['quelle_type_id'] == 1){
                            if(!empty($quelleRow['bucher_autor_or_herausgeber'])) $quellen_value .= ', '.$quelleRow['bucher_autor_or_herausgeber'];
                        }else if($quelleRow['quelle_type_id'] == 2){
                            if(!empty($quelleRow['zeitschriften_autor_suchname']) ) 
                                $zeitschriften_autor = $quelleRow['zeitschriften_autor_suchname']; 
                            else if($quelleRow['zeitschriften_autor_vorname'] != "" AND $quelleRow['zeitschriften_autor_nachname'] != "") 
                                $zeitschriften_autor = $quelleRow['zeitschriften_autor_vorname'].' '.$quelleRow['zeitschriften_autor_nachname'];
                            else
                                $zeitschriften_autor = "";
                            if(!empty($zeitschriften_autor)) $quellen_value .= ', '.$zeitschriften_autor;
                        }
                        if(!empty($quelleRow['jahr'])) $quellen_value .= ', '.$quelleRow['jahr'];

                        /*if(!empty($quelleRow['jahr'])) $quellen_value .= ' '.$quelleRow['jahr'];
                        if(!empty($quelleRow['band'])) $quellen_value .= ', Band: '.$quelleRow['band'];
                        if(!empty($quelleRow['nummer'])) $quellen_value .= ', Nr.: '. $quelleRow['nummer'];
                        if(!empty($quelleRow['auflage'])) $quellen_value .= ', Auflage: '. $quelleRow['auflage'];*/
                    }
                    // if(!empty($quelleRow['titel']))
                    // 	$quellen_value = $quelleRow['titel'];
                    // else
                    // 	$quellen_value = rtrim(trim($quellen_value),",");
                    $quellen_value = rtrim(trim($quellen_value),",");
                }

            ?>
            <h2>Symptoms of Source:  <?php echo $quellen_value; ?></h2>   
            <div class="spacer"></div>    
            <ul class="head-checkbox-panel-before-table">
                <li><label>Open translations </label></li>
                <li>
                    <label class="checkbox-inline">
                            <input class="show-all-translation" name="show_all_translation" id="show_all_translation" type="checkbox" value="1">All
                    </label>
                </li>
            </ul>  
            <div class="">          
                <table class="table full-symptom-details-table table-bordered table-sticky-head table-hover">
                    <thead>
                        <tr>
                            <th style="width:2%;">Symp- tom No (@N)</th>
                            <th style="width:2%;">Page (@S)</th>
                            <th style="width: 8%;">Imported symptom</th>
                            <th style="width: 8%;">Original symptom</th>
                            <!-- <th style="width: 8%;">Converted symptom</th> -->
                            <th style="width: 8%;">Converted symptom</th>
                            <th style="width: 8%;">Graduation (@G)</th>
                            <th style="width: 6%;">Synonyms</th>
                            <th style="width: 4%;">Bracketed part</th>
                            <th style="width: 3%;">Time (@Z)</th>
                            <th style="width: 3%;">Prover (@P)</th>
                            <th style="width: 4%;">Reference (@L)</th>
                            <th>Remedy(@A)</th>
                            <th>Symptom Type</th>
                            <th>Symptom Of Different Remedy(@AT/@TA)</th>
                            <th>Footnote (@F)</th>
                            <th>Chapter information</th>
                            <th>Modality</th>
                            <th>Symptom edit comment</th>
                            <th>Hint (@V)</th>
                            <th>Chapter (@K)</th>
                            <th>Comment (@C)</th> <!-- Kommentar -->
                            <th>Ambiguities (@U)</th> <!-- Unklarheiten -->
                            <th>Theta Diagnosis</th> <!-- Unklarheiten -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php                                                               
                            $result = mysqli_query($db,"SELECT * FROM quelle_import_test WHERE master_id = '".$masterId."' ORDER BY id ASC"); 
                            while($row = mysqli_fetch_array($result)){   
                                $originSourceYear = "";
                                $originSourceLanguage = "";
                                $originQuelleResult = mysqli_query($db,"SELECT quelle.jahr, quelle.quelle_type_id, quelle.sprache FROM quelle WHERE quelle.quelle_id = '".$row['original_quelle_id']."'");
                                if(mysqli_num_rows($originQuelleResult) > 0){
                                    $originQuelleRow = mysqli_fetch_assoc($originQuelleResult);
                                    $originSourceYear = $originQuelleRow['jahr'];
                                    if($originQuelleRow['sprache'] == "deutsch")
                                        $originSourceLanguage = "de";
                                    else if($originQuelleRow['sprache'] == "englisch") 
                                        $originSourceLanguage = "en";
                                }
                                if($originSourceLanguage != ""){
                                    $importedSymptom = ""; 
                                    $originalSymptom = ""; 
                                    $symptomIdToSend = ($row['original_symptom_id'] != "") ? $row['original_symptom_id'] : $row['id'];
                                    $originalSymptom_de = ($row['BeschreibungOriginal_de'] != "") ? convertSymptomToOriginal($symptomIdToSend, $row['BeschreibungOriginal_de'], $row['original_quelle_id'], $row['arznei_id']) : ""; 
                                    $originalSymptom_en = ($row['BeschreibungOriginal_en'] != "") ? convertSymptomToOriginal($symptomIdToSend, $row['BeschreibungOriginal_en'], $row['original_quelle_id'], $row['arznei_id']) : "";
                                   

                                    $convertedSymptom = ""; 
                                    $convertedSymptomFull = ""; 
                                    // [5th parameter] $isFinalVersionAvailable values (0 = No, 1 = Connect edit, 2 = Paste edit)
                                    // convertTheSymptom(0, $row['searchable_text_de'], $row['original_quelle_id'], $row['arznei_id'], 0)
                                    $convertedSymptom_de = ($row['searchable_text_de'] != "") ? convertTheSymptom(0, $row['searchable_text_de'], $row['original_quelle_id'], $row['arznei_id'], 0, 0, $row['id'], $row['original_symptom_id']) : ""; 
                                    $convertedSymptom_en = ($row['searchable_text_en'] != "") ? convertTheSymptom(0, $row['searchable_text_en'], $row['original_quelle_id'], $row['arznei_id'], 0, 0, $row['id'], $row['original_symptom_id']) : ""; 
                                    

                                    $convertedSymptomFull_de = ($row['BeschreibungFull_de'] != "") ? convertTheSymptom(0, $row['BeschreibungFull_de'], $row['original_quelle_id'], $row['arznei_id'], 0, 0, $row['id'], $row['original_symptom_id']) : ""; 
                                    $convertedSymptomFull_en = ($row['BeschreibungFull_en'] != "") ? convertTheSymptom(0, $row['BeschreibungFull_en'], $row['original_quelle_id'], $row['arznei_id'], 0, 0, $row['id'], $row['original_symptom_id']) : "";
                                    $bracketedPart = "";
                                    $time = "";

                                    $graduation = "";
                                    // [5th parameter] $isFinalVersionAvailable values (0 = No, 1 = Connect edit, 2 = Paste edit)
                                    // [6th parameter(Optional)] $includeGrade values (0 = Gragde number will not include, 1 = Will include Grade number)
                                    // convertTheSymptom(0, $row['searchable_text_de'], $row['original_quelle_id'], $row['arznei_id'], 0, 1)
                                    
                                    $graduation_de = ($row['searchable_text_de'] != "") ? convertTheSymptom(0, $row['searchable_text_de'], $row['original_quelle_id'], $row['arznei_id'], 0, 1, $row['id'], $row['original_symptom_id']) : ""; 
                                    $graduation_en = ($row['searchable_text_en'] != "") ? convertTheSymptom(0, $row['searchable_text_en'], $row['original_quelle_id'], $row['arznei_id'], 0, 1, $row['id'], $row['original_symptom_id']) : "";

                                    // echo htmlentities($row['searchable_text_de'])."<br>";
                                    $row['bracketedString_en'] = rtrim(trim($row['bracketedString_en']), ",");
                                    $row['bracketedString_de'] = rtrim(trim($row['bracketedString_de']), ",");
                                    $row['bracketedString_en'] = ltrim(trim($row['bracketedString_en']), ",");
                                    $row['bracketedString_de'] = ltrim(trim($row['bracketedString_de']), ",");
                                    if($originSourceLanguage == "en"){
                                    // If original source/quelle language is "en"
                                        if($importedLanguage == "de"){
                                            $importedSymptom = ($row['Beschreibung_en'] != "") ? '<div class="table-symptom-cnr table-symptom-en table-original-symptom table-symptom-hidden hidden">'.$row['Beschreibung_en'].'</div>' : "";
                                            $importedSymptom .= ($row['Beschreibung_de'] != "") ? '<div class="table-symptom-cnr table-symptom-de">'.$row['Beschreibung_de'].'</div>' : "";

                                            $originalSymptom = ($originalSymptom_en != "") ? '<div class="table-symptom-cnr table-symptom-en table-original-symptom table-symptom-hidden hidden">'.thetaInItalics($originalSymptom_en).'</div>' : "";
                                            $originalSymptom .= ($originalSymptom_de != "") ? '<div class="table-symptom-cnr table-symptom-de">'.thetaInItalics($originalSymptom_de).'</div>' : "";

                                            $convertedSymptom = ($convertedSymptom_en != "") ? '<div class="table-symptom-cnr table-symptom-en table-original-symptom table-symptom-hidden hidden">'.$convertedSymptom_en.'</div>' : "";
                                            $convertedSymptom .= ($convertedSymptom_de != "") ? '<div class="table-symptom-cnr table-symptom-de">'.$convertedSymptom_de.'</div>' : "";

                                            $convertedSymptomFull = ($convertedSymptomFull_en != "") ? '<div class="table-symptom-cnr table-symptom-en table-original-symptom table-symptom-hidden hidden">'.thetaInItalics($convertedSymptomFull_en).'</div>' : "";
                                            $convertedSymptomFull .= ($convertedSymptomFull_de != "") ? '<div class="table-symptom-cnr table-symptom-de">'.thetaInItalics($convertedSymptomFull_de).'</div>' : "";

                                            $bracketedPart = ($row['bracketedString_en'] != "") ? '<div class="table-symptom-cnr table-symptom-en table-original-symptom table-symptom-hidden hidden">'.$row['bracketedString_en'].'</div>' : "";
                                            $bracketedPart .= ($row['bracketedString_de'] != "") ? '<div class="table-symptom-cnr table-symptom-de">'.$row['bracketedString_de'].'</div>' : "";

                                            $graduation = ($graduation_en != "") ? '<div class="table-symptom-cnr table-symptom-en table-original-symptom table-symptom-hidden hidden">'.$graduation_en.'</div>' : "";
                                            $graduation .= ($graduation_de != "") ? '<div class="table-symptom-cnr table-symptom-de">'.$graduation_de.'</div>' : "";

                                            $time = $row['timeString_de'];
                                        }
                                        else
                                        {
                                            $importedSymptom = ($row['Beschreibung_en'] != "") ? '<div class="table-symptom-cnr table-symptom-en table-original-symptom">'.$row['Beschreibung_en'].'</div>' : "";
                                            $importedSymptom .= ($row['Beschreibung_de'] != "") ? '<div class="table-symptom-cnr table-symptom-hidden table-symptom-de hidden">'.$row['Beschreibung_de'].'</div>' : "";

                                            $originalSymptom = ($originalSymptom_en != "") ? '<div class="table-symptom-cnr table-symptom-en table-original-symptom">'.thetaInItalics($originalSymptom_en).'</div>' : "";
                                            $originalSymptom .= ($originalSymptom_de != "") ? '<div class="table-symptom-cnr table-symptom-hidden table-symptom-de hidden">'.thetaInItalics($originalSymptom_de).'</div>' : "";

                                            $convertedSymptom = ($convertedSymptom_en != "") ? '<div class="table-symptom-cnr table-symptom-en table-original-symptom">'.$convertedSymptom_en.'</div>' : "";
                                            $convertedSymptom .= ($convertedSymptom_de != "") ? '<div class="table-symptom-cnr table-symptom-hidden table-symptom-de hidden">'.$convertedSymptom_de.'</div>' : "";

                                            $convertedSymptomFull = ($convertedSymptomFull_en != "") ? '<div class="table-symptom-cnr table-symptom-en table-original-symptom">'.thetaInItalics($convertedSymptomFull_en).'</div>' : "";
                                            $convertedSymptomFull .= ($convertedSymptomFull_de != "") ? '<div class="table-symptom-cnr table-symptom-hidden table-symptom-de hidden">'.thetaInItalics($convertedSymptomFull_de).'</div>' : "";

                                            $bracketedPart = ($row['bracketedString_en'] != "") ? '<div class="table-symptom-cnr table-symptom-en table-original-symptom">'.$row['bracketedString_en'].'</div>' : "";
                                            $bracketedPart .= ($row['bracketedString_de'] != "") ? '<div class="table-symptom-cnr table-symptom-hidden table-symptom-de hidden">'.$row['bracketedString_de'].'</div>' : "";

                                            $graduation = ($graduation_en != "") ? '<div class="table-symptom-cnr table-symptom-en table-original-symptom">'.$graduation_en.'</div>' : "";
                                            $graduation .= ($graduation_de != "") ? '<div class="table-symptom-cnr table-symptom-hidden table-symptom-de hidden">'.$graduation_de.'</div>' : "";

                                            $time = $row['timeString_en'];
                                        }
                                        // $bracketedPart = $row['bracketedString_en'];
                                        // $time = '<div class="table-symptom-cnr table-symptom-visible table-symptom-en table-original-symptom">'.$row['timeString_en'].'</div>';
                                        // $time .= '<div class="table-symptom-cnr table-symptom-hidden table-symptom-de hidden">'.$row['timeString_de'].'</div>';
                                        // $time = $row['timeString_en'];	
                                    } else {
                                        // Else original source/quelle language is "de"
                                        if($importedLanguage == "en"){
                                            $importedSymptom = ($row['Beschreibung_de'] != "") ? '<div class="table-symptom-cnr table-symptom-de table-original-symptom table-symptom-hidden hidden">'.$row['Beschreibung_de'].'</div>' : "";
                                            $importedSymptom .= ($row['Beschreibung_en'] != "") ? '<div class="table-symptom-cnr table-symptom-en">'.$row['Beschreibung_en'].'</div>' : "";

                                            $originalSymptom = ($originalSymptom_de != "") ? '<div class="table-symptom-cnr table-symptom-de table-original-symptom table-symptom-hidden hidden">'.thetaInItalics($originalSymptom_de).'</div>' : "";
                                            $originalSymptom .= ($originalSymptom_en != "") ? '<div class="table-symptom-cnr table-symptom-en">'.thetaInItalics($originalSymptom_en).'</div>' : "";

                                            $convertedSymptom = ($convertedSymptom_de != "") ? '<div class="table-symptom-cnr table-symptom-de table-original-symptom table-symptom-hidden hidden">'.$convertedSymptom_de.'</div>' : "";
                                            $convertedSymptom .= ($convertedSymptom_en != "") ? '<div class="table-symptom-cnr table-symptom-en">'.$convertedSymptom_en.'</div>' : "";

                                            $convertedSymptomFull = ($convertedSymptomFull_de != "") ? '<div class="table-symptom-cnr table-symptom-de table-original-symptom table-symptom-hidden hidden">'.thetaInItalics($convertedSymptomFull_de).'</div>' : "";
                                            $convertedSymptomFull .= ($convertedSymptomFull_en != "") ? '<div class="table-symptom-cnr table-symptom-en">'.thetaInItalics($convertedSymptomFull_en).'</div>' : "";

                                            $bracketedPart = ($row['bracketedString_de'] != "") ? '<div class="table-symptom-cnr table-symptom-de table-original-symptom table-symptom-hidden hidden">'.$row['bracketedString_de'].'</div>' : "";
                                            $bracketedPart .= ($row['bracketedString_en'] != "") ? '<div class="table-symptom-cnr table-symptom-en">'.$row['bracketedString_en'].'</div>' : "";

                                            $graduation = ($graduation_de != "") ? '<div class="table-symptom-cnr table-symptom-de table-original-symptom table-symptom-hidden hidden">'.$graduation_de.'</div>' : "";
                                            $graduation .= ($graduation_en != "") ? '<div class="table-symptom-cnr table-symptom-en">'.$graduation_en.'</div>' : "";

                                            $time = $row['timeString_en'];
                                        }
                                        else
                                        {
                                            $importedSymptom = ($row['Beschreibung_de'] != "") ? '<div class="table-symptom-cnr table-symptom-de table-original-symptom">'.$row['Beschreibung_de'].'</div>' : "";
                                            $importedSymptom .= ($row['Beschreibung_en'] != "") ? '<div class="table-symptom-cnr table-symptom-hidden table-symptom-en hidden">'.$row['Beschreibung_en'].'</div>' : "";

                                            $originalSymptom = ($originalSymptom_de != "") ? '<div class="table-symptom-cnr table-symptom-de table-original-symptom">'.thetaInItalics($originalSymptom_de).'</div>' : "";
                                            $originalSymptom .= ($originalSymptom_en != "") ? '<div class="table-symptom-cnr table-symptom-hidden table-symptom-en hidden">'.thetaInItalics($originalSymptom_en).'</div>' : "";

                                            $convertedSymptom = ($convertedSymptom_de != "") ? '<div class="table-symptom-cnr table-symptom-de table-original-symptom">'.$convertedSymptom_de.'</div>' : "";
                                            $convertedSymptom .= ($convertedSymptom_en != "") ? '<div class="table-symptom-cnr table-symptom-hidden table-symptom-en hidden">'.$convertedSymptom_en.'</div>' : "";

                                            $convertedSymptomFull = ($convertedSymptomFull_de != "") ? '<div class="table-symptom-cnr table-symptom-de table-original-symptom">'.thetaInItalics($convertedSymptomFull_de).'</div>' : "";
                                            $convertedSymptomFull .= ($convertedSymptomFull_en != "") ? '<div class="table-symptom-cnr table-symptom-hidden table-symptom-en hidden">'.thetaInItalics($convertedSymptomFull_en).'</div>' : "";

                                            $bracketedPart = ($row['bracketedString_de'] != "") ? '<div class="table-symptom-cnr table-symptom-de table-original-symptom">'.$row['bracketedString_de'].'</div>' : "";
                                            $bracketedPart .= ($row['bracketedString_en'] != "") ? '<div class="table-symptom-cnr table-symptom-hidden table-symptom-en hidden">'.$row['bracketedString_en'].'</div>' : "";

                                            $graduation = ($graduation_de != "") ? '<div class="table-symptom-cnr table-symptom-de table-original-symptom">'.$graduation_de.'</div>' : "";
                                            $graduation .= ($graduation_en != "") ? '<div class="table-symptom-cnr table-symptom-hidden table-symptom-en hidden">'.$graduation_en.'</div>' : "";

                                            $time = $row['timeString_de'];
                                        }
                                    }

                                    $resultData['synonym_word'] = displayFormateOfSynonym($row['synonym_word']);
                                    $resultData['strict_synonym'] = displayFormateOfSynonym($row['strict_synonym']);
                                    $resultData['synonym_partial_1'] = displayFormateOfSynonym($row['synonym_partial_1']);
                                    $resultData['synonym_partial_2'] = displayFormateOfSynonym($row['synonym_partial_2']);
                                    $resultData['synonym_general'] = displayFormateOfSynonym($row['synonym_general']);
                                    $resultData['synonym_minor'] = displayFormateOfSynonym($row['synonym_minor']);
                                    $resultData['synonym_nn'] = displayFormateOfSynonym($row['synonym_nn']);
                                    $synonymTxt = "";
                                    if($resultData['synonym_word'] != "")
                                        $synonymTxt .= $resultData['synonym_word']."";
                                    if($resultData['strict_synonym'] != "")
                                        $synonymTxt .= $resultData['strict_synonym']."";
                                    if($resultData['synonym_partial_1'] != "")
                                        $synonymTxt .= $resultData['synonym_partial_1']."";
                                    if($resultData['synonym_partial_2'] != "")
                                        $synonymTxt .= $resultData['synonym_partial_2']."";
                                    if($resultData['synonym_general'] != "")
                                        $synonymTxt .= $resultData['synonym_general']."";
                                    if($resultData['synonym_minor'] != "")
                                        $synonymTxt .= $resultData['synonym_minor']."";
                                    if($resultData['synonym_nn'] != "")
                                        $synonymTxt .= $resultData['synonym_nn']."";

                                    // collecting symptom type info
                                    //symptom type checking code
                                    $stringToCheck = ($row['BeschreibungFull_de'] != "") ? $row['BeschreibungFull_de'] : $row['BeschreibungFull_en'];
                                    $extractedSymptomPartsArrBasedOnCustomTags = symptomStringExtractPartsBasedOnCustomTag($stringToCheck);
                                    $symptomType = fetchSymptomTypeModified($row['id'], $row['original_quelle_id'], $extractedSymptomPartsArrBasedOnCustomTags);
                                    //making the first letter upper case and removing _
                                    $symptomType= ucfirst(str_replace("_"," ",$symptomType));
                                    // echo htmlentities($importedSymptom)."<br>";
                                    // echo htmlentities($originalSymptom)."<br>";
                                    // echo htmlentities($convertedSymptomFull)."<br>"; 
                                ?>
                                    <tr>
                                        <td><?=$row['Symptomnummer']?></td>
                                        <td>
                                            <?php
                                                if($row['SeiteOriginalVon'] == $row['SeiteOriginalBis'])
                                                    echo $row['SeiteOriginalVon'];
                                                else
                                                    echo $row['SeiteOriginalVon']."-".$row['SeiteOriginalBis']
                                            ?>
                                        </td>
                                        <td><?php echo $importedSymptom; ?></td>
                                        <td><?php echo redundantCharacterFixes($originalSymptom); ?></td>
                                        <!--<td><?php //echo $convertedSymptom; ?></td>-->
                                        <td><?php echo redundantCharacterFixes($convertedSymptomFull); ?></td>
                                        <?php /*<td><?=$row['Graduierung']?></td>*/ ?>
                                        <td><?php echo redundantCharacterFixes($graduation); ?></td>
                                        <td class="synonymStyle"><?php echo $synonymTxt; ?></td>
                                        <td><?php echo $bracketedPart; ?></td>
                                        <td><?php echo $time;?></td>
                                        <td>
                                            <?php
                                                $pruStr = "";
                                                $prueferResult = mysqli_query($db,"SELECT pruefer.pruefer_id, pruefer.suchname, pruefer.vorname, pruefer.nachname FROM symptom_pruefer JOIN pruefer ON symptom_pruefer.pruefer_id	= pruefer.pruefer_id WHERE symptom_pruefer.symptom_id = '".$row['id']."'");
                                                while($prueferRow = mysqli_fetch_array($prueferResult)){
                                                    // if($prueferRow['suchname'] != "")
                                                    //     $pruStr .= $prueferRow['suchname'].", ";
                                                    if($prueferRow['vorname'] != "")
                                                        $pruStr .= $prueferRow['vorname']." ";
                                                    if($prueferRow['nachname'] != "")
                                                        $pruStr .= $prueferRow['nachname'].", ";
                                                }
                                                $pruStr =rtrim($pruStr, ", ");
                                                echo $pruStr;
                                            ?>
                                        </td>
                                        <td><?php 
                                                $referenceStr = "";
                                                $refResult = mysqli_query($db,"SELECT reference.reference_id, reference.full_reference FROM symptom_reference JOIN reference ON symptom_reference.reference_id	= reference.reference_id WHERE symptom_reference.symptom_id = '".$row['id']."'");
                                                while($refRow = mysqli_fetch_array($refResult)){
                                                    if($refRow['full_reference'] != "")
                                                        $referenceStr .= ucfirst($refRow['full_reference']);
                                                }
                                                $referenceStr =rtrim($referenceStr, ", ");
                                                echo $referenceStr;
                                                //echo trim(str_replace('No Author,', '', stripslashes($row['EntnommenAus']))); 
                                            
                                            ?></td>
                                        <td>
                                        	<?php
                                        		$rmdStr = "";
                                                $remedyResult = mysqli_query($db,"SELECT arznei.titel FROM symptom_remedy JOIN arznei ON symptom_remedy.remedy_id = arznei.arznei_id WHERE symptom_remedy.symptom_id = '".$row['id']."'");
                                                while($remedyRow = mysqli_fetch_array($remedyResult)){
                                                    if($remedyRow['titel'] != "")
                                                        $rmdStr .= $remedyRow['titel'].", ";
                                                }
                                                $rmdStr =rtrim($rmdStr, ", ");
                                                echo $rmdStr;
                                        	?>                                        	
                                        </td>
                                        <td><?=$symptomType?></td>
                                        <td><?=($row['symptom_of_different_remedy'] != "" AND $row['symptom_of_different_remedy'] != "null") ? $row['symptom_of_different_remedy'] : ""?></td>
                                        <td><?=$row['Fussnote']?></td>
                                        <td><?=unserialize($row['chapter_information'])?></td>
                                        <td><?=$row['modality']?></td>
                                        <td><?=($row['symptom_edit_comment'] != "" AND $row['symptom_edit_comment'] != "null") ? $row['symptom_edit_comment'] : ""?></td>
                                        <td><?=$row['Verweiss']?></td>
                                        <td><?=$row['BereichID']?></td>
                                        <td><?=$row['Kommentar']?></td>
                                        <td><?=$row['Unklarheiten']?></td>
                                        <?php
                                            $thetaPart = "";
                                            $thetaPart = fetchThetaPart($stringToCheck);
                                        ?>
                                        <td><?php echo $thetaPart;?></td>
                                    </tr>
                                <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
            
</div>
<!-- Add synonym modal start -->
<div class="modal fade" id="addSynonymModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="add_symptom_synonym_form" name="add_symptom_synonym_form" action="" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Synonym</h4>
                </div>
                <div id="add_synonym_container" class="modal-body">
                    <div id="add_synonym_modal_loader" class="form-group text-center">
                        <span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
                        <span class="error-msg"></span>
                    </div>
                    <div class="add-synonym-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="language">Language*</label>&nbsp;<span id="synonym_language_error" class="error-text text-danger"></span>
                                    <select id="synonym_language" name="synonym_language" class="form-control">
                                        <option value="">Select</option>
                                        <option value="en">English</option>
                                        <option value="de">German</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="strict_synonym">Striktes Synonym*</label>&nbsp;<span id="strict_synonym_error" class="error-text text-danger"></span>
                                    <input type="text" class="form-control" id="strict_synonym" name="strict_synonym" required>
                                    <small>Fügen Sie kommagetrennte Werte hinzu(i.e.: <b>ache, aching, agony</b>)</small>
                                </div>
                                <div class="form-group">
                                    <label for="synonym_partial_2">Partielles Synonym II</label><span class="error-text"></span>
                                    <input type="text" class="form-control" id="synonym_partial_2" name="synonym_partial_2">
                                    <small>Fügen Sie kommagetrennte Werte hinzu(i.e.: <b>ache, aching, agony</b>)</small>
                                </div>
                                <div class="form-group">
                                    <label for="synonym_minor">Hyponym (Unterbegriff)</label><span class="error-text"></span>
                                    <input type="text" class="form-control" id="synonym_minor" name="synonym_minor">
                                    <small>Fügen Sie kommagetrennte Werte hinzu(i.e.: <b>ache, aching, agony</b>)</small>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Quelle</label>
                                    <div id="quelle_cnr">
                                        <!-- <select class="form-control" name="quelle_id" id="quelle_id">
                                            <option value="">Select</option>
                                        </select>
                                        <span class="error-text"></span> -->
                                        <?php 
                                            $html = '<select class="select2 form-control" name="quelle_id[]" id="quelle_id" multiple="multiple">';
                                            $html .= '<option value="">Select</option>';
                                            $quelleResult = mysqli_query($db,"SELECT quelle.quelle_id, quelle.code, quelle.titel, quelle.jahr, quelle.band, quelle.nummer, quelle.auflage, quelle.quelle_type_id, quelle.autor_or_herausgeber as bucher_autor_or_herausgeber, autor.suchname as zeitschriften_autor_suchname, autor.vorname as zeitschriften_autor_vorname, autor.nachname as zeitschriften_autor_nachname FROM quelle LEFT JOIN quelle_autor ON quelle.quelle_id = quelle_autor.quelle_id LEFT JOIN autor ON quelle_autor.autor_id = autor.autor_id ORDER BY quelle.quelle_type_id ASC");
                                            // $quelleResult = mysqli_query($db,"SELECT quelle.quelle_id, quelle.code, quelle.titel, quelle.jahr, quelle.band, quelle.nummer, quelle.auflage, quelle.quelle_type_id FROM quelle ORDER BY quelle.quelle_type_id ASC");
                                            $htmlBucher = '';
                                            $htmlZeitschriften = '';
                                            $htmlBInner = '';
                                            $htmlZInner = '';
                                            while($quelleRow = mysqli_fetch_array($quelleResult)){
                                                $quellen_value = $quelleRow['code'];
                                                if(!empty($quelleRow['jahr'])) $quellen_value .= ', '.$quelleRow['jahr'];
                                                if(!empty($quelleRow['titel'])) $quellen_value .= ', '.$quelleRow['titel'];
                                                if($quelleRow['quelle_type_id'] == 1){
                                                    if(!empty($quelleRow['bucher_autor_or_herausgeber'])) $quellen_value .= ', '.$quelleRow['bucher_autor_or_herausgeber'];
                                                }else if($quelleRow['quelle_type_id'] == 2){
                                                    if(!empty($quelleRow['zeitschriften_autor_suchname']) ) 
                                                        $zeitschriften_autor = $quelleRow['zeitschriften_autor_suchname']; 
                                                    else 
                                                        $zeitschriften_autor = $quelleRow['zeitschriften_autor_vorname'].' '.$quelleRow['zeitschriften_autor_nachname'];
                                                    if(!empty($zeitschriften_autor)) $quellen_value .= ', '.$zeitschriften_autor;
                                                }
                                                /*if(!empty($quelleRow['jahr'])) $quellen_value .= ' '.$quelleRow['jahr'];
                                                if(!empty($quelleRow['band'])) $quellen_value .= ', Band: '.$quelleRow['band'];
                                                if(!empty($quelleRow['nummer'])) $quellen_value .= ', Nr.: '. $quelleRow['nummer'];
                                                if(!empty($quelleRow['auflage'])) $quellen_value .= ', Auflage: '. $quelleRow['auflage'];*/

                                                if($quelleRow['quelle_type_id'] == 1)
                                                    $htmlBInner .= '<option value="'.$quelleRow['quelle_id'].'">'.$quellen_value.'</option>';
                                                else if($quelleRow['quelle_type_id'] == 2)
                                                    $htmlZInner .= '<option value="'.$quelleRow['quelle_id'].'">'.$quellen_value.'</option>';
                                            }
                                            if($htmlBInner == '')
                                                $htmlBucher .= '<option value="" disabled="disabled">None</option>';
                                            else
                                                $htmlBucher .= $htmlBInner;
                                            if($htmlZInner == '')
                                                $htmlZeitschriften .= '<option value="" disabled="disabled">None</option>';
                                            else
                                                $htmlZeitschriften .= $htmlZInner;

                                            $html .= $htmlBucher;
                                            $html .= $htmlZeitschriften;
                                            $html .= '</select>';
                                            $html .= '<span class="error-text"></span>';
                                            echo $html;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="word">Wort*</label>&nbsp;<span id="word_error" class="error-text text-danger"></span>
                                    <input type="text" class="form-control" id="word" name="word" required>
                                </div>
                                <div class="form-group">
                                    <label for="synonym_partial_1">Partielles Synonym I</label><span class="error-text"></span>
                                    <input type="text" class="form-control" id="synonym_partial_1" name="synonym_partial_1">
                                    <small>Fügen Sie kommagetrennte Werte hinzu(i.e.: <b>ache, aching, agony</b>)</small>
                                </div>
                                <div class="form-group">
                                    <label for="synonym_general">Hyperonym (Oberbegriff)</label><span class="error-text"></span>
                                    <input type="text" class="form-control" id="synonym_general" name="synonym_general">
                                    <small>Fügen Sie kommagetrennte Werte hinzu(i.e.: <b>ache, aching, agony</b>)</small>
                                </div>
                                <div class="form-group">
                                    <label for="synonym_nn">Synonym NN</label><span class="error-text"></span>
                                    <input type="text" class="form-control" id="synonym_nn" name="synonym_nn">
                                    <small>Fügen Sie kommagetrennte Werte hinzu(i.e.: <b>ache, aching, agony</b>)</small>
                                </div>
                                <div class="form-group">
                                    <label for="quelle_comment">Add Comment</label>
                                    <div id="comment_cnr">
                                        <textarea id="quelle_comment" name="quelle_comment" class="form-control" rows= "1" aria-hidden="true" placeholder="Comment"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="modal_quelle_id" id="modal_quelle_id">
                    <input type="hidden" name="modal_arznei_id" id="modal_arznei_id">
                    <input type="hidden" name="modal_quelle_import_master_id" id="modal_quelle_import_master_id">
                    <button type="button" class="btn btn-primary symptom-synonym-modal-submit-btn">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add synonym modal end -->
<!-- Add symptom edit modal start -->
<div class="modal fade" id="editSymptomModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="edit_symptom_form" name="edit_symptom_form" action="" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Symptom</h4>
                </div>
                <div id="edit_symptom_container" class="modal-body">
                    <div id="symptom_edit_preview_container" class="hidden">
                        <h4 class="modal-title">Edited Symptom's Preview</h4>
                        <div class="spacer"></div>
                        <div id="edit_symptom_modal_preview_loader" class="form-group text-center">
                            <span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
                            <span class="error-msg text-danger"></span>
                        </div>
                        <div id="preview_content">
                            <table id="resultTable" class="table table-bordered">
                                <thead class="heading-table-bg">
                                    <tr>
                                        <th style="width: 20%;">Symptom Versions</th>
                                        <th style="width: 2%;">#</th>
                                        <th>Symptom</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th rowspan="2">Imported Symptom</th>
                                        <th>de</th>
                                        <td id="edtied_symptom_imported_version_de">-</td>
                                    </tr>
                                    <tr>
                                        <th>en</th>
                                        <td id="edtied_symptom_imported_version_en">-</td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">Edited Symptom</th>
                                        <th>de</th>
                                        <td id="edtied_symptom_edited_version_de">-</td>
                                    </tr>
                                    <tr>
                                        <th>en</th>
                                        <td id="edtied_symptom_edited_version_en">-</td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">Original Version</th>
                                        <th>de</th>
                                        <td id="edtied_symptom_original_version_de">-</td>
                                    </tr>
                                    <tr>
                                        <th>en</th>
                                        <td id="edtied_symptom_original_version_en">-</td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">Converted Version</th>
                                        <th>de</th>
                                        <td id="edtied_symptom_converted_version_de">-</td>
                                    </tr>
                                    <tr>
                                        <th>en</th>
                                        <td id="edtied_symptom_converted_version_en">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="symptom_edit_container">
                        <!-- Tab start -->
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a data-toggle="tab" href="#symptom_edit">Symptom</a></li> <!-- Fonts -->
                            <li><a data-toggle="tab" href="#symptom_settings">Settings</a></li><!-- Symptom types -->
                        </ul>
                        <div class="tab-content">
                            <!-- symptom edit tab start -->
                            <div id="symptom_edit" class="tab-pane fade in active">
                                <div id="edit_symptom_modal_loader" class="form-group text-center symptom_edit_modal_loader">
                                    <span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
                                    <span class="error-msg text-danger"></span>
                                </div>
                                <div class="edit-symptom-content">
                                    <?php /*<div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="symptom_type">Symptom type</label><span class="error-text"></span>
                                                        <select name="symptom_type" id="symptom_type" class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="proving">Proving symptom</option>
                                                            <option value="intoxication">Intoxication</option>
                                                            <option value="clinical">Clinical symptom</option>
                                                            <option value="proving_intoxication_clinical_not_defined">Proving symptom / Intoxication / Clinical symptom not clearly defined</option>
                                                            <option value="characteristic">Characteristic symptom</option>
                                                            <option value="characteristic_not_defined">Characteristic symptom not clearly identified / defined</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>*/ ?> 
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div><b>Symptom version</b></div>
                                            <label class="radio-inline"><input type="radio" name="symptom_version" value="original" checked>Edit original and converted version.</label>
                                            <label class="radio-inline"><input type="radio" name="symptom_version" value="converted">Edit only converted version.</label>
                                            <div class="spacer"></div>
                                        </div>
                                    </div>
                                    <div id="symptom_edit_de_container" class="row">
                                        <div class="col-sm-12">
                                            <div><b>Symptom(de)</b> <small>Imported version of the symptom is given below for edit.</small></div>
                                            <table id="" class="table table-bordered" style="margin-bottom: 1px; margin-top: 5px;">           
                                                <tbody>                 
                                                    <tr>                        
                                                        <th style="width: 18%;">Original Version</th>                     
                                                        <td id="preview_original_version_de"></td>               
                                                    </tr>                   
                                                    <tr>                        
                                                        <th>Converted Version</th>                     
                                                        <td id="preview_converted_version_de"></td>  
                                                    </tr>               
                                                </tbody>            
                                            </table>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea id="symptom_edit_de" name="symptom_edit_de" class="texteditor-small" aria-hidden="true"></textarea>
                                            <span class="symptom-edit-de-error error-text text-danger"></span>
                                            <div class="spacer"></div>
                                        </div>
                                    </div>
                                    <div id="symptom_edit_en_container" class="row">
                                        <div class="col-sm-12">
                                            <div><b>Symptom(en)</b> <small>Imported version of the symptom is given below for edit.</small></div>
                                            <table id="" class="table table-bordered" style="margin-bottom: 1px; margin-top: 5px;">            
                                                <tbody>                 
                                                    <tr>                        
                                                        <th style="width: 18%;">Original Version</th>                     
                                                        <td id="preview_original_version_en"></td>               
                                                    </tr>                   
                                                    <tr>                        
                                                        <th>Converted Version</th>                     
                                                        <td id="preview_converted_version_en"></td>  
                                                    </tr>               
                                                </tbody>            
                                            </table>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea id="symptom_edit_en" name="symptom_edit_en" class="texteditor-small" aria-hidden="true"></textarea>
                                            <span class="symptom-edit-en-error error-text text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="spacer"></div>
                                            <div><b>Individual Upgrade justification</b></div>
                                            <textarea name="individual_upgrade_justification" id="individual_upgrade_justification" placeholder="Individual Upgrade justification" class="form-control" rows="5" cols="50"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- symptom edit tab end -->
                            <!-- symptom settings tab start -->
                            <div id="symptom_settings" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="" class="form-group text-center symptom_edit_modal_loader">
                                            <span class="loading-msg">Loading informations please wait <img src="assets/img/loader.gif" alt="Loading..."></span>
                                            <span class="error-msg"></span>
                                        </div>
                                    </div>
                                </div>
                                <div id="symptom_edit_settings_container" class="row" style="margin-top: 15px;">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="symptom_type">Symptom type</label><span class="error-text"></span>
                                                    <select name="symptom_type" id="symptom_type" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="proving">Proving symptom</option>
                                                        <option value="intoxication">Intoxication</option>
                                                        <option value="clinical">Clinical symptom</option>
                                                        <option value="proving_intoxication_clinical_not_defined">Proving symptom / Intoxication / Clinical symptom not clearly defined</option>
                                                        <option value="characteristic">Characteristic symptom</option>
                                                        <option value="characteristic_not_defined">Characteristic symptom not clearly identified / defined</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6"></div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Grading settings</h4>
                                        <div class="spacer"></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="normal">Normal</label><span class="error-text pull-right">Normal</span>
                                                    <select name="normal" id="normal" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="normal_within_parentheses">Normal in Klammern</label><span class="error-text pull-right">(Normal)</span> <!-- Normal within parentheses -->
                                                    <select name="normal_within_parentheses" id="normal_within_parentheses" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="normal_end_with_t">Normal mit t.</label><span class="error-text pull-right">Normal, t.</span> <!-- Normal end with t -->
                                                    <select name="normal_end_with_t" id="normal_end_with_t" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="normal_end_with_tt">Normal mit tt.</label><span class="error-text pull-right">Normal, tt.</span> <!-- Normal end with tt -->
                                                    <select name="normal_end_with_tt" id="normal_end_with_tt" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="normal_begin_with_degree">Normal mit ° am Anfang</label><span class="error-text pull-right">°Normal</span> <!-- Normal begin with degree -->
                                                    <select name="normal_begin_with_degree" id="normal_begin_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="normal_end_with_degree">Normal mit ° am Ende</label><span class="error-text pull-right">Normal,°</span> <!-- Normal end with degree -->
                                                    <select name="normal_end_with_degree" id="normal_end_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="normal_begin_with_asterisk">Normal mit * am Anfang</label><span class="error-text pull-right">*Normal</span> <!-- Normal begin with asterisk -->
                                                    <select name="normal_begin_with_asterisk" id="normal_begin_with_asterisk" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="normal_begin_with_asterisk_end_with_t">Normal mit * am Anfang und t.</label><span class="error-text pull-right">*Normal, t.</span> <!-- Normal begin with asterisk end with t -->
                                                    <select name="normal_begin_with_asterisk_end_with_t" id="normal_begin_with_asterisk_end_with_t" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="normal_begin_with_asterisk_end_with_tt">Normal mit * am Anfang und tt.</label><span class="error-text pull-right">*Normal, tt.</span> <!-- Normal begin with asterisk end with tt -->
                                                    <select name="normal_begin_with_asterisk_end_with_tt" id="normal_begin_with_asterisk_end_with_tt" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="normal_begin_with_asterisk_end_with_degree">Normal mit * am Anfang und °</label><span class="error-text pull-right">*Normal,°</span> <!-- Normal begin with asterisk end with degree -->
                                                    <select name="normal_begin_with_asterisk_end_with_degree" id="normal_begin_with_asterisk_end_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sperrschrift">Sperrschrift</label><span class="error-text text-sperrschrift pull-right">Sperrschrift</span>
                                                    <select name="sperrschrift" id="sperrschrift" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sperrschrift_begin_with_degree">Sperrschrift mit ° am Anfang</label><span class="error-text text-sperrschrift pull-right">°Sperrschrift</span> <!-- Sperrschrift begin with degree -->
                                                    <select name="sperrschrift_begin_with_degree" id="sperrschrift_begin_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sperrschrift_begin_with_asterisk">Sperrschrift mit * am Anfang</label><span class="error-text text-sperrschrift pull-right">*Sperrschrift</span><!-- Sperrschrift begin with asterisk -->
                                                    <select name="sperrschrift_begin_with_asterisk" id="sperrschrift_begin_with_asterisk" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="sperrschrift_bold">Sperrschrift fett</label><span class="error-text text-sperrschrift pull-right"><b>Sperrschrift</b></span><!-- Sperrschrift bold -->
                                                    <select name="sperrschrift_bold" id="sperrschrift_bold" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="sperrschrift_bold_begin_with_degree">Sperrschrift fett mit ° am Anfang</label><span class="error-text text-sperrschrift pull-right"><b>°Sperrschrift</b></span><!-- Sperrschrift bold begin with degree -->
                                                    <select name="sperrschrift_bold_begin_with_degree" id="sperrschrift_bold_begin_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="sperrschrift_bold_begin_with_asterisk">Sperrschrift fett mit * am Anfang</label><span class="error-text text-sperrschrift pull-right"><b>*Sperrschrift</b></span> <!-- Sperrschrift bold begin with asterisk -->
                                                    <select name="sperrschrift_bold_begin_with_asterisk" id="sperrschrift_bold_begin_with_asterisk" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kursiv">Kursiv</label><span class="error-text pull-right"><i>Kursiv</i></span>
                                                    <select name="kursiv" id="kursiv" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="kursiv_end_with_t">Kursiv mit t.</label><span class="error-text pull-right"><i>Kursiv, t.</i></span> <!-- Kursiv end with t -->
                                                    <select name="kursiv_end_with_t" id="kursiv_end_with_t" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="kursiv_end_with_tt">Kursiv mit tt.</label><span class="error-text pull-right"><i>Kursiv, tt.</i></span><!-- Kursiv end with tt -->
                                                    <select name="kursiv_end_with_tt" id="kursiv_end_with_tt" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kursiv_begin_with_degree">Kursiv mit ° am Anfang</label><span class="error-text pull-right"><i>°Kursiv</i></span> <!-- Kursiv begin with degree -->
                                                    <select name="kursiv_begin_with_degree" id="kursiv_begin_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kursiv_end_with_degree">Kursiv mit ° am Ende</label><span class="error-text pull-right"><i>Kursiv,°</i></span> <!-- Kursiv end with degree -->
                                                    <select name="kursiv_end_with_degree" id="kursiv_end_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kursiv_begin_with_asterisk">Kursiv mit * am Anfang</label><span class="error-text pull-right"><i>*Kursiv</i></span> <!-- Kursiv begin with asterisk -->
                                                    <select name="kursiv_begin_with_asterisk" id="kursiv_begin_with_asterisk" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="kursiv_begin_with_asterisk_end_with_t">Kursiv mit * am Anfang und t.</label><span class="error-text pull-right"><i>*Kursiv, t.</i></span> <!-- Kursiv begin with asterisk end with t -->
                                                    <select name="kursiv_begin_with_asterisk_end_with_t" id="kursiv_begin_with_asterisk_end_with_t" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="kursiv_begin_with_asterisk_end_with_tt">Kursiv mit * am Anfang und tt.</label><span class="error-text pull-right"><i>*Kursiv, tt.</i></span><!-- Kursiv begin with asterisk end with tt -->
                                                    <select name="kursiv_begin_with_asterisk_end_with_tt" id="kursiv_begin_with_asterisk_end_with_tt" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kursiv_begin_with_asterisk_end_with_degree">Kursiv mit * am Anfang und ° am Ende</label><span class="error-text pull-right"><i>*Kursiv,°</i></span><!-- Kursiv begin with asterisk end with degree -->
                                                    <select name="kursiv_begin_with_asterisk_end_with_degree" id="kursiv_begin_with_asterisk_end_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="kursiv_bold">Kursiv fett</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>Kursiv</b></i></span> <!-- Kursiv bold -->
                                                    <select name="kursiv_bold" id="kursiv_bold" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="kursiv_bold_begin_with_asterisk_end_with_t">Kursiv fett mit * am Anfang und t.</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv, t.</b></i></span> <!-- Kursiv bold begin with asterisk end with t -->
                                                    <select name="kursiv_bold_begin_with_asterisk_end_with_t" id="kursiv_bold_begin_with_asterisk_end_with_t" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="kursiv_bold_begin_with_asterisk_end_with_tt">Kursiv fett mit * am Anfang und tt.</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv, tt.</b></i></span> <!-- Kursiv bold begin with asterisk end with tt -->
                                                    <select name="kursiv_bold_begin_with_asterisk_end_with_tt" id="kursiv_bold_begin_with_asterisk_end_with_tt" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="kursiv_bold_begin_with_degree">Kursiv fett mit ° am Anfang</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>°Kursiv</b></i></span> <!-- Kursiv bold begin with degree -->
                                                    <select name="kursiv_bold_begin_with_degree" id="kursiv_bold_begin_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="kursiv_bold_begin_with_asterisk">Kursiv fett mit * am Anfang</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv</b></i></span> <!-- Kursiv bold begin with asterisk -->
                                                    <select name="kursiv_bold_begin_with_asterisk" id="kursiv_bold_begin_with_asterisk" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="kursiv_bold_begin_with_asterisk_end_with_degree">Kursiv fett mit * am Anfang und ° am Ende</label><span class="error-text kursiv-blod kursiv-blod-example-text pull-right"><i><b>*Kursiv,°</b></i></span> <!-- Kursiv bold begin with asterisk end with degree -->
                                                    <select name="kursiv_bold_begin_with_asterisk_end_with_degree" id="kursiv_bold_begin_with_asterisk_end_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fett">Fett</label> <span class="error-text pull-right"><b>Fett</b></span> 
                                                    <select name="fett" id="fett" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fett_converted_spaced">Fett (konvertierte Sperrschrift)</label> <span class="error-text pull-right text-sperrschrift"><b>Fett</b></span> 
                                                    <select name="fett_converted_spaced" id="fett_converted_spaced" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="fett_end_with_t">Fett mit t.</label><span class="error-text pull-right"><b>Fett, t.</b></span> <!-- Fett end with t -->
                                                    <select name="fett_end_with_t" id="fett_end_with_t" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="fett_end_with_tt">Fett mit tt.</label><span class="error-text pull-right"><b>Fett, tt.</b></span> <!-- Fett end with tt -->
                                                    <select name="fett_end_with_tt" id="fett_end_with_tt" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fett_begin_with_degree">Fett mit ° am Anfang</label><span class="error-text pull-right"><b>°Fett</b></span> <!-- Fett begin with degree -->
                                                    <select name="fett_begin_with_degree" id="fett_begin_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fett_converted_spaced_degree_at_beginning">Fett (konvertierte Sperrschrift) mit ° am Anfang</label><span class="error-text pull-right text-sperrschrift"><b>°Fett</b></span> <!-- Fett begin with degree -->
                                                    <select name="fett_converted_spaced_degree_at_beginning" id="fett_converted_spaced_degree_at_beginning" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fett_end_with_degree">Fett mit ° am Ende</label><span class="error-text pull-right"><b>Fett,°</b></span> <!-- Fett end with degree -->
                                                    <select name="fett_end_with_degree" id="fett_end_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fett_begin_with_asterisk">Fett mit * am Anfang</label><span class="error-text pull-right"><b>*Fett</b></span> <!-- Fett begin with asterisk -->
                                                    <select name="fett_begin_with_asterisk" id="fett_begin_with_asterisk" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fett_converted_spaced_asterisk_at_beginning">Fett (konvertierte Sperrschrift) mit * am Anfang</label><span class="error-text pull-right text-sperrschrift"><b>*Fett</b></span> <!-- Fett begin with asterisk -->
                                                    <select name="fett_converted_spaced_asterisk_at_beginning" id="fett_converted_spaced_asterisk_at_beginning" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="fett_begin_with_asterisk_end_with_t">Fett mit * am Anfang und t.</label><span class="error-text pull-right"><b>*Fett, t.</b></span> <!-- Fett begin with asterisk end with t -->
                                                    <select name="fett_begin_with_asterisk_end_with_t" id="fett_begin_with_asterisk_end_with_t" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="fett_begin_with_asterisk_end_with_tt">Fett mit * am Anfang und tt.</label><span class="error-text pull-right"><b>*Fett, tt.</b></span> <!-- Fett begin with asterisk end with tt -->
                                                    <select name="fett_begin_with_asterisk_end_with_tt" id="fett_begin_with_asterisk_end_with_tt" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fett_begin_with_asterisk_end_with_degree">Fett mit * am Anfang und °</label><span class="error-text pull-right"><b>*Fett,°</b></span> <!-- Fett begin with asterisk end with degree -->
                                                    <select name="fett_begin_with_asterisk_end_with_degree" id="fett_begin_with_asterisk_end_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="gross">Gross</label><span class="error-text pull-right">GROSS</span>
                                                    <select name="gross" id="gross" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="gross_begin_with_degree">Gross mit ° am Anfang</label><span class="error-text pull-right">°GROSS</span> <!-- Gross begin with degree -->
                                                    <select name="gross_begin_with_degree" id="gross_begin_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="gross_begin_with_asterisk">Gross mit * am Anfang</label><span class="error-text pull-right">*GROSS</span> <!-- Gross begin with asterisk -->
                                                    <select name="gross_begin_with_asterisk" id="gross_begin_with_asterisk" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="gross_bold">Gross fett</label><span class="error-text pull-right"><b>GROSS</b></span> <!-- Gross bold -->
                                                    <select name="gross_bold" id="gross_bold" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="gross_bold_begin_with_degree">Gross fett mit ° am Anfang</label><span class="error-text pull-right"><b>°GROSS</b></span> <!-- Gross bold begin with degree -->
                                                    <select name="gross_bold_begin_with_degree" id="gross_bold_begin_with_degree" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="gross_bold_begin_with_asterisk">Gross fett mit * am Anfang</label><span class="error-text pull-right"><b>*GROSS</b></span> <!-- Gross bold begin with asterisk -->
                                                    <select name="gross_bold_begin_with_asterisk" id="gross_bold_begin_with_asterisk" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="pi_sign">Pi-Zeichen</label><span class="error-text pull-right">π</span>
                                                    <select name="pi_sign" id="pi_sign" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="one_bar">Ein Balken</label><span class="error-text pull-right">|</span>
                                                    <select name="one_bar" id="one_bar" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="two_bar">Zwei Balken</label><span class="error-text pull-right">||</span>
                                                    <select name="two_bar" id="two_bar" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="three_bar">Drei Balken</label><span class="error-text pull-right">|||</span>
                                                    <select name="three_bar" id="three_bar" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="three_and_half_bar">Dreieinhalb Takte</label><span class="error-text pull-right">|||-</span>
                                                    <select name="three_and_half_bar" id="three_and_half_bar" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="four_bar">Vier Balken</label><span class="error-text pull-right">||||</span>
                                                    <select name="four_bar" id="four_bar" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="four_and_half_bar">Viereinhalb Takte</label><span class="error-text pull-right">||||-</span>
                                                    <select name="four_and_half_bar" id="four_and_half_bar" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="five_bar">Fünf Balken</label><span class="error-text pull-right">|||||</span>
                                                    <select name="five_bar" id="five_bar" class="form-control">
                                                        <option value="">Grade wählen</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1½</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2½</option>
                                                        <option value="3">3</option>
                                                        <option value="3.2">3 (2)</option>
                                                        <option value="3.5">3½</option>
                                                        <option value="4">4</option>
                                                        <option value="4.2">4 (2)</option>
                                                        <option value="4.5">4½</option>
                                                        <option value="5">5</option>
                                                        <option value="5.2">5 (2)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12"><p class="symptom-edit-common-error-text text-danger"></p></div>
                                </div>
                            </div>
                            <!-- symptom settings tab end -->
                        </div>
                        <!-- Tab end -->
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="modal_symptom_edit_symptom_id" id="modal_symptom_edit_symptom_id">
                    <input type="hidden" name="modal_symptom_edit_quelle_id" id="modal_symptom_edit_quelle_id">
                    <input type="hidden" name="modal_symptom_edit_arznei_id" id="modal_symptom_edit_arznei_id">
                    <input type="hidden" name="modal_symptom_edit_quelle_import_master_id" id="modal_symptom_edit_quelle_import_master_id">
                    <input type="hidden" name="original_symptom_encoded_de" id="original_symptom_encoded_de">
                    <input type="hidden" name="original_symptom_encoded_en" id="original_symptom_encoded_en">
                    <button type="button" class="btn btn-primary symptom-edit-modal-preview-btn">Preview</button>
                    <button type="button" class="btn btn-primary symptom-edit-modal-submit-btn hidden">Submit</button>
                    <button type="button" class="btn btn-primary symptom-edit-preview-modal-back-btn hidden" id="symptom_edit_preview_modal_back_btn">Go Back</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add symptom edit modal end -->
<!-- jQuery 3 -->
<script src="<?php echo $absoluteUrl;?>plugins/jquery/dist/jquery.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $absoluteUrl;?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
	var absoluteUrl = "<?php echo $absoluteUrl;?>";
	var baseApiURL = "<?php echo $baseApiURL;?>";
	var token = "<?php echo $_SESSION['access_token']; ?>";
</script>
<!-- Tinymce -->
<script src="<?php echo $absoluteUrl;?>plugins/tinymce/jquery.tinymce.min.js"></script>
<script src="<?php echo $absoluteUrl;?>plugins/tinymce/jquery.tinymce.config.js"></script>
<script src="<?php echo $absoluteUrl;?>plugins/tinymce/tinymce.min.js"></script>
<script src="<?php echo $absoluteUrl;?>plugins/jasny-bootstrap/jasny-bootstrap.min.js"></script>

<script src="<?php echo $absoluteUrl;?>plugins/jquery-ui/ui/i18n/datepicker-de.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $absoluteUrl;?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Dropify -->
<script src="<?php echo $absoluteUrl;?>plugins/dropify/js/dropify.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $absoluteUrl;?>plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $absoluteUrl;?>plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- sweet alert 2 -->
<script src="<?php echo $absoluteUrl;?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Select2 -->
<script src="<?php echo $absoluteUrl;?>plugins/select2/dist/js/select2.full.min.js"></script>
<!-- Select2 custom search box placeholder -->
<script src="<?php echo $absoluteUrl;?>assets/js/select2-custom-search-box-placeholder.js"></script>
<!-- FastClick -->
<script src="<?php echo $absoluteUrl;?>plugins/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $absoluteUrl;?>assets/js/adminlte.min.js"></script>
<!-- Jquery validation plugin -->
<script src="<?php echo $absoluteUrl;?>plugins/jquery.validate.min.js"></script>
<!-- custom common js -->
<script src="<?php echo $absoluteUrl;?>assets/js/common.js"></script>
<!-- Advance Search custom js -->
<script src="<?php echo $absoluteUrl;?>assets/js/advanceSearch.js"></script>
<script src="<?php echo $absoluteUrl;?>assets/js/modernizr.js"></script>
<!-- Custom form validation -->
<script src="<?php echo $absoluteUrl;?>assets/js/formValidation.js"></script>
<!-- Ajax blockUI -->
<script src="<?php echo $absoluteUrl;?>plugins/jquery.blockUI.js"></script>
<!-- sweet alert message popup-->
<script src="<?php echo $absoluteUrl;?>/assets/js/alertMessage.js"></script>
<!-- Ajax form submit -->
<script src="<?php echo $absoluteUrl;?>assets/js/ajaxFormSubmit.js"></script>
<!-- Quelle Gradings page js -->
<script src="<?php echo $absoluteUrl;?>assets/js/quelleSettings.js"></script>
<script src="<?php echo $absoluteUrl;?>assets/js/globalGradingSetting.js"></script>
<!--Any error type pop up  -->
<?php if(isset($error)) { ?>
	<script> 
		var errorMessage = '<?php echo $error;?>';
		errorMessagePopUp( errorMessage ); 
	</script>
<?php } ?>
<script>
    $('#quelle_id').select2({
        // options 
        searchInputPlaceholder: 'Search Quelle...'
    });

    $('#quelle_id').on('select2:select', function (e) {
        console.log(e.params.data);
        console.log(quelle_id, e.params.data.id);
    });

    $('body').on( 'change', '#show_all_translation', function(e) {
        var action = "";
        var is_data_found = 0;

        if($(this).prop("checked") == true) {
            action = "check";
        }else{
            action = "uncheck";
        }

        if(action == "check"){
            $(".table-symptom-hidden").removeClass('hidden');
            $('.table-original-symptom').addClass('table-original-symptom-bg');
        }else if(action == "uncheck"){
            $(".table-symptom-hidden").addClass('hidden');
            $('.table-original-symptom').removeClass('table-original-symptom-bg');
        }
    });

    // Edit symptom popup on symptom verson change
    /*$(document).on('change', 'input[type=radio][name=symptom_version]', function(){
        $("#edit_synonym_modal_loader .loading-msg").removeClass('hidden');
        $("#edit_synonym_modal_loader .error-msg").html('');
        if($("#edit_synonym_modal_loader").hasClass('hidden'))
            $("#edit_synonym_modal_loader").removeClass('hidden');
        $('.symptom-edit-modal-submit-btn').prop('disabled', true);
        var symptomId = $("#modal_symptom_edit_symptom_id").val();
        var symptomVersion = $(this).attr("value");
        if(symptomId != ""){
            $.ajax({
                type: 'POST',
                url: 'get-editable-symptoms.php',
                data: {
                    symptom_id: symptomId
                },
                dataType: "json",
                success: function( response ) {
                    console.log(response);
                    var converted_symptom_full_de = (typeof(response.converted_symptom_full_de) != "undefined" && response.converted_symptom_full_de !== null && response.converted_symptom_full_de != "") ? response.converted_symptom_full_de : "";
                    var converted_symptom_full_en = (typeof(response.converted_symptom_full_en) != "undefined" && response.converted_symptom_full_en !== null && response.converted_symptom_full_en != "") ? response.converted_symptom_full_en : "";
                    var original_symptom_de = (typeof(response.original_symptom_de) != "undefined" && response.original_symptom_de !== null && response.original_symptom_de != "") ? response.original_symptom_de : "";
                    var original_symptom_en = (typeof(response.original_symptom_en) != "undefined" && response.original_symptom_en !== null && response.original_symptom_en != "") ? response.original_symptom_en : "";
                    if(symptomVersion == "original") {
                        $("#symptom_edit_de").val(original_symptom_de);
                        $("#symptom_edit_en").val(original_symptom_en);
                    } else if (symptomVersion == "converted") {
                        $("#symptom_edit_de").val(converted_symptom_full_de);
                        $("#symptom_edit_en").val(converted_symptom_full_en);
                    }
                    $('.symptom-edit-modal-submit-btn').prop('disabled', false);
                    if(!$("#edit_synonym_modal_loader .loading-msg").hasClass('hidden'))
                        $("#edit_synonym_modal_loader .loading-msg").addClass('hidden');
                    $("#edit_synonym_modal_loader .error-msg").html('');
                    if(!$("#edit_synonym_modal_loader").hasClass('hidden'))
                        $("#edit_synonym_modal_loader").addClass('hidden');
                }
            }).fail(function (response) {
                $('.symptom-edit-modal-submit-btn').prop('disabled', false);
                if(!$("#edit_synonym_modal_loader .loading-msg").hasClass('hidden'))
                    $("#edit_synonym_modal_loader .loading-msg").addClass('hidden');
                $("#edit_synonym_modal_loader .error-msg").html('Something went wrong!');
                if($("#edit_synonym_modal_loader").hasClass('hidden'))
                    $("#edit_synonym_modal_loader").removeClass('hidden');
                $('#editSymptomModal').animate({
                    scrollTop: $(".modal-header").offset().top
                }, 1000);
            });
        }else{
            $('.symptom-edit-modal-submit-btn').prop('disabled', false);
            if(!$("#edit_synonym_modal_loader .loading-msg").hasClass('hidden'))
                $("#edit_synonym_modal_loader .loading-msg").addClass('hidden');
            $("#edit_synonym_modal_loader .error-msg").html('Required data not found.');
            if($("#edit_synonym_modal_loader").hasClass('hidden'))
                $("#edit_synonym_modal_loader").removeClass('hidden');
            $('#editSymptomModal').animate({
                scrollTop: $(".modal-header").offset().top
            }, 1000);
        }
    });*/

    // Edit symptom
    $('body').on('click','.edit-symptom-btn', function(e){
        $("#symptom_edit_preview_container").addClass('hidden');
        $("#symptom_edit_preview_modal_back_btn").addClass('hidden');
        $(".symptom-edit-modal-preview-btn").addClass('hidden');
        $('.symptom-edit-modal-submit-btn').addClass('hidden');
        $("#symptom_edit_container").removeClass('hidden');

        $(".symptom_edit_modal_loader .loading-msg").removeClass('hidden');
        $(".symptom_edit_modal_loader .error-msg").html('');
        if($(".symptom_edit_modal_loader").hasClass('hidden'))
            $(".symptom_edit_modal_loader").removeClass('hidden');
        // $('.symptom-edit-modal-submit-btn').prop('disabled', true);
        $('#edit_symptom_form')[0].reset();
        var symptomId =  $(this).attr("data-symptom-id");
        var quelleId =  $(this).attr("data-quelle-id");
        var arzneiId =  $(this).attr("data-arznei-id");
        var mId =  $(this).attr("data-quelle-import-master-id");
        // var symptomVersion = $('input[name="symptom_version"]:checked').val();
        $("#modal_symptom_edit_symptom_id").val(symptomId);
        $("#modal_symptom_edit_quelle_id").val(quelleId);
        $("#modal_symptom_edit_arznei_id").val(arzneiId);
        $("#modal_symptom_edit_quelle_import_master_id").val(mId);
        $("#editSymptomModal").modal('show');

        $.ajax({
            type: 'POST',
            url: 'get-editable-symptoms.php',
            data: {
                symptom_id: symptomId
            },
            dataType: "json",
            success: function( response ) {
                console.log(response);
                if(response.status == "success"){
                    if(typeof(response.result_data) != "undefined" && response.result_data !== null) {
                        var resultData = null;
                        try {
                            resultData = JSON.parse(response.result_data); 
                        } catch (e) {
                            resultData = response.result_data;
                        }

                        var individual_upgrade_justification = (typeof(resultData.individual_upgrade_justification) != "undefined" && resultData.individual_upgrade_justification !== null && resultData.individual_upgrade_justification != "") ? resultData.individual_upgrade_justification : "";
                        var converted_symptom_full_de = (typeof(resultData.converted_symptom_full_de) != "undefined" && resultData.converted_symptom_full_de !== null && resultData.converted_symptom_full_de != "") ? resultData.converted_symptom_full_de : "-";
                        var converted_symptom_full_en = (typeof(resultData.converted_symptom_full_en) != "undefined" && resultData.converted_symptom_full_en !== null && resultData.converted_symptom_full_en != "") ? resultData.converted_symptom_full_en : "-";
                        var original_symptom_de = (typeof(resultData.original_symptom_de) != "undefined" && resultData.original_symptom_de !== null && resultData.original_symptom_de != "") ? resultData.original_symptom_de : "-";
                        var original_symptom_en = (typeof(resultData.original_symptom_en) != "undefined" && resultData.original_symptom_en !== null && resultData.original_symptom_en != "") ? resultData.original_symptom_en : "-";
                        // imported version
                        var imported_symptom_de = (typeof(resultData.imported_symptom_de) != "undefined" && resultData.imported_symptom_de !== null && resultData.imported_symptom_de != "") ? resultData.imported_symptom_de : "";
                        var imported_symptom_en = (typeof(resultData.imported_symptom_en) != "undefined" && resultData.imported_symptom_en !== null && resultData.imported_symptom_en != "") ? resultData.imported_symptom_en : "";

                        var original_symptom_encoded_de = (typeof(resultData.original_symptom_encoded_de) != "undefined" && resultData.original_symptom_encoded_de !== null && resultData.original_symptom_encoded_de != "") ? resultData.original_symptom_encoded_de : "";
                        var original_symptom_encoded_en = (typeof(resultData.original_symptom_encoded_en) != "undefined" && resultData.original_symptom_encoded_en !== null && resultData.original_symptom_encoded_en != "") ? resultData.original_symptom_encoded_en : "";
                        // var symptom_type = (typeof(resultData.symptom_type) != "undefined" && resultData.symptom_type !== null && resultData.symptom_type != "") ? resultData.symptom_type : "";

                        $("#preview_original_version_de").html(original_symptom_de);
                        $("#preview_original_version_en").html(original_symptom_en);
                        $("#preview_converted_version_de").html(converted_symptom_full_de);
                        $("#preview_converted_version_en").html(converted_symptom_full_en);

                        // Symptom type
                        (typeof resultData.symptom_type !== 'undefined' && resultData.symptom_type !== null && resultData.symptom_type != "") ? $("#symptom_type option[value='"+resultData.symptom_type+"']").prop('selected', true) : $("#symptom_type option[value='']").prop('selected', true);

                        // Grading section start
                        (typeof resultData.normal !== 'undefined' && resultData.normal !== null && resultData.normal != "") ? $("#normal option[value='"+resultData.normal+"']").prop('selected', true) : $("#normal option[value='']").prop('selected', true);
                        (typeof resultData.normal_within_parentheses !== 'undefined' && resultData.normal_within_parentheses !== null && resultData.normal_within_parentheses != "") ? $("#normal_within_parentheses option[value='"+resultData.normal_within_parentheses+"']").prop('selected', true) : $("#normal_within_parentheses option[value='']").prop('selected', true);
                        (typeof resultData.normal_end_with_t !== 'undefined' && resultData.normal_end_with_t !== null && resultData.normal_end_with_t != "") ? $("#normal_end_with_t option[value='"+resultData.normal_end_with_t+"']").prop('selected', true) : $("#normal_end_with_t option[value='']").prop('selected', true);
                        (typeof resultData.normal_end_with_tt !== 'undefined' && resultData.normal_end_with_tt !== null && resultData.normal_end_with_tt != "") ? $("#normal_end_with_tt option[value='"+resultData.normal_end_with_tt+"']").prop('selected', true) : $("#normal_end_with_tt option[value='']").prop('selected', true);
                        (typeof resultData.normal_begin_with_degree !== 'undefined' && resultData.normal_begin_with_degree !== null && resultData.normal_begin_with_degree != "") ? $("#normal_begin_with_degree option[value='"+resultData.normal_begin_with_degree+"']").prop('selected', true) : $("#normal_begin_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.normal_end_with_degree !== 'undefined' && resultData.normal_end_with_degree !== null && resultData.normal_end_with_degree != "") ? $("#normal_end_with_degree option[value='"+resultData.normal_end_with_degree+"']").prop('selected', true) : $("#normal_end_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.normal_begin_with_asterisk !== 'undefined' && resultData.normal_begin_with_asterisk !== null && resultData.normal_begin_with_asterisk != "") ? $("#normal_begin_with_asterisk option[value='"+resultData.normal_begin_with_asterisk+"']").prop('selected', true) : $("#normal_begin_with_asterisk option[value='']").prop('selected', true);
                        (typeof resultData.normal_begin_with_asterisk_end_with_t !== 'undefined' && resultData.normal_begin_with_asterisk_end_with_t !== null && resultData.normal_begin_with_asterisk_end_with_t != "") ? $("#normal_begin_with_asterisk_end_with_t option[value='"+resultData.normal_begin_with_asterisk_end_with_t+"']").prop('selected', true) : $("#normal_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
                        (typeof resultData.normal_begin_with_asterisk_end_with_tt !== 'undefined' && resultData.normal_begin_with_asterisk_end_with_tt !== null && resultData.normal_begin_with_asterisk_end_with_tt != "") ? $("#normal_begin_with_asterisk_end_with_tt option[value='"+resultData.normal_begin_with_asterisk_end_with_tt+"']").prop('selected', true) : $("#normal_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
                        (typeof resultData.normal_begin_with_asterisk_end_with_degree !== 'undefined' && resultData.normal_begin_with_asterisk_end_with_degree !== null && resultData.normal_begin_with_asterisk_end_with_degree != "") ? $("#normal_begin_with_asterisk_end_with_degree option[value='"+resultData.normal_begin_with_asterisk_end_with_degree+"']").prop('selected', true) : $("#normal_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.sperrschrift !== 'undefined' && resultData.sperrschrift !== null && resultData.sperrschrift != "") ? $("#sperrschrift option[value='"+resultData.sperrschrift+"']").prop('selected', true) : $("#sperrschrift option[value='']").prop('selected', true);
                        (typeof resultData.sperrschrift_begin_with_degree !== 'undefined' && resultData.sperrschrift_begin_with_degree !== null && resultData.sperrschrift_begin_with_degree != "") ? $("#sperrschrift_begin_with_degree option[value='"+resultData.sperrschrift_begin_with_degree+"']").prop('selected', true) : $("#sperrschrift_begin_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.sperrschrift_begin_with_asterisk !== 'undefined' && resultData.sperrschrift_begin_with_asterisk !== null && resultData.sperrschrift_begin_with_asterisk != "") ? $("#sperrschrift_begin_with_asterisk option[value='"+resultData.sperrschrift_begin_with_asterisk+"']").prop('selected', true) : $("#sperrschrift_begin_with_asterisk option[value='']").prop('selected', true);
                        (typeof resultData.sperrschrift_bold !== 'undefined' && resultData.sperrschrift_bold !== null && resultData.sperrschrift_bold != "") ? $("#sperrschrift_bold option[value='"+resultData.sperrschrift_bold+"']").prop('selected', true) : $("#sperrschrift_bold option[value='']").prop('selected', true);
                        (typeof resultData.sperrschrift_bold_begin_with_degree !== 'undefined' && resultData.sperrschrift_bold_begin_with_degree !== null && resultData.sperrschrift_bold_begin_with_degree != "") ? $("#sperrschrift_bold_begin_with_degree option[value='"+resultData.sperrschrift_bold_begin_with_degree+"']").prop('selected', true) : $("#sperrschrift_bold_begin_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.sperrschrift_bold_begin_with_asterisk !== 'undefined' && resultData.sperrschrift_bold_begin_with_asterisk !== null && resultData.sperrschrift_bold_begin_with_asterisk != "") ? $("#sperrschrift_bold_begin_with_asterisk option[value='"+resultData.sperrschrift_bold_begin_with_asterisk+"']").prop('selected', true) : $("#sperrschrift_bold_begin_with_asterisk option[value='']").prop('selected', true);
                        (typeof resultData.kursiv !== 'undefined' && resultData.kursiv !== null && resultData.kursiv != "") ? $("#kursiv option[value='"+resultData.kursiv+"']").prop('selected', true) : $("#kursiv option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_end_with_t !== 'undefined' && resultData.kursiv_end_with_t !== null && resultData.kursiv_end_with_t != "") ? $("#kursiv_end_with_t option[value='"+resultData.kursiv_end_with_t+"']").prop('selected', true) : $("#kursiv_end_with_t option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_end_with_tt !== 'undefined' && resultData.kursiv_end_with_tt !== null && resultData.kursiv_end_with_tt != "") ? $("#kursiv_end_with_tt option[value='"+resultData.kursiv_end_with_tt+"']").prop('selected', true) : $("#kursiv_end_with_tt option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_begin_with_degree !== 'undefined' && resultData.kursiv_begin_with_degree !== null && resultData.kursiv_begin_with_degree != "") ? $("#kursiv_begin_with_degree option[value='"+resultData.kursiv_begin_with_degree+"']").prop('selected', true) : $("#kursiv_begin_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_end_with_degree !== 'undefined' && resultData.kursiv_end_with_degree !== null && resultData.kursiv_end_with_degree != "") ? $("#kursiv_end_with_degree option[value='"+resultData.kursiv_end_with_degree+"']").prop('selected', true) : $("#kursiv_end_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_begin_with_asterisk !== 'undefined' && resultData.kursiv_begin_with_asterisk !== null && resultData.kursiv_begin_with_asterisk != "") ? $("#kursiv_begin_with_asterisk option[value='"+resultData.kursiv_begin_with_asterisk+"']").prop('selected', true) : $("#kursiv_begin_with_asterisk option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_begin_with_asterisk_end_with_t !== 'undefined' && resultData.kursiv_begin_with_asterisk_end_with_t !== null && resultData.kursiv_begin_with_asterisk_end_with_t != "") ? $("#kursiv_begin_with_asterisk_end_with_t option[value='"+resultData.kursiv_begin_with_asterisk_end_with_t+"']").prop('selected', true) : $("#kursiv_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_begin_with_asterisk_end_with_tt !== 'undefined' && resultData.kursiv_begin_with_asterisk_end_with_tt !== null && resultData.kursiv_begin_with_asterisk_end_with_tt != "") ? $("#kursiv_begin_with_asterisk_end_with_tt option[value='"+resultData.kursiv_begin_with_asterisk_end_with_tt+"']").prop('selected', true) : $("#kursiv_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_begin_with_asterisk_end_with_degree !== 'undefined' && resultData.kursiv_begin_with_asterisk_end_with_degree !== null && resultData.kursiv_begin_with_asterisk_end_with_degree != "") ? $("#kursiv_begin_with_asterisk_end_with_degree option[value='"+resultData.kursiv_begin_with_asterisk_end_with_degree+"']").prop('selected', true) : $("#kursiv_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_bold !== 'undefined' && resultData.kursiv_bold !== null && resultData.kursiv_bold != "") ? $("#kursiv_bold option[value='"+resultData.kursiv_bold+"']").prop('selected', true) : $("#kursiv_bold option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_bold_begin_with_asterisk_end_with_t !== 'undefined' && resultData.kursiv_bold_begin_with_asterisk_end_with_t !== null && resultData.kursiv_bold_begin_with_asterisk_end_with_t != "") ? $("#kursiv_bold_begin_with_asterisk_end_with_t option[value='"+resultData.kursiv_bold_begin_with_asterisk_end_with_t+"']").prop('selected', true) : $("#kursiv_bold_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_bold_begin_with_asterisk_end_with_tt !== 'undefined' && resultData.kursiv_bold_begin_with_asterisk_end_with_tt !== null && resultData.kursiv_bold_begin_with_asterisk_end_with_tt != "") ? $("#kursiv_bold_begin_with_asterisk_end_with_tt option[value='"+resultData.kursiv_bold_begin_with_asterisk_end_with_tt+"']").prop('selected', true) : $("#kursiv_bold_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_bold_begin_with_degree !== 'undefined' && resultData.kursiv_bold_begin_with_degree !== null && resultData.kursiv_bold_begin_with_degree != "") ? $("#kursiv_bold_begin_with_degree option[value='"+resultData.kursiv_bold_begin_with_degree+"']").prop('selected', true) : $("#kursiv_bold_begin_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_bold_begin_with_asterisk !== 'undefined' && resultData.kursiv_bold_begin_with_asterisk !== null && resultData.kursiv_bold_begin_with_asterisk != "") ? $("#kursiv_bold_begin_with_asterisk option[value='"+resultData.kursiv_bold_begin_with_asterisk+"']").prop('selected', true) : $("#kursiv_bold_begin_with_asterisk option[value='']").prop('selected', true);
                        (typeof resultData.kursiv_bold_begin_with_asterisk_end_with_degree !== 'undefined' && resultData.kursiv_bold_begin_with_asterisk_end_with_degree !== null && resultData.kursiv_bold_begin_with_asterisk_end_with_degree != "") ? $("#kursiv_bold_begin_with_asterisk_end_with_degree option[value='"+resultData.kursiv_bold_begin_with_asterisk_end_with_degree+"']").prop('selected', true) : $("#kursiv_bold_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.fett !== 'undefined' && resultData.fett !== null && resultData.fett != "") ? $("#fett option[value='"+resultData.fett+"']").prop('selected', true) : $("#fett option[value='']").prop('selected', true);
                        (typeof resultData.fett_end_with_t !== 'undefined' && resultData.fett_end_with_t !== null && resultData.fett_end_with_t != "") ? $("#fett_end_with_t option[value='"+resultData.fett_end_with_t+"']").prop('selected', true) : $("#fett_end_with_t option[value='']").prop('selected', true);
                        (typeof resultData.fett_end_with_tt !== 'undefined' && resultData.fett_end_with_tt !== null && resultData.fett_end_with_tt != "") ? $("#fett_end_with_tt option[value='"+resultData.fett_end_with_tt+"']").prop('selected', true) : $("#fett_end_with_tt option[value='']").prop('selected', true);
                        (typeof resultData.fett_begin_with_degree !== 'undefined' && resultData.fett_begin_with_degree !== null && resultData.fett_begin_with_degree != "") ? $("#fett_begin_with_degree option[value='"+resultData.fett_begin_with_degree+"']").prop('selected', true) : $("#fett_begin_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.fett_end_with_degree !== 'undefined' && resultData.fett_end_with_degree !== null && resultData.fett_end_with_degree != "") ? $("#fett_end_with_degree option[value='"+resultData.fett_end_with_degree+"']").prop('selected', true) : $("#fett_end_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.fett_begin_with_asterisk !== 'undefined' && resultData.fett_begin_with_asterisk !== null && resultData.fett_begin_with_asterisk != "") ? $("#fett_begin_with_asterisk option[value='"+resultData.fett_begin_with_asterisk+"']").prop('selected', true) : $("#fett_begin_with_asterisk option[value='']").prop('selected', true);
                        (typeof resultData.fett_begin_with_asterisk_end_with_t !== 'undefined' && resultData.fett_begin_with_asterisk_end_with_t !== null && resultData.fett_begin_with_asterisk_end_with_t != "") ? $("#fett_begin_with_asterisk_end_with_t option[value='"+resultData.fett_begin_with_asterisk_end_with_t+"']").prop('selected', true) : $("#fett_begin_with_asterisk_end_with_t option[value='']").prop('selected', true);
                        (typeof resultData.fett_begin_with_asterisk_end_with_tt !== 'undefined' && resultData.fett_begin_with_asterisk_end_with_tt !== null && resultData.fett_begin_with_asterisk_end_with_tt != "") ? $("#fett_begin_with_asterisk_end_with_tt option[value='"+resultData.fett_begin_with_asterisk_end_with_tt+"']").prop('selected', true) : $("#fett_begin_with_asterisk_end_with_tt option[value='']").prop('selected', true);
                        (typeof resultData.fett_begin_with_asterisk_end_with_degree !== 'undefined' && resultData.fett_begin_with_asterisk_end_with_degree !== null && resultData.fett_begin_with_asterisk_end_with_degree != "") ? $("#fett_begin_with_asterisk_end_with_degree option[value='"+resultData.fett_begin_with_asterisk_end_with_degree+"']").prop('selected', true) : $("#fett_begin_with_asterisk_end_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.fett_converted_spaced !== 'undefined' && resultData.fett_converted_spaced !== null && resultData.fett_converted_spaced != "") ? $("#fett_converted_spaced option[value='"+resultData.fett_converted_spaced+"']").prop('selected', true) : $("#fett_converted_spaced option[value='']").prop('selected', true);
                        (typeof resultData.fett_converted_spaced_degree_at_beginning !== 'undefined' && resultData.fett_converted_spaced_degree_at_beginning !== null && resultData.fett_converted_spaced_degree_at_beginning != "") ? $("#fett_converted_spaced_degree_at_beginning option[value='"+resultData.fett_converted_spaced_degree_at_beginning+"']").prop('selected', true) : $("#fett_converted_spaced_degree_at_beginning option[value='']").prop('selected', true);
                        (typeof resultData.fett_converted_spaced_asterisk_at_beginning !== 'undefined' && resultData.fett_converted_spaced_asterisk_at_beginning !== null && resultData.fett_converted_spaced_asterisk_at_beginning != "") ? $("#fett_converted_spaced_asterisk_at_beginning option[value='"+resultData.fett_converted_spaced_asterisk_at_beginning+"']").prop('selected', true) : $("#fett_converted_spaced_asterisk_at_beginning option[value='']").prop('selected', true);
                        (typeof resultData.gross !== 'undefined' && resultData.gross !== null && resultData.gross != "") ? $("#gross option[value='"+resultData.gross+"']").prop('selected', true) : $("#gross option[value='']").prop('selected', true);
                        (typeof resultData.gross_begin_with_degree !== 'undefined' && resultData.gross_begin_with_degree !== null && resultData.gross_begin_with_degree != "") ? $("#gross_begin_with_degree option[value='"+resultData.gross_begin_with_degree+"']").prop('selected', true) : $("#gross_begin_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.gross_begin_with_asterisk !== 'undefined' && resultData.gross_begin_with_asterisk !== null && resultData.gross_begin_with_asterisk != "") ? $("#gross_begin_with_asterisk option[value='"+resultData.gross_begin_with_asterisk+"']").prop('selected', true) : $("#gross_begin_with_asterisk option[value='']").prop('selected', true);
                        (typeof resultData.gross_bold !== 'undefined' && resultData.gross_bold !== null && resultData.gross_bold != "") ? $("#gross_bold option[value='"+resultData.gross_bold+"']").prop('selected', true) : $("#gross_bold option[value='']").prop('selected', true);
                        (typeof resultData.gross_bold_begin_with_degree !== 'undefined' && resultData.gross_bold_begin_with_degree !== null && resultData.gross_bold_begin_with_degree != "") ? $("#gross_bold_begin_with_degree option[value='"+resultData.gross_bold_begin_with_degree+"']").prop('selected', true) : $("#gross_bold_begin_with_degree option[value='']").prop('selected', true);
                        (typeof resultData.gross_bold_begin_with_asterisk !== 'undefined' && resultData.gross_bold_begin_with_asterisk !== null && resultData.gross_bold_begin_with_asterisk != "") ? $("#gross_bold_begin_with_asterisk option[value='"+resultData.gross_bold_begin_with_asterisk+"']").prop('selected', true) : $("#gross_bold_begin_with_asterisk option[value='']").prop('selected', true);
                        (typeof resultData.pi_sign !== 'undefined' && resultData.pi_sign !== null && resultData.pi_sign != "") ? $("#pi_sign option[value='"+resultData.pi_sign+"']").prop('selected', true) : $("#pi_sign option[value='']").prop('selected', true);
                        (typeof resultData.one_bar !== 'undefined' && resultData.one_bar !== null && resultData.one_bar != "") ? $("#one_bar option[value='"+resultData.one_bar+"']").prop('selected', true) : $("#one_bar option[value='']").prop('selected', true);
                        (typeof resultData.two_bar !== 'undefined' && resultData.two_bar !== null && resultData.two_bar != "") ? $("#two_bar option[value='"+resultData.two_bar+"']").prop('selected', true) : $("#two_bar option[value='']").prop('selected', true);
                        (typeof resultData.three_bar !== 'undefined' && resultData.three_bar !== null && resultData.three_bar != "") ? $("#three_bar option[value='"+resultData.three_bar+"']").prop('selected', true) : $("#three_bar option[value='']").prop('selected', true);
                        (typeof resultData.three_and_half_bar !== 'undefined' && resultData.three_and_half_bar !== null && resultData.three_and_half_bar != "") ? $("#three_and_half_bar option[value='"+resultData.three_and_half_bar+"']").prop('selected', true) : $("#three_bar option[value='']").prop('selected', true);
                        (typeof resultData.four_bar !== 'undefined' && resultData.four_bar !== null && resultData.four_bar != "") ? $("#four_bar option[value='"+resultData.four_bar+"']").prop('selected', true) : $("#four_bar option[value='']").prop('selected', true);
                        (typeof resultData.four_and_half_bar !== 'undefined' && resultData.four_and_half_bar !== null && resultData.four_and_half_bar != "") ? $("#four_and_half_bar option[value='"+resultData.four_and_half_bar+"']").prop('selected', true) : $("#four_and_half_bar option[value='']").prop('selected', true);
                        (typeof resultData.five_bar !== 'undefined' && resultData.five_bar !== null && resultData.five_bar != "") ? $("#five_bar option[value='"+resultData.five_bar+"']").prop('selected', true) : $("#five_bar option[value='']").prop('selected', true);
                        // Grading section end
                        
                        $("#symptom_edit_de").val(imported_symptom_de);
                        $("#symptom_edit_en").val(imported_symptom_en);
                        $("#individual_upgrade_justification").val(individual_upgrade_justification);

                        // if(symptomVersion == "original") {
                        //     $("#symptom_edit_de").val(imported_symptom_de);
                        //     $("#symptom_edit_en").val(imported_symptom_en);
                        //     // $("#symptom_edit_de").val(original_symptom_de);
                        //     // $("#symptom_edit_en").val(original_symptom_en);
                        //     // $("#original_symptom_encoded_de").val(original_symptom_encoded_de);
                        //     // $("#original_symptom_encoded_en").val(original_symptom_encoded_en);
                        // } else if (symptomVersion == "converted") {
                        //     $("#symptom_edit_de").val(converted_symptom_full_de);
                        //     $("#symptom_edit_en").val(converted_symptom_full_en);
                        // }
                        // $('.symptom-edit-modal-submit-btn').prop('disabled', false);
                        $(".symptom-edit-modal-preview-btn").removeClass('hidden');
                        if(!$(".symptom_edit_modal_loader .loading-msg").hasClass('hidden'))
                            $(".symptom_edit_modal_loader .loading-msg").addClass('hidden');
                        $(".symptom_edit_modal_loader .error-msg").html('');
                        if(!$(".symptom_edit_modal_loader").hasClass('hidden'))
                            $(".symptom_edit_modal_loader").addClass('hidden');
                    } else {
                        // $('.symptom-edit-modal-submit-btn').prop('disabled', false);
                        if(!$(".symptom_edit_modal_loader .loading-msg").hasClass('hidden'))
                            $(".symptom_edit_modal_loader .loading-msg").addClass('hidden');
                        $(".symptom_edit_modal_loader .error-msg").html('Something went wrong!');
                        if($(".symptom_edit_modal_loader").hasClass('hidden'))
                            $(".symptom_edit_modal_loader").removeClass('hidden');
                        $('#editSymptomModal').animate({
                            scrollTop: $(".modal-header").offset().top
                        }, 1000);
                    }
                } else {
                    // $('.symptom-edit-modal-submit-btn').prop('disabled', false);
                    if(!$(".symptom_edit_modal_loader .loading-msg").hasClass('hidden'))
                        $(".symptom_edit_modal_loader .loading-msg").addClass('hidden');
                    $(".symptom_edit_modal_loader .error-msg").html('Something went wrong!');
                    if($(".symptom_edit_modal_loader").hasClass('hidden'))
                        $(".symptom_edit_modal_loader").removeClass('hidden');
                    $('#editSymptomModal').animate({
                        scrollTop: $(".modal-header").offset().top
                    }, 1000);
                }
            }
        }).fail(function (response) {
            // $('.symptom-edit-modal-submit-btn').prop('disabled', false);
            if(!$(".symptom_edit_modal_loader .loading-msg").hasClass('hidden'))
                $(".symptom_edit_modal_loader .loading-msg").addClass('hidden');
            $(".symptom_edit_modal_loader .error-msg").html('Something went wrong!');
            if($(".symptom_edit_modal_loader").hasClass('hidden'))
                $(".symptom_edit_modal_loader").removeClass('hidden');
            $('#editSymptomModal').animate({
                scrollTop: $(".modal-header").offset().top
            }, 1000);
        });
    });

    $('body').on('click', '#symptom_edit_preview_modal_back_btn', function(e) {
        $("#symptom_edit_container").removeClass('hidden');
        $("#symptom_edit_preview_container").addClass('hidden');
        $("#symptom_edit_preview_modal_back_btn").addClass('hidden');
        $('.symptom-edit-modal-submit-btn').addClass('hidden');
        $(".symptom-edit-modal-preview-btn").removeClass('hidden');

        $(".symptom_edit_modal_loader .loading-msg").addClass('hidden');
        $(".symptom_edit_modal_loader .error-msg").html('');
        if($(".symptom_edit_modal_loader").hasClass('hidden'))
            $(".symptom_edit_modal_loader").removeClass('hidden');
    });

    // Edit symptom submit
    $('body').on( 'click', '.symptom-edit-modal-preview-btn', function(e) {
        $("#symptom_edit_container").addClass('hidden');
        $("#symptom_edit_preview_container").removeClass('hidden');
        $("#symptom_edit_preview_modal_back_btn").addClass('hidden');
        $('.symptom-edit-modal-submit-btn').addClass('hidden');
        $(".symptom-edit-modal-preview-btn").addClass('hidden');
        
        $("#edit_symptom_modal_preview_loader .loading-msg").removeClass('hidden');
        $("#edit_symptom_modal_preview_loader .error-msg").html('');
        if($("#edit_symptom_modal_preview_loader").hasClass('hidden'))
            $("#edit_symptom_modal_preview_loader").removeClass('hidden');

        var modal_symptom_id = $("#modal_symptom_edit_symptom_id").val();
        var modal_quelle_id = $("#modal_symptom_edit_quelle_id").val();
        var modal_arznei_id = $("#modal_symptom_edit_arznei_id").val();
        var modal_quelle_import_master_id = $("#modal_symptom_edit_quelle_import_master_id").val();
        var symptom_edit_de = $("#symptom_edit_de").val();
        var symptom_edit_en = $("#symptom_edit_en").val();
        var error_count = 0;
        if(symptom_edit_de == "" && symptom_edit_en == "") {
            error_count++;
        }
        if(modal_symptom_id == "" || modal_quelle_id == "" || modal_arznei_id == "" || modal_quelle_import_master_id == ""){
            error_count++;
        }

        if(error_count != 0) {
            $("#symptom_edit_preview_modal_back_btn").removeClass('hidden');

            // $('.symptom-edit-modal-submit-btn').prop('disabled', false);
            if(!$("#edit_symptom_modal_preview_loader .loading-msg").hasClass('hidden'))
                $("#edit_symptom_modal_preview_loader .loading-msg").addClass('hidden');
            $("#edit_symptom_modal_preview_loader .error-msg").html('Required data not found.');
            if($("#edit_symptom_modal_preview_loader").hasClass('hidden'))
                $("#edit_symptom_modal_preview_loader").removeClass('hidden');
            $('#editSymptomModal').animate({
                scrollTop: $(".modal-header").offset().top
            }, 1000);
            return false;
        } else {
            // $('.symptom-edit-modal-submit-btn').prop('disabled', true);
            var data = $("#edit_symptom_form").serialize();
            $.ajax({
                type: 'POST',
                url: 'get-preview-of-edited-symptom.php',
                data: {
                    form: data
                },
                dataType: "json",
                success: function( response ) {
                    console.log(response);
                    // return false;
                    if(response.status == "success"){
                        var resultData = null;
                        try {
                            resultData = JSON.parse(response.result_data); 
                        } catch (e) {
                            resultData = response.result_data;
                        }
                        $('.symptom-edit-modal-submit-btn').removeClass('hidden');
                        $("#symptom_edit_preview_modal_back_btn").removeClass('hidden');
                        // $('.symptom-edit-modal-submit-btn').prop('disabled', false);
                        if(!$("#edit_symptom_modal_preview_loader .loading-msg").hasClass('hidden'))
                            $("#edit_symptom_modal_preview_loader .loading-msg").addClass('hidden');
                        $("#edit_symptom_modal_preview_loader .error-msg").html("");
                        if($("#edit_symptom_modal_preview_loader").hasClass('hidden'))
                            $("#edit_symptom_modal_preview_loader").removeClass('hidden');

                        $("#edtied_symptom_original_version_de").html(resultData.original_symptom_preview_de);
                        $("#edtied_symptom_original_version_en").html(resultData.original_symptom_preview_en);
                        $("#edtied_symptom_imported_version_de").html(resultData.imported_symptom_preview_de);
                        $("#edtied_symptom_imported_version_en").html(resultData.imported_symptom_preview_en);
                        $("#edtied_symptom_edited_version_de").html(resultData.edited_symptom_preview_de);
                        $("#edtied_symptom_edited_version_en").html(resultData.edited_symptom_preview_en);
                        $("#edtied_symptom_converted_version_de").html(resultData.converted_symptom_preview_de);
                        $("#edtied_symptom_converted_version_en").html(resultData.converted_symptom_preview_en);  
                    }else{
                        $("#symptom_edit_preview_modal_back_btn").removeClass('hidden');

                        // $('.symptom-edit-modal-submit-btn').prop('disabled', false);
                        if(!$("#edit_symptom_modal_preview_loader .loading-msg").hasClass('hidden'))
                            $("#edit_symptom_modal_preview_loader .loading-msg").addClass('hidden');
                        $("#edit_symptom_modal_preview_loader .error-msg").html(response.message);
                        if($("#edit_symptom_modal_preview_loader").hasClass('hidden'))
                            $("#edit_symptom_modal_preview_loader").removeClass('hidden');
                    }
                }
            }).fail(function (response) {
                $("#symptom_edit_preview_modal_back_btn").removeClass('hidden');

                // $('.symptom-edit-modal-submit-btn').prop('disabled', false);
                if(!$("#edit_symptom_modal_preview_loader .loading-msg").hasClass('hidden'))
                    $("#edit_symptom_modal_preview_loader .loading-msg").addClass('hidden');
                $("#edit_symptom_modal_preview_loader .error-msg").html('Something went wrong!');
                if($("#edit_symptom_modal_preview_loader").hasClass('hidden'))
                    $("#edit_symptom_modal_preview_loader").removeClass('hidden');
                $('#editSymptomModal').animate({
                    scrollTop: $(".modal-header").offset().top
                }, 1000);
            });
        }
    });


    $('body').on( 'click', '.symptom-edit-modal-submit-btn', function(e) {
        $("#symptom_edit_container").removeClass('hidden');
        $("#symptom_edit_preview_container").addClass('hidden');
        $("#symptom_edit_preview_modal_back_btn").addClass('hidden');
        $('.symptom-edit-modal-submit-btn').addClass('hidden');
        $(".symptom-edit-modal-preview-btn").addClass('hidden');

        $(".symptom_edit_modal_loader .loading-msg").removeClass('hidden');
        $(".symptom_edit_modal_loader .error-msg").html('');
        if($(".symptom_edit_modal_loader").hasClass('hidden'))
            $(".symptom_edit_modal_loader").removeClass('hidden');
        // $('.symptom-edit-modal-submit-btn').prop('disabled', true);
        var modal_symptom_id = $("#modal_symptom_edit_symptom_id").val();
        var modal_quelle_id = $("#modal_symptom_edit_quelle_id").val();
        var modal_arznei_id = $("#modal_symptom_edit_arznei_id").val();
        var modal_quelle_import_master_id = $("#modal_symptom_edit_quelle_import_master_id").val();
        var symptom_edit_de = $("#symptom_edit_de").val();
        var symptom_edit_en = $("#symptom_edit_en").val();
        var error_count = 0;
        if(symptom_edit_de == "" && symptom_edit_en == "") {
            error_count++;
        }
        if(modal_symptom_id == "" || modal_quelle_id == "" || modal_arznei_id == "" || modal_quelle_import_master_id == ""){
            error_count++;
        }

        if(error_count != 0) {
            $(".symptom-edit-modal-preview-btn").removeClass('hidden');

            // $('.symptom-edit-modal-submit-btn').prop('disabled', false);
            if(!$(".symptom_edit_modal_loader .loading-msg").hasClass('hidden'))
                $(".symptom_edit_modal_loader .loading-msg").addClass('hidden');
            $(".symptom_edit_modal_loader .error-msg").html('Required data not found.');
            if($(".symptom_edit_modal_loader").hasClass('hidden'))
                $(".symptom_edit_modal_loader").removeClass('hidden');
            $('#editSymptomModal').animate({
                scrollTop: $(".modal-header").offset().top
            }, 1000);
            return false;
        } else {
            // $('.symptom-edit-modal-submit-btn').prop('disabled', true);
            var data = $("#edit_symptom_form").serialize();
            $.ajax({
                type: 'POST',
                url: 'edit-original-or-converted-symptom.php',
                data: {
                    form: data
                },
                dataType: "json",
                success: function( response ) {
                    // console.log(response);
                    // return false;
                    if(response.status == "success"){
                        // $('.symptom-edit-modal-submit-btn').prop('disabled', false);
                        if(!$(".symptom_edit_modal_loader .loading-msg").hasClass('hidden'))
                            $(".symptom_edit_modal_loader .loading-msg").addClass('hidden');
                        $(".symptom_edit_modal_loader .error-msg").html(response.message);
                        if($(".symptom_edit_modal_loader").hasClass('hidden'))
                            $(".symptom_edit_modal_loader").removeClass('hidden');
                        $('#editSymptomModal').animate({
                            scrollTop: $(".modal-header").offset().top
                        }, 1000);
                        setTimeout(function () {
                                console.log("heloo");
                                $("#editSymptomModal").modal('hide');
                                location.reload();
                        }, 1000);     
                    }else{
                        $(".symptom-edit-modal-preview-btn").removeClass('hidden');

                        // $('.symptom-edit-modal-submit-btn').prop('disabled', false);
                        if(!$(".symptom_edit_modal_loader .loading-msg").hasClass('hidden'))
                            $(".symptom_edit_modal_loader .loading-msg").addClass('hidden');
                        $(".symptom_edit_modal_loader .error-msg").html(response.message);
                        if($(".symptom_edit_modal_loader").hasClass('hidden'))
                            $(".symptom_edit_modal_loader").removeClass('hidden');
                        $('#editSymptomModal').animate({
                            scrollTop: $(".modal-header").offset().top
                        }, 1000);
                    }
                }
            }).fail(function (response) {
                $(".symptom-edit-modal-preview-btn").removeClass('hidden');

                // $('.symptom-edit-modal-submit-btn').prop('disabled', false);
                if(!$(".symptom_edit_modal_loader .loading-msg").hasClass('hidden'))
                    $(".symptom_edit_modal_loader .loading-msg").addClass('hidden');
                $(".symptom_edit_modal_loader .error-msg").html('Something went wrong11!');
                if($(".symptom_edit_modal_loader").hasClass('hidden'))
                    $(".symptom_edit_modal_loader").removeClass('hidden');
                $('#editSymptomModal').animate({
                    scrollTop: $(".modal-header").offset().top
                }, 1000);
            });
        }
    });

    // Add synonym
    $('body').on('click','.add-symptom-synonym-btn', function(e){
        $("#add_synonym_modal_loader .loading-msg").removeClass('hidden');
        $("#add_synonym_modal_loader .error-msg").html('');
        if(!$("#add_synonym_modal_loader").hasClass('hidden'))
            $("#add_synonym_modal_loader").addClass('hidden');
        $("#synonym_language_error").html("");
        $("#word_error").html("");
        $("#strict_synonym_error").html("");
        $('#add_symptom_synonym_form')[0].reset();
        var quelleId =  $(this).attr("data-quelle-id");
        var arzneiId =  $(this).attr("data-arznei-id");
        var mId =  $(this).attr("data-quelle-import-master-id");
        $("#modal_quelle_id").val(quelleId);
        $("#modal_arznei_id").val(arzneiId);
        $("#modal_quelle_import_master_id").val(mId);
        $("#addSynonymModal").modal('show');
    });

    $('body').on( 'click', '.symptom-synonym-modal-submit-btn', function(e) {
        $("#add_synonym_modal_loader .loading-msg").removeClass('hidden');
        $("#add_synonym_modal_loader .error-msg").html('');
        if($("#add_synonym_modal_loader").hasClass('hidden'))
            $("#add_synonym_modal_loader").removeClass('hidden');

        var synonym_language = $("#synonym_language").val();
        var word = $("#word").val();
        var strict_synonym = $("#strict_synonym").val();
        var modal_quelle_id = $("#modal_quelle_id").val();
        var modal_arznei_id = $("#modal_arznei_id").val();
        var modal_quelle_import_master_id = $("#modal_quelle_import_master_id").val();
        var error_count = 0;
        if(synonym_language == ""){
            $("#synonym_language_error").html("This field is required");
            error_count++;
        }else{
            $("#synonym_language_error").html("");
        }
        if(word == ""){
            $("#word_error").html("This field is required");
            error_count++;
        }else{
            $("#word_error").html("");
        }
        if(strict_synonym == ""){
            $("#strict_synonym_error").html("This field is required");
            error_count++;
        }else{
            $("#strict_synonym_error").html("");
        }
        if(modal_quelle_id == "" || modal_arznei_id == "" || modal_quelle_import_master_id == ""){
            error_count++;
        }

        if(error_count != 0){
            if(!$("#add_synonym_modal_loader .loading-msg").hasClass('hidden'))
                $("#add_synonym_modal_loader .loading-msg").addClass('hidden');
            $("#add_synonym_modal_loader .error-msg").html('Required data not found.');
            if($("#add_synonym_modal_loader").hasClass('hidden'))
                $("#add_synonym_modal_loader").removeClass('hidden');
            $('#addSynonymModal').animate({
                scrollTop: $(".modal-header").offset().top
            }, 1000);
            return false;
        } else {
            $('.symptom-synonym-modal-submit-btn').prop('disabled', true);
            var data = $("#add_symptom_synonym_form").serialize();
            console.log(data);
            $.ajax({
                type: 'POST',
                url: 'add-symptom-synonym.php',
                data: {
                    form: data
                },
                dataType: "json",
                success: function( response ) {
                    console.log(response);
                    return false;
                    if(response.status == "success"){
                        $('.symptom-synonym-modal-submit-btn').prop('disabled', false);
                        $('#add_symptom_synonym_form')[0].reset();
                        if(!$("#add_synonym_modal_loader .loading-msg").hasClass('hidden'))
                            $("#add_synonym_modal_loader .loading-msg").addClass('hidden');
                        $("#add_synonym_modal_loader .error-msg").html(response.message);
                        if($("#add_synonym_modal_loader").hasClass('hidden'))
                            $("#add_synonym_modal_loader").removeClass('hidden');
                        $('#addSynonymModal').animate({
                            scrollTop: $(".modal-header").offset().top
                        }, 1000);
                    }else{
                        $('.symptom-synonym-modal-submit-btn').prop('disabled', false);
                        if(!$("#add_synonym_modal_loader .loading-msg").hasClass('hidden'))
                            $("#add_synonym_modal_loader .loading-msg").addClass('hidden');
                        $("#add_synonym_modal_loader .error-msg").html(response.message);
                        if($("#add_synonym_modal_loader").hasClass('hidden'))
                            $("#add_synonym_modal_loader").removeClass('hidden');
                        $('#addSynonymModal').animate({
                            scrollTop: $(".modal-header").offset().top
                        }, 1000);
                    }
                }
            }).fail(function (response) {
                $('.symptom-synonym-modal-submit-btn').prop('disabled', false);
                if(!$("#add_synonym_modal_loader .loading-msg").hasClass('hidden'))
                    $("#add_synonym_modal_loader .loading-msg").addClass('hidden');
                $("#add_synonym_modal_loader .error-msg").html('Something went wrong!');
                if($("#add_synonym_modal_loader").hasClass('hidden'))
                    $("#add_synonym_modal_loader").removeClass('hidden');
                $('#addSynonymModal').animate({
                    scrollTop: $(".modal-header").offset().top
                }, 1000);
            });
        }
    });
</script>
</body>
</html>

