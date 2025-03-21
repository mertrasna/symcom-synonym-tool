<?php
header('Content-Type: application/json'); // 1) Always return JSON

include '../config/route.php';
include './repositories/SynonymRepository.php';
include './services/SynonymService.php';

// 2) Read 'master_id' from POST, default to 5075 (English)
$masterId = isset($_POST['master_id']) ? intval($_POST['master_id']) : 5075;

// Create repository & service instances with the correct table
$synonymRepo = new SynonymRepository($db, $masterId);
$synonymService = new SynonymService($synonymRepo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Safely read incoming POST parameters
    $word     = isset($_POST['word']) ? trim($_POST['word']) : '';
    $rootWord = isset($_POST['root_word']) ? trim($_POST['root_word']) : '';
    $comment  = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $notSure = isset($_POST['notSure']) ? 1 : 0;
    $symptomText = isset($_POST['symptom_text']) ? trim($_POST['symptom_text']) : ''; // Added: Capture symptom text

    // 3) Decode 'synonyms' JSON safely
    $selectedSynonyms = [];
    if (isset($_POST['synonyms'])) {
        $selectedSynonyms = json_decode($_POST['synonyms'], true);
        // 4) Validate JSON parse
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid JSON in synonyms: ' . json_last_error_msg()
            ]);
            exit;
        }
    }

    // handling manually entered synonyms
    $manualSynonym = isset($_POST['manual_synonym']) ? trim($_POST['manual_synonym']) : '';
    $manualTypes = isset($_POST['manual_synonym_types']) ? json_decode($_POST['manual_synonym_types'], true) : [];

    if (!empty($manualSynonym) && !empty($manualTypes)) {
        foreach ($manualTypes as $type) {
            if (in_array($type, ["S", "Q", "O", "U"])) {
                //  Ensure the synonym is inserted successfully
                $insertSuccess = $synonymRepo->insertManualSynonym($manualSynonym, $rootWord, $type);
    
                //  If inserted, add it to selectedSynonyms
                if ($insertSuccess && !in_array($manualSynonym, $selectedSynonyms[$type] ?? [])) {
                    $selectedSynonyms[$type][] = $manualSynonym;
                }
            }
        }
    }
    
    //  Log manual synonym data before sending to `processSynonymUpdate()`
    error_log(" Selected Synonyms (Before Processing): " . json_encode($selectedSynonyms));
    
    // 5) Pass data to service, including symptom_text
    $response = $synonymService->processSynonymUpdate($word, $rootWord, $comment, $selectedSynonyms, $notSure, $symptomText); // Updated function call

    // 6) Output final JSON
    echo json_encode($response);
    exit;
} else {
    // 7) Handle invalid request methods
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}
?>
