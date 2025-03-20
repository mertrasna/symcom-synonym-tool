<?php
// Turn off error display for production
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Set content type to JSON
header('Content-Type: application/json');

// Include configuration and database connection
include '../config/route.php';

// Function to return JSON error response
function return_error($message) {
    echo json_encode([
        'success' => false,
        'message' => $message
    ]);
    exit;
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return_error('Invalid request method');
}

// Check if word parameter exists
if (!isset($_POST['word']) || empty($_POST['word'])) {
    return_error('No word provided');
}

// Validate database connection
if (!isset($db) || $db->connect_error) {
    return_error('Database connection error: ' . ($db->connect_error ?? 'Unknown error'));
}

// Get and sanitize parameters
$word = mysqli_real_escape_string($db, trim($_POST['word']));
$masterId = isset($_POST['master_id']) ? intval($_POST['master_id']) : 5075;

// Determine which tables to use
$synonymTable = ($masterId === 5072) ? 'synonym_de' : 'synonym_en';
$notesTable = ($masterId === 5072) ? 'synonym_de_notes' : 'synonym_en_notes';

// Log what we're doing
error_log("fetch_note.php: Searching for notes for word '$word' in $synonymTable");

try {
    // First we need to find the synonym_id for this word
    $findSynonymQuery = "SELECT * FROM $synonymTable WHERE word = '$word' LIMIT 1";
    $synonymResult = mysqli_query($db, $findSynonymQuery);
    
    if (!$synonymResult) {
        error_log("fetch_note.php: Synonym query error: " . mysqli_error($db));
        return_error("Failed to find synonym: " . mysqli_error($db));
    }
    
    if (mysqli_num_rows($synonymResult) > 0) {
        $synonymRow = mysqli_fetch_assoc($synonymResult);
        $synonymId = $synonymRow['id'] ?? null; // Try to use 'id' field
        
        // If no 'id' field, try common alternatives
        if ($synonymId === null) {
            $synonymId = $synonymRow['synonym_id'] ?? $synonymRow['word_id'] ?? null;
            
            // If we still don't have an ID, dump the first row for debugging
            if ($synonymId === null) {
                error_log("fetch_note.php: Could not find ID field. Row data: " . json_encode($synonymRow));
                
                // Use the first field from the result as a last resort
                $keys = array_keys($synonymRow);
                if (!empty($keys)) {
                    $synonymId = $synonymRow[$keys[0]];
                    error_log("fetch_note.php: Using " . $keys[0] . " as ID field with value: " . $synonymId);
                } else {
                    return_error("Could not determine synonym ID");
                }
            }
        }
        
        // Now look for a note with this synonym_id
        $noteQuery = "SELECT note FROM $notesTable WHERE synonym_id = $synonymId LIMIT 1";
        $noteResult = mysqli_query($db, $noteQuery);
        
        if (!$noteResult) {
            error_log("fetch_note.php: Note query error: " . mysqli_error($db));
            return_error("Note query failed: " . mysqli_error($db));
        }
        
        if (mysqli_num_rows($noteResult) > 0) {
            $noteRow = mysqli_fetch_assoc($noteResult);
            echo json_encode([
                'success' => true,
                'note' => $noteRow['note'],
                'message' => 'Note found'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'note' => '',
                'message' => 'No note found for this synonym'
            ]);
        }
    } else {
        // If exact match fails, try with LIKE search
        $findSynonymQuery = "SELECT * FROM $synonymTable WHERE word LIKE '%$word%' LIMIT 1";
        $synonymResult = mysqli_query($db, $findSynonymQuery);
        
        if (!$synonymResult || mysqli_num_rows($synonymResult) === 0) {
            echo json_encode([
                'success' => false,
                'note' => '',
                'message' => 'No synonym found for this word'
            ]);
            exit;
        }
        
        $synonymRow = mysqli_fetch_assoc($synonymResult);
        $synonymId = $synonymRow['id'] ?? $synonymRow['synonym_id'] ?? $synonymRow['word_id'] ?? null;
        
        if ($synonymId === null) {
            // Dump field names for debugging
            error_log("fetch_note.php: Field names in synonym table: " . json_encode(array_keys($synonymRow)));
            return_error("Could not determine synonym ID field");
        }
        
        $noteQuery = "SELECT note FROM $notesTable WHERE synonym_id = $synonymId LIMIT 1";
        $noteResult = mysqli_query($db, $noteQuery);
        
        if (!$noteResult) {
            error_log("fetch_note.php: LIKE note query error: " . mysqli_error($db));
            return_error("Note query failed: " . mysqli_error($db));
        }
        
        if (mysqli_num_rows($noteResult) > 0) {
            $noteRow = mysqli_fetch_assoc($noteResult);
            echo json_encode([
                'success' => true,
                'note' => $noteRow['note'],
                'message' => 'Note found with partial match'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'note' => '',
                'message' => 'No note found for this synonym'
            ]);
        }
    }
} catch (Exception $e) {
    error_log("fetch_note.php: Exception: " . $e->getMessage());
    return_error('Error: ' . $e->getMessage());
}
?>