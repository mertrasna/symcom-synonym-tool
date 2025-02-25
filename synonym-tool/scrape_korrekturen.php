<?php
include '../config/route.php';
include './repositories/SynonymRepository.php';
include './services/SynonymService.php';

// Dependency Injection
$synonymRepo = new SynonymRepository($db);
$synonymService = new SynonymService($synonymRepo);

if (!isset($_GET['word']) || empty($_GET['word'])) {
    echo json_encode(["success" => false, "message" => "No word provided."]);
    exit;
}

$word = $_GET['word'];

// Call service method to scrape synonym data
$response = $synonymService->processScrapeSynonym($word);

// Send response back to the client
echo json_encode($response);
?>
