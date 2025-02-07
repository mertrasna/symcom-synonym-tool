<?php
include_once __DIR__ . '/../config/route.php'; // Use existing $db connection

class Synonym {
    private $db;

    public function __construct() {
        global $db; // Use existing database connection from route.php
        $this->db = $db;
    }

    public function getSymptoms($masterId) {
        global $db; // Use database connection from route.php
    
        if ($masterId <= 0) {
            echo "<pre>DEBUG: Invalid masterId ($masterId)</pre>";
            return [];
        }
    
        $query = "SELECT id, BeschreibungOriginal_de FROM quelle_import_test WHERE master_id = ?";
        $stmt = $db->prepare($query);
    
        if (!$stmt) {
            echo "<pre>DEBUG: SQL Prepare Error - " . $db->error . "</pre>";
            return [];
        }
    
        $stmt->bind_param("i", $masterId);
        $stmt->execute();
    
        // Replace get_result() with fetch_assoc()
        $stmt->store_result();
        $stmt->bind_result($id, $beschreibung);
    
        $symptoms = [];
        while ($stmt->fetch()) {
            echo "<pre>DEBUG: SYMPTOM ROW: id=$id, text=$beschreibung</pre>";
            $symptoms[] = [
                "id" => $id,
                "original_symptom" => $beschreibung
            ];
        }
    
        echo "<pre>DEBUG: Retrieved " . count($symptoms) . " symptoms</pre>";
        return $symptoms;
    }
    
    

}
?>
