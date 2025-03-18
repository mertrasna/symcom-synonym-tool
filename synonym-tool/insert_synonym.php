<?php
include '../config/route.php';

// Get master_id from POST (default to 5075 for English if not provided)
$masterId = isset($_POST['master_id']) ? intval($_POST['master_id']) : 5075;

include './repositories/SynonymRepository.php';
include './services/SynonymService.php';

// Dependency Injection: pass $masterId into the repository constructor
$synonymRepo = new SynonymRepository($db, $masterId);
$synonymService = new SynonymService($synonymRepo);

// Ensure correct character encoding
@header('Content-Type: application/json; charset=UTF-8');

try {
    if (isset($_POST['word']) && !empty(trim($_POST['word']))) {
        
        //  **Sanitize word input (Allow German & accented characters, Keep Spaces)**
        $word = trim($_POST['word'], " ,\t\n\r\0\x0B)"); 
        $word = mb_strtolower($word, 'UTF-8'); // Convert to lowercase (supports special characters)
        $word = preg_replace('/[^a-z0-9äöüßéèêôûñ\s-]/u', '', $word); //  Keeps spaces and dashes (-)

        //  **Sanitize synonym list**
        $synonym = trim($_POST['synonym'] ?? '', " ,\t\n\r\0\x0B)");
        $synonym = preg_replace('/[\r\n]+/', ', ', $synonym); // Replace newlines with commas
        $synonym = preg_replace('/[^a-zA-Z0-9äöüßéèêôûñ\s,-]/u', '', $synonym); //  Keeps spaces & dashes
        
        //  **Convert synonym list to lowercase array (keeping spaces)**
        $synonymsArray = array_unique(array_filter(array_map(function ($syn) {
            return mb_strtolower(trim($syn), 'UTF-8'); // Convert each synonym to lowercase properly
        }, explode(',', $synonym))));

        //  **Convert array back to string**
        $cleanedSynonyms = implode(', ', $synonymsArray);

        //  **Prevent empty synonym insertion**
        if (empty($cleanedSynonyms)) {
            echo json_encode(["success" => false, "message" => "Synonym list is empty after processing."]);
            exit;
        }

        //  **Prepare data array**
        $data = [
            'word' => $word,
            'synonym' => $cleanedSynonyms,
            'cross_reference' => $_POST['cross_reference'] ?? '',
            'synonym_partial_2' => $_POST['synonym_partial_2'] ?? '',
            'generic_term' => $_POST['generic_term'] ?? '',
            'sub_term' => $_POST['sub_term'] ?? '',
            'synonym_nn' => $_POST['synonym_nn'] ?? '',
            'comment' => $_POST['comment'] ?? '',
            'non_secure_flag' => $_POST['non_secure_flag'] ?? '0',
            'source_reference_ns' => $_POST['source_reference_ns'] ?? '1',
            'active' => $_POST['active'] ?? '1',
            'existing_synonym' => $_POST['existing_synonym'] ?? '',
            'master_id' => $masterId
        ];

        //  **Call service method to add/update the synonym**
        $response = $synonymService->processAddOrUpdateSynonym($data);

        //  **Return response**
        echo json_encode($response);
    } else {
        echo json_encode(["success" => false, "message" => "No valid word provided."]);
    }
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
?>
