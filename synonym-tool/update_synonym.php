<?php
include '../config/route.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $word = isset($_POST['word']) ? trim($_POST['word']) : '';

    // received word log
    error_log("Received Word: " . $word);

    if (empty($word)) {
        echo json_encode(["success" => false, "message" => "Error: Selected word is empty."]);
        exit;
    }

    // convert to lowercase to match DB
    $word = strtolower($word);

    // debugging
    error_log(" Searching for Word: " . $word);

    // checking if the word exists in the database
    $fetchStmt = $db->prepare("SELECT strict_synonym, synonym_partial_1, synonym_general, synonym_minor FROM synonym_de WHERE LOWER(word) = LOWER(?)");
    $fetchStmt->bind_param("s", $word);
    $fetchStmt->execute();
    $fetchResult = $fetchStmt->get_result()->fetch_assoc();

    if (!$fetchResult) {
        error_log("❌ Word not found in DB: " . $word);
        echo json_encode(["success" => false, "message" => "Word not found in database."]);
        exit;
    }

    // decode the selected synonyms
    $selectedSynonyms = json_decode($_POST['synonyms'], true);

    // preserve the existing values if no new values are selected
    $strictSynonyms = !empty($selectedSynonyms['S']) ? implode(", ", array_column($selectedSynonyms['S'], 'word')) : $fetchResult['strict_synonym'];
    $crossReferences = !empty($selectedSynonyms['Q']) ? implode(", ", array_column($selectedSynonyms['Q'], 'word')) : $fetchResult['synonym_partial_1'];
    $hypernyms = !empty($selectedSynonyms['O']) ? implode(", ", array_column($selectedSynonyms['O'], 'word')) : $fetchResult['synonym_general'];
    $hyponyms = !empty($selectedSynonyms['U']) ? implode(", ", array_column($selectedSynonyms['U'], 'word')) : $fetchResult['synonym_minor'];

    // Update the database
    $updateStmt = $db->prepare("UPDATE synonym_de SET strict_synonym = ?, synonym_partial_1 = ?, synonym_general = ?, synonym_minor = ? WHERE LOWER(word) = LOWER(?)");
    $updateStmt->bind_param("sssss", $strictSynonyms, $crossReferences, $hypernyms, $hyponyms, $word);

    if ($updateStmt->execute()) {
        error_log(" Update Successful for: " . $word);
        echo json_encode(["success" => true, "message" => "Synonyms updated successfully."]);
    } else {
        error_log("Update Failed for: " . $word);
        echo json_encode(["success" => false, "message" => "Database update failed."]);
    }
}
?>
