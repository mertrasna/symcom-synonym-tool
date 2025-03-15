<?php
include '../config/route.php';

// Validate required POST parameters
if (!isset($_POST['word'], $_POST['master_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$word = trim($_POST['word']);
$masterId = intval($_POST['master_id']);

// Escape the search term
$wordEscaped = mysqli_real_escape_string($db, $word);

// Determine the synonym table based on master_id
if ($masterId === 5072) {
    $synonymTable = "synonym_de";
} elseif ($masterId === 5075) {
    $synonymTable = "synonym_en";
} else {
    // Default to English if the master ID is unknown
    $synonymTable = "synonym_en";
}

$query = "
    SELECT * FROM $synonymTable 
    WHERE 
        word LIKE '%$wordEscaped%' OR
        synonym LIKE '%$wordEscaped%' OR
        cross_reference LIKE '%$wordEscaped%' OR 
        synonym_partial_2 LIKE '%$wordEscaped%' OR
        generic_term LIKE '%$wordEscaped%' OR
        sub_term LIKE '%$wordEscaped%' OR
        synonym_nn LIKE '%$wordEscaped%' OR
        comment LIKE '%$wordEscaped%'
";

$result = mysqli_query($db, $query);
$synonyms = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $synonyms[] = $row;
    }
}

echo json_encode(['success' => true, 'synonyms' => $synonyms]);
exit;
?>
