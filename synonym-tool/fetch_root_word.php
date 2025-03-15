<?php
// 1) Include your config & set up error handling
include '../config/route.php'; // Initializes $db if not already done

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2) Ensure POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 3) Extract parameters safely
    $wordRaw = isset($_POST['word']) ? trim($_POST['word']) : '';
    $masterId = isset($_POST['master_id']) ? intval($_POST['master_id']) : 5075;

    // 4) Validate the 'word' parameter
    if (empty($wordRaw)) {
        echo json_encode([
            'success' => false,
            'message' => 'No word provided.'
        ]);
        exit;
    }

    // 5) Decide which table to use (German or English)
    $tableName = ($masterId === 5072) ? 'synonym_de' : 'synonym_en';

    // 6) Escape input for safety
    $wordEscaped = mysqli_real_escape_string($db, $wordRaw);

    // 7) Build the query: look for root_word where word (case-insensitive) matches
    $query = "
        SELECT root_word
          FROM $tableName
         WHERE LOWER(word) = LOWER('$wordEscaped')
         LIMIT 1
    ";

    // 8) Execute and handle results
    $result = mysqli_query($db, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode([
            'success' => true,
            'word' => $row['root_word'] ?? '' // root_word may be NULL or empty
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "No root word found for '$wordRaw' in $tableName."
        ]);
    }

} else {
    // Invalid method
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>
