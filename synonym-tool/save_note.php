<?php
include '../config/route.php';
header('Content-Type: application/json');
ini_set('display_errors', 0); // Prevent HTML errors in output

// Check if we have a valid request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get parameters
if (!isset($_POST['word']) || empty($_POST['word'])) {
    echo json_encode(['success' => false, 'message' => 'No word provided']);
    exit;
}

if (!isset($_POST['note'])) {
    echo json_encode(['success' => false, 'message' => 'No note provided']);
    exit;
}

// Sanitize inputs
$word = mysqli_real_escape_string($db, trim($_POST['word']));
$note = mysqli_real_escape_string($db, trim($_POST['note']));
$masterId = isset($_POST['master_id']) ? intval($_POST['master_id']) : 5075;

// Determine which table to use based on master_id
$synonymTable = ($masterId === 5072) ? 'synonym_de' : 'synonym_en';
$notesTable = ($masterId === 5072) ? 'synonym_de_notes' : 'synonym_en_notes';

try {
    // For debugging
    error_log("save_note.php: Attempting to save note for word: '$word' in $synonymTable");
    
    // First, check if the word exists in the synonym table
    $findWordQuery = "SELECT * FROM $synonymTable WHERE word = '$word' LIMIT 1";
    $wordResult = mysqli_query($db, $findWordQuery);
    
    if (!$wordResult) {
        error_log("save_note.php: Error finding word: " . mysqli_error($db));
        echo json_encode(['success' => false, 'message' => "Query error: " . mysqli_error($db)]);
        exit;
    }
    
    $synonymId = null;
    
    // If word exists, get its ID
    if (mysqli_num_rows($wordResult) > 0) {
        $wordRow = mysqli_fetch_assoc($wordResult);
        
        // Try to find ID field 
        if (isset($wordRow['id'])) {
            $synonymId = $wordRow['id'];
        } elseif (isset($wordRow['synonym_id'])) {
            $synonymId = $wordRow['synonym_id'];
        } else {
            // Get the first column as a fallback
            $keys = array_keys($wordRow);
            $synonymId = $wordRow[$keys[0]];
            error_log("save_note.php: Using fallback ID field: " . $keys[0] . " with value: " . $synonymId);
        }
    } else {
        // If word doesn't exist, insert it into synonym table
        error_log("save_note.php: Word '$word' not found, creating new entry");
        
        $insertWordQuery = "INSERT INTO $synonymTable (word) VALUES ('$word')";
        if (!mysqli_query($db, $insertWordQuery)) {
            error_log("save_note.php: Error inserting word: " . mysqli_error($db));
            echo json_encode(['success' => false, 'message' => "Failed to insert word: " . mysqli_error($db)]);
            exit;
        }
        
        $synonymId = mysqli_insert_id($db);
        
        if (!$synonymId) {
            error_log("save_note.php: Failed to get ID of newly inserted word");
            echo json_encode(['success' => false, 'message' => "Failed to get ID for new word"]);
            exit;
        }
        
        error_log("save_note.php: Created new word with ID: $synonymId");
    }
    
    // Check if a note already exists for this synonym
    $checkNoteQuery = "SELECT note_id FROM $notesTable WHERE synonym_id = $synonymId";
    $checkResult = mysqli_query($db, $checkNoteQuery);
    
    if (!$checkResult) {
        error_log("save_note.php: Error checking for existing note: " . mysqli_error($db));
        echo json_encode(['success' => false, 'message' => "Failed to check for existing note: " . mysqli_error($db)]);
        exit;
    }
    
    if (mysqli_num_rows($checkResult) > 0) {
        // Update existing note
        $noteRow = mysqli_fetch_assoc($checkResult);
        $noteId = $noteRow['note_id'];
        
        $updateQuery = "UPDATE $notesTable SET note = '$note', updated_at = NOW() WHERE note_id = $noteId";
        error_log("save_note.php: Updating existing note with ID: $noteId");
        
        if (mysqli_query($db, $updateQuery)) {
            echo json_encode(['success' => true, 'message' => 'Note updated successfully']);
        } else {
            error_log("save_note.php: Error updating note: " . mysqli_error($db));
            echo json_encode(['success' => false, 'message' => 'Error updating note: ' . mysqli_error($db)]);
        }
    } else {
        // Insert new note
        $insertQuery = "INSERT INTO $notesTable (synonym_id, note, created_at) VALUES ($synonymId, '$note', NOW())";
        error_log("save_note.php: Inserting new note for synonym ID: $synonymId");
        
        if (mysqli_query($db, $insertQuery)) {
            echo json_encode(['success' => true, 'message' => 'Note saved successfully']);
        } else {
            error_log("save_note.php: Error saving note: " . mysqli_error($db));
            echo json_encode(['success' => false, 'message' => 'Error saving note: ' . mysqli_error($db)]);
        }
    }
} catch (Exception $e) {
    error_log("save_note.php: Exception: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>