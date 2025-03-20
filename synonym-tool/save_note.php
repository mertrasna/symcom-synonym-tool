<?php
 include '../config/route.php';
 header('Content-Type: application/json');
 
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
     // First, get the synonym ID
     $query = "SELECT id FROM $synonymTable WHERE word LIKE '%$word%' LIMIT 1";
     $result = mysqli_query($db, $query);
     
     if (!$result || mysqli_num_rows($result) === 0) {
         // Try to insert the word if it doesn't exist
         $insertQuery = "INSERT INTO $synonymTable (word, isgreen) VALUES ('$word', 1)";
         if (!mysqli_query($db, $insertQuery)) {
             echo json_encode(['success' => false, 'message' => "Could not create synonym entry for word: $word"]);
             exit;
         }
         
         // Get the ID of the newly inserted synonym
         $synonymId = mysqli_insert_id($db);
         
         if (!$synonymId) {
             echo json_encode(['success' => false, 'message' => "Failed to get ID for newly created synonym"]);
             exit;
         }
     } else {
         $row = mysqli_fetch_assoc($result);
         $synonymId = $row['id'];
     }
     
     // Check if a note already exists for this synonym
     $checkQuery = "SELECT note_id FROM $notesTable WHERE synonym_id = $synonymId";
     $checkResult = mysqli_query($db, $checkQuery);
     
     if ($checkResult && mysqli_num_rows($checkResult) > 0) {
         // Update existing note
         $row = mysqli_fetch_assoc($checkResult);
         $noteId = $row['note_id'];
         
         $updateQuery = "UPDATE $notesTable SET note = '$note', updated_at = NOW() WHERE note_id = $noteId";
         if (mysqli_query($db, $updateQuery)) {
             echo json_encode(['success' => true, 'message' => 'Note updated successfully']);
         } else {
             echo json_encode(['success' => false, 'message' => 'Error updating note: ' . mysqli_error($db)]);
         }
     } else {
         // Insert new note
         $insertQuery = "INSERT INTO $notesTable (synonym_id, note, created_at) VALUES ($synonymId, '$note', NOW())";
         if (mysqli_query($db, $insertQuery)) {
             echo json_encode(['success' => true, 'message' => 'Note saved successfully']);
         } else {
             echo json_encode(['success' => false, 'message' => 'Error saving note: ' . mysqli_error($db)]);
         }
     }
 } catch (Exception $e) {
     echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
 }
 ?>