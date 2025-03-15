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

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['word']) && !empty($_POST['word'])) {
        // Sanitize the input word
        $word = mysqli_real_escape_string($db, $_POST['word']);
        
        // Retrieve master_id from POST (default to 5075 for English if not provided)
        $masterId = isset($_POST['master_id']) ? intval($_POST['master_id']) : 5075;
        
        // Choose the table based on master_id (5072 for German, 5075 for English)
        $table = ($masterId === 5072) ? 'synonym_de' : 'synonym_en';

        // Search in the selected synonym table across relevant columns
        $query = "
            SELECT * FROM $table 
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
