<?php
include '../config/route.php';
include './repositories/SynonymRepository.php';
include './services/SynonymService.php';

// Dependency Injection
$synonymRepo = new SynonymRepository($db);
$synonymService = new SynonymService($synonymRepo);

if (isset($_POST['word']) && !empty($_POST['word'])) {
    $word = $_POST['word'];

    // Call the service method to delete the stop word
    $response = $synonymService->processDeleteStopWord($word);

    // Send response back to the client
    echo json_encode($response);
} else {
    echo json_encode(["success" => false, "message" => "No word provided."]);
}
?>
