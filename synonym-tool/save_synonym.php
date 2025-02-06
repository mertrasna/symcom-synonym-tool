<?php
include '../config/route.php';
header('Content-Type: application/json');

// error reporting
ini_set('display_errors', 0);
error_reporting(E_ALL);
error_log("save_synonym.php started");

// checking the databases connection for debugging
if (!$db) {
    error_log("Database connection failed");
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// reading input data
$inputData = file_get_contents("php://input");
$synonyms = json_decode($inputData, true);

// checking the input data
if (!$synonyms || !isset($synonyms['synonyms']) || !is_array($synonyms['synonyms'])) {
    error_log("Invalid JSON input: " . $inputData);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit;
}

// synonym types mapping 
$columnMap = [
    'S' => 'strict_synonym',
    'Q' => 'synonym_partial_1',
    'O' => 'synonym_general',
    'U' => 'synonym_minor'
];

// processing each synonym entry
foreach ($synonyms['synonyms'] as $entry) {
    if (empty($entry['word']) || empty($entry['synonym']) || empty($entry['type'])) {
        error_log("Missing fields: " . json_encode($entry));
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }


    $word = mysqli_real_escape_string($db, $entry['word']); 
    $synonym = mysqli_real_escape_string($db, $entry['synonym']); 
    $type = mysqli_real_escape_string($db, $entry['type']);

    // checking the synonym type
    if (!isset($columnMap[$type])) {
        echo json_encode(['success' => false, 'message' => 'Invalid synonym type']);
        exit;
    }

    $column = $columnMap[$type];

    // Prevent duplicate synonyms
    $checkQuery = "SELECT $column FROM synonym_de WHERE word = '$word'";
    $result = mysqli_query($db, $checkQuery);
    if ($row = mysqli_fetch_assoc($result)) {
        $existingSynonyms = explode(', ', $row[$column]);
        if (in_array($synonym, $existingSynonyms)) {
            continue;
        }
    }

    // updating synonym database
    $updateQuery = "
        UPDATE synonym_de 
        SET $column = CONCAT_WS(', ', IFNULL(NULLIF($column, ''), ''), '$synonym') 
        WHERE word = '$word'
    ";

    // logging the update query
    error_log("Executing SQL: " . $updateQuery);

    if (!mysqli_query($db, $updateQuery)) {
        error_log("Database update failed: " . mysqli_error($db));
        echo json_encode(['success' => false, 'message' => 'Database update failed']);
        exit;
    }
}

// success response
error_log("Synonyms saved successfully");
echo json_encode(['success' => true, 'message' => 'Synonyms saved successfully']);
?>
