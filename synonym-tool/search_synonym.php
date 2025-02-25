<?php
include '../config/route.php';
include './repositories/SynonymRepository.php';
include './services/SynonymService.php';

// Dependency Injection
$synonymRepo = new SynonymRepository($db);
$synonymService = new SynonymService($synonymRepo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['word']) && !empty($_POST['word'])) {
        $word = $_POST['word'];

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
