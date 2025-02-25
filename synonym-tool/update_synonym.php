<?php
include '../config/route.php';
include './repositories/SynonymRepository.php';
include './services/SynonymService.php';

// Dependency Injection
$synonymRepo = new SynonymRepository($db);
$synonymService = new SynonymService($synonymRepo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $word = isset($_POST['word']) ? trim($_POST['word']) : '';
    $rootWord = isset($_POST['root_word']) ? trim($_POST['root_word']) : '';
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $selectedSynonyms = json_decode($_POST['synonyms'], true);

    $response = $synonymService->processSynonymUpdate($word, $rootWord, $comment, $selectedSynonyms);

    echo json_encode($response);
}
?>
