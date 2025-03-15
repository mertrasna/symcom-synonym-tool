<?php
// 1) Include your config & set up error handling
include '../config/route.php'; // This should initialize $db

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2) Ensure it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 3) Extract parameters safely
    $word = isset($_POST['word']) ? trim($_POST['word']) : '';
    $masterId = isset($_POST['master_id']) ? intval($_POST['master_id']) : 5075;

    // 4) Check if 'word' was provided
    if (empty($word)) {
        echo json_encode([
            'success' => false,
            'message' => 'No word provided'
        ]);
        exit;
    }

    // 5) Decide which table to use based on master_id
    $tableName = ($masterId === 5072) ? 'synonym_de' : 'synonym_en';

    // 6) Escape the 'word' for safety
    $wordEscaped = mysqli_real_escape_string($db, $word);

    // 7) Build the query
    $query = "SELECT root_word 
                FROM $tableName 
               WHERE LOWER(word) = LOWER('$wordEscaped') 
               LIMIT 1";

    // 8) Execute query
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode([
            'success' => true, 
            'word' => $row['root_word'] ?? ''
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => "No root word found for '$word' in $tableName"
        ]);
    }
} else {
    // Invalid method
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>
