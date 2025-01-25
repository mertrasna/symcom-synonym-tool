<?php
include '../config/route.php';
include '../dev-exp/sub-section-config.php';
// include '../api/mainCall.php';
?>
<?php
    // Below codes fetches symptoms based on the source id received as GET param from the materia medica page.
    // Code starts
    try{
        // Change the working language based on the symptom version. 
        // Values: English = en | German = de
        $workingLangauge = "en";
        $masterId = (isset($_GET['mid']) AND $_GET['mid'] != "") ? $_GET['mid'] : ""; 
        if($masterId == ""){
            header('Location: '.$baseUrl);
            exit();
        }

        $result = mysqli_query($db,"SELECT * FROM quelle_import_test WHERE master_id = '".$masterId."' ORDER BY id ASC"); 
        if(!$result){
            throw new Exception("Error: ".$db->error);
        }
        while($row = mysqli_fetch_array($result)){
            $symptomEn = $row["Beschreibung_en"];
            $symptomDe = $row["Beschreibung_de"];

            if($workingLangauge == "en" && $symptomEn!=""){
                echo $symptomEn."<br>";
            }else{
                echo $symptomDe."<br>";
            }
        }
        $message = "success";
    }catch (Exception $e){
        $message = $e->getMessage();
    }
    // Code ends
?>