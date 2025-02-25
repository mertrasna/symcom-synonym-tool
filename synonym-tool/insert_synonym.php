<?php
include '../config/route.php';
include './repositories/SynonymRepository.php';
include './services/SynonymService.php';

// Dependency Injection
$synonymRepo = new SynonymRepository($db);
$synonymService = new SynonymService($synonymRepo);

if (isset($_POST['word'])) {
    // Get and sanitize the inputs
    $word = $_POST['word'];
    $synonym = preg_replace('/\d+/', '', $_POST['synonym']); // Remove numbers
    $synonym = preg_replace('/[\r\n]+/', ', ', $synonym); // Replace newlines with commas
    $synonym = preg_replace('/\./', '', $synonym); // Remove periods
    $synonym = implode(',', array_map('trim', explode(',', $synonym))); // Clean extra spaces

    // Prepare the data for processing
    $data = [
        'word' => $word,
        'synonym' => $synonym,
        'cross_reference' => $_POST['cross_reference'],
        'synonym_partial_2' => $_POST['synonym_partial_2'],
        'generic_term' => $_POST['generic_term'],
        'sub_term' => $_POST['sub_term'],
        'synonym_nn' => $_POST['synonym_nn'],
        'comment' => $_POST['comment'],
        'non_secure_flag' => $_POST['non_secure_flag'],
        'source_reference_ns' => $_POST['source_reference_ns'],
        'active' => $_POST['active'],
        'existing_synonym' => isset($_POST['existing_synonym']) ? $_POST['existing_synonym'] : ''
    ];

    // Call the service method to process add or update synonym
    $response = $synonymService->processAddOrUpdateSynonym($data);

    // Return response back to the client
    echo json_encode($response);
} else {
    echo json_encode(["success" => false, "message" => "No word provided."]);
}
?>
