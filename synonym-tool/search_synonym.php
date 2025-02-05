<?php
include '../config/route.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['word']) && !empty($_POST['word'])) {
        $word = mysqli_real_escape_string($db, $_POST['word']);
        
        // Search in the entire synonym_en table, across relevant columns
        $query = "
        SELECT * FROM synonym_de 
        WHERE LOWER(word) LIKE LOWER('%$word%') 
           OR LOWER(strict_synonym) LIKE LOWER('%$word%') 
           OR LOWER(synonym_partial_1) LIKE LOWER('%$word%')
           OR LOWER(synonym_general) LIKE LOWER('%$word%')
           OR LOWER(synonym_minor) LIKE LOWER('%$word%')
    ";

        error_log("Executing SQL: $query"); // Log the query

        $result = mysqli_query($db, $query);
        $synonyms = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $synonyms[] = $row;
            }
        }

        if (!empty($synonyms)) {
            echo json_encode(['success' => true, 'synonyms' => $synonyms]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No synonym found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No word provided']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>