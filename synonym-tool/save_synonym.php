<?php
include '../config/route.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $synonyms = json_decode($_POST['synonyms'], true);

    if (!$synonyms || !is_array($synonyms)) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
        exit;
    }

    foreach ($synonyms as $entry) {
        if (empty($entry['word']) || empty($entry['synonym']) || empty($entry['type'])) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        $word = mysqli_real_escape_string($db, $entry['word']);
        $synonym = mysqli_real_escape_string($db, $entry['synonym']);
        $type = mysqli_real_escape_string($db, $entry['type']);

        $columnMap = [
            'S' => 'strict_synonym',
            'Q' => 'synonym_partial_1',
            'O' => 'synonym_general',
            'U' => 'synonym_minor'
        ];

        if (!isset($columnMap[$type])) {
            echo json_encode(['success' => false, 'message' => 'Invalid synonym type']);
            exit;
        }

        $column = $columnMap[$type];

        // Update synonym_de table with new values, duplicate synonym issue for now!
        $updateQuery = "
            UPDATE synonym_de 
            SET $column = CONCAT_WS(', ', IFNULL($column, ''), '$synonym') 
            WHERE word = '$word'
            
        ";

        if (!mysqli_query($db, $updateQuery)) {
            echo json_encode(['success' => false, 'message' => 'Database update failed: ' . mysqli_error($db)]);
            exit;
        }
    }

    echo json_encode(['success' => true, 'message' => 'Synonyms saved successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
