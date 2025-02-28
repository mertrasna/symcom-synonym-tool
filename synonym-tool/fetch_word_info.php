<?php
include '../config/route.php'; // Ensure this initializes $db

header('Content-Type: application/json'); // Force JSON response
error_reporting(E_ALL);
ini_set('display_errors', 1);

// In fetch_word_info.php

// Check if $db is initialized, and initialize it if not
if (!isset($db)) {
    $db = new mysqli("127.0.0.1", "root", "root", "symcom_minified_db", 6000);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['word']) && !empty($_POST['word'])) {
        $word = mysqli_real_escape_string($db, $_POST['word']);

        // Search in the entire synonym_de table, across relevant columns
        $query = "
            SELECT * FROM synonym_de 
            WHERE 
                word LIKE '%$word%' OR
                synonym LIKE '%$word%' OR
                cross_reference LIKE '%$word%' OR 
                synonym_partial_2 LIKE '%$word%' OR
                generic_term LIKE '%$word%' OR
                sub_term LIKE '%$word%' OR
                synonym_nn LIKE '%$word%' OR
                comment LIKE '%$word%'
        ";

        $result = mysqli_query($db, $query);
        $synonyms = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $synonyms[] = $row;
            }

            if (!empty($synonyms)) {
                // Do not update the 'isgreen' column
                echo json_encode([
                    'success' => true, 
                    'synonyms' => $synonyms, 
                    'message' => 'Synonym found successfully'
                ]);
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'No synonym found'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Error executing query'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'No word provided'
        ]);
    }
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid request method'
    ]);
}

?>