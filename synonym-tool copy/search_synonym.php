<?php
include '../config/route.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['word']) && !empty($_POST['word'])) {
        $word = mysqli_real_escape_string($db, $_POST['word']);
        
        // Search in the entire synonym_en table, across relevant columns
        $query = "
            SELECT * FROM synonym_de 
            WHERE 
                word LIKE '%$word%' OR
                strict_synonym LIKE '%$word%' OR
                synonym_partial_1 LIKE '%$word%' OR 
                synonym_partial_2 LIKE '%$word%' OR
                synonym_general LIKE '%$word%' OR
                synonym_minor LIKE '%$word%' OR
                synonym_nn LIKE '%$word%' OR
                synonym_comment LIKE '%$word%'
        ";

        $result = mysqli_query($db, $query);
        $synonyms = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $synonyms[] = $row;
            }

            // If synonym exists, update the 'isgreen' column
            if (!empty($synonyms)) {
                // Assuming you want to update the 'isgreen' column for the found synonym(s)
                $update_query = "
                    UPDATE synonym_de 
                    SET isgreen = 1
                    WHERE 
                        word LIKE '%$word%' OR
                        strict_synonym LIKE '%$word%' OR
                        synonym_partial_1 LIKE '%$word%' OR
                        synonym_partial_2 LIKE '%$word%' OR
                        synonym_general LIKE '%$word%' OR
                        synonym_minor LIKE '%$word%' OR
                        synonym_nn LIKE '%$word%' OR
                        synonym_comment LIKE '%$word%'
                ";
                
                $update_result = mysqli_query($db, $update_query);

                if ($update_result) {
                    echo json_encode(['success' => true, 'synonyms' => $synonyms, 'message' => 'Synonym updated successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update synonym']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'No synonym found']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error executing query']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No word provided']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

?>