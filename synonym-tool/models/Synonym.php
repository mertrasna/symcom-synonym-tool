<?php
include_once __DIR__ . '/../config/route.php'; 

class Synonym {
    private $db;

    // global $db from route.php
    public function __construct() {
        global $db; 
        $this->db = $db;
    }

    // Search synonyms in synonym_de table
    public function getSymptoms($masterId) {
        global $db; 
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
