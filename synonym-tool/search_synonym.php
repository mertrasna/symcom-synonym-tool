<?php
include '../config/route.php';

// Get the masterId from POST (or default to 5075 if not provided)
$masterId = isset($_POST['master_id']) ? intval($_POST['master_id']) : 5075;

include './repositories/SynonymRepository.php';
include './services/SynonymService.php';

// Dependency Injection
$synonymRepo = new SynonymRepository($db, $masterId);
$synonymService = new SynonymService($synonymRepo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['word']) && !empty($_POST['word'])) {
        $word = trim($_POST['word']);
        $word = preg_replace('/[^\w-]/', '', $word); // Remove punctuation

        // Process synonym search and update
        $response = $synonymService->processSynonymSearchAndUpdate($word);

        // Send response back to the client
        echo json_encode($response);
    } else {
        echo json_encode(['success' => false, 'message' => 'No word provided']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
