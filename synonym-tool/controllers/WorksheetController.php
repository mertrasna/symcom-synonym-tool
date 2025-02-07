<?php
include __DIR__ . '/../config/route.php'; 
include __DIR__ . '/../models/Symptom.php';
include __DIR__ . '/../models/Synonym.php';

class WorksheetController {
    public function displayWorksheet() {
        global $db;

        if (!$db) {
            die("<p style='color:red;'>Database connection failed: " . mysqli_connect_error() . "</p>");
        }

        $symptomModel = new Symptom();
        $masterId = isset($_GET['mid']) ? intval($_GET['mid']) : 0;

        if ($masterId == 0) {
            $midResult = mysqli_query($db, "SELECT DISTINCT master_id FROM quelle_import_test ORDER BY master_id ASC LIMIT 1");
            $row = mysqli_fetch_assoc($midResult);
            if ($row) {
                $masterId = $row['master_id'];
                header("Location: " . $_SERVER['PHP_SELF'] . "?mid=" . $masterId);
                exit;
            } else {
                die("<p style='color:red;'>Error: No valid master ID found in database.</p>");
            }
        }

        $symptoms = [];
        $query = "SELECT id, BeschreibungOriginal_de FROM quelle_import_test WHERE master_id = '$masterId' ORDER BY id ASC";
        $symptomResult = mysqli_query($db, $query);

        if (!$symptomResult) {
            die("<p style='color:red;'>SQL Error: " . mysqli_error($db) . "</p>");
        }

        while ($row = mysqli_fetch_assoc($symptomResult)) {
            $symptoms[] = [
                "id" => $row['id'],
                "original_symptom" => $row['BeschreibungOriginal_de']
            ];
        }

        if (empty($symptoms)) {
            die("<p style='color:red;'>DEBUG: No symptoms found for Master ID: $masterId</p>");
        }

        include __DIR__ . '/../views/worksheet.php';
    }
}

$controller = new WorksheetController();
$controller->displayWorksheet();
?>
