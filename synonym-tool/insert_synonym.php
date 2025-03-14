<?php
include '../config/route.php';
include './repositories/SynonymRepository.php';
include './services/SynonymService.php';

// Dependency Injection
$synonymRepo = new SynonymRepository($db);
$synonymService = new SynonymService($synonymRepo);

// Ensure correct character encoding
@header('Content-Type: application/json; charset=UTF-8');

try {
    if (isset($_POST['word']) && !empty(trim($_POST['word']))) {
        // Sanitize the word (remove trailing commas, spaces, hidden characters)
        $word = trim($_POST['word'], " ,\t\n\r\0\x0B"); 
        
        // Process the synonyms
        $synonym = trim($_POST['synonym'] ?? '', " ,\t\n\r\0\x0B"); // Remove trailing spaces & commas
        $synonym = preg_replace('/\d+/', '', $synonym); // Remove numbers
        $synonym = preg_replace('/[\r\n]+/', ', ', $synonym); // Replace newlines with commas
        $synonym = preg_replace('/\./', '', $synonym); // Remove periods
        $synonym = implode(',', array_map('trim', explode(',', $synonym))); // Remove extra spaces

        // Prevent empty synonyms from being inserted
        if (empty($synonym)) {
            echo json_encode(["success" => false, "message" => "Synonym list is empty after processing."]);
            exit;
        }

        // Prepare the data array
        $data = [
            'word' => $word,
            'synonym' => $synonym,
            'cross_reference' => $_POST['cross_reference'] ?? '',
            'synonym_partial_2' => $_POST['synonym_partial_2'] ?? '',
            'generic_term' => $_POST['generic_term'] ?? '',
            'sub_term' => $_POST['sub_term'] ?? '',
            'synonym_nn' => $_POST['synonym_nn'] ?? '',
            'comment' => $_POST['comment'] ?? '',
            'non_secure_flag' => $_POST['non_secure_flag'] ?? '1',
            'source_reference_ns' => $_POST['source_reference_ns'] ?? '1',
            'active' => $_POST['active'] ?? '1',
            'existing_synonym' => $_POST['existing_synonym'] ?? ''
        ];

        // Call the service method to add/update synonym
        $response = $synonymService->processAddOrUpdateSynonym($data);

        // Return response back to the client
        echo json_encode($response);
    } else {
        echo json_encode(["success" => false, "message" => "No valid word provided."]);
    }
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
?>