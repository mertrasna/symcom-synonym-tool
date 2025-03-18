<?php
include '../config/route.php'; // Ensure this initializes $db

header('Content-Type: application/json'); // Force JSON response
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if $db is initialized, and initialize it if not
if (!isset($db)) {
    $db = new mysqli("127.0.0.1", "root", "root", "symcom_minified_db", 6000);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['word']) && !empty($_POST['word'])) {
        // Sanitize the input word
        $word = mysqli_real_escape_string($db, $_POST['word']);
        
        // Retrieve master_id from POST (default to 5075 for English if not provided)
        $masterId = isset($_POST['master_id']) ? intval($_POST['master_id']) : 5075;
        
        // Choose the table based on master_id (5072 for German, 5075 for English)
        $table = ($masterId === 5072) ? 'synonym_de' : 'synonym_en';

        // First, query for records where isyellow = 1
        $queryYellow = "
            SELECT * FROM $table 
            WHERE isyellow = 1 
              AND (
                  word LIKE '%$word%' OR
                  synonym LIKE '%$word%' OR
                  cross_reference LIKE '%$word%' OR 
                  synonym_partial_2 LIKE '%$word%' OR
                  generic_term LIKE '%$word%' OR
                  sub_term LIKE '%$word%' OR
                  synonym_nn LIKE '%$word%' OR
                  comment LIKE '%$word%'
              )
        ";
        $resultYellow = mysqli_query($db, $queryYellow);
        $synonyms = [];
        if ($resultYellow && mysqli_num_rows($resultYellow) > 0) {
            while ($row = mysqli_fetch_assoc($resultYellow)) {
                $synonyms[] = $row;
            }
            echo json_encode([
                'success' => true, 
                'synonyms' => $synonyms, 
                'message' => 'Yellow synonym(s) found'
            ]);
            exit; // Stop here – we do not want to return green records if any yellow exist.
        }
        
        // If no yellow synonyms are found, query for isgreen = 1
        $queryGreen = "
            SELECT * FROM $table 
            WHERE isgreen = 1
              AND (
                  word LIKE '%$word%' OR
                  synonym LIKE '%$word%' OR
                  cross_reference LIKE '%$word%' OR 
                  synonym_partial_2 LIKE '%$word%' OR
                  generic_term LIKE '%$word%' OR
                  sub_term LIKE '%$word%' OR
                  synonym_nn LIKE '%$word%' OR
                  comment LIKE '%$word%'
              )
        ";
        $resultGreen = mysqli_query($db, $queryGreen);
        if ($resultGreen) {
            while ($row = mysqli_fetch_assoc($resultGreen)) {
                $synonyms[] = $row;
            }
        }
        
        if (!empty($synonyms)) {
            echo json_encode([
                'success' => true, 
                'synonyms' => $synonyms, 
                'message' => 'Green synonym(s) found'
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
