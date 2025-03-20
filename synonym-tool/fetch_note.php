<?php
include '../config/route.php';
header('Content-Type: application/json');

// Check if we have a valid request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get parameters - only require word parameter
if (!isset($_POST['word']) || empty($_POST['word'])) {
    echo json_encode(['success' => false, 'message' => 'No word provided']);
    exit;
}

// Sanitize inputs
$word = mysqli_real_escape_string($db, trim($_POST['word']));
$masterId = isset($_POST['master_id']) ? intval($_POST['master_id']) : 5075;

// Determine which table to use based on master_id
$synonymTable = ($masterId === 5072) ? 'synonym_de' : 'synonym_en';
$notesTable = ($masterId === 5072) ? 'synonym_de_notes' : 'synonym_en_notes';

try {
    // First, get the synonym ID
    $query = "SELECT id FROM $synonymTable WHERE word = '$word' LIMIT 1";
    $result = mysqli_query($db, $query);
    
    if (!$result || mysqli_num_rows($result) === 0) {
        echo json_encode(['success' => false, 'message' => "Synonym not found for word: $word"]);
        exit;
    }
    
    $row = mysqli_fetch_assoc($result);
    $synonymId = $row['id'];
    
    // Check if a note exists for this synonym
    $checkQuery = "SELECT note FROM $notesTable WHERE synonym_id = $synonymId";
    $checkResult = mysqli_query($db, $checkQuery);
    
    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        // Return existing note
        $row = mysqli_fetch_assoc($checkResult);
        echo json_encode([
            'success' => true, 
            'note' => $row['note'],
            'message' => 'Note found'
        ]);
    } else {
        // No note found
        echo json_encode([
            'success' => false,
            'note' => '',
            'message' => 'No note found for this word'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>