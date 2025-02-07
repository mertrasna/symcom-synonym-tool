<?php
include '../config/route.php';

class Symptom {
    public function getSymptoms($masterId) {
        global $db;

        if (!isset($db)) {
            echo "<pre>ERROR: Database connection is NOT available. Check route.php.</pre>";
            return [];
        }

        if ($masterId <= 0) {
            echo "<pre>DEBUG: Invalid masterId ($masterId)</pre>";
            return [];
        }

        $query = "SELECT id, BeschreibungOriginal_de FROM quelle_import_test WHERE master_id = ?";
        
        echo "<pre>DEBUG: Running query - " . $query . " with master_id = $masterId</pre>";

        $stmt = $db->prepare($query);
        
        if (!$stmt) {
            echo "<pre>ERROR: SQL Prepare Failed - " . $db->error . "</pre>";
            return [];
        }

        $stmt->bind_param("i", $masterId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            echo "<pre>ERROR: SQL Execution Failed - " . $db->error . "</pre>";
            return [];
        }

        $symptoms = [];
        while ($row = $result->fetch_assoc()) {
            echo "<pre>DEBUG: SYMPTOM ROW: " . json_encode($row) . "</pre>";
            $symptoms[] = [
                "id" => $row["id"],
                "original_symptom" => $row["BeschreibungOriginal_de"]
            ];
        }

        echo "<pre>DEBUG: Retrieved " . count($symptoms) . " symptoms</pre>";
        return $symptoms;
    }
}
?>
