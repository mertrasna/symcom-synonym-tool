<?php
include '../config/route.php';

// Get the masterId from POST (or default to 5075 if not provided)
$masterId = isset($_POST['master_id']) ? intval($_POST['master_id']) : 5075;

include './repositories/SynonymRepository.php';
include './services/SynonymService.php';

// Dependency Injection
$synonymRepo = new SynonymRepository($db, $masterId);
$synonymService = new SynonymService($synonymRepo);

header('Content-Type: application/json'); // Ensure JSON response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['word']) && !empty($_POST['word'])) {
        $word = trim($_POST['word']);
        $word = preg_replace('/[^\w\s-]/', '', $word); // Remove punctuation

        // **LOG QUERY SAFELY**
        error_log("Executing Query for word: " . $word);

        // Process synonym search and update
        $response = $synonymService->processSynonymSearchAndUpdate($word);

        // **ENSURE ONLY JSON OUTPUT**
        echo json_encode($response);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'No word provided']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

?>
