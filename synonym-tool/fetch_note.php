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
    // The key fix: Join the tables directly and find ANY notes for the word
    // without the LIMIT 1 on the first query
    $query = "
        SELECT n.note 
        FROM $synonymTable s
        JOIN $notesTable n ON s.id = n.synonym_id
        WHERE s.word = '$word'
        LIMIT 1
    ";
    
    error_log("Executing query: $query");
    $result = mysqli_query($db, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode([
            'success' => true,
            'note' => $row['note'],
            'message' => 'Note found'
        ]);
    } else {
        // Try a broader search if exact match fails
        $query = "
            SELECT n.note 
            FROM $synonymTable s
            JOIN $notesTable n ON s.id = n.synonym_id
            WHERE s.word LIKE '%$word%'
            LIMIT 1
        ";
        
        error_log("Executing broader query: $query");
        $result = mysqli_query($db, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode([
                'success' => true,
                'note' => $row['note'],
                'message' => 'Note found with partial match'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'note' => '',
                'message' => 'No note has been saved for this word yet'
            ]);
        }
    }
} catch (Exception $e) {
    error_log("Error in fetch_note.php: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>