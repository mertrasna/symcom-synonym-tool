<?php
include '../config/route.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $word = isset($_POST['word']) ? trim($_POST['word']) : '';
    $rootWord = isset($_POST['root_word']) ? trim($_POST['root_word']) : ''; // Get the root word
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : ''; // Get the comment


    // Log received data for debugging
    error_log("Received Word: " . $word);
    error_log("Received Root Word: " . $rootWord);

    if (empty($word) || empty($rootWord)) {
        echo json_encode(["success" => false, "message" => "Error: Selected word and root word are required."]);
        exit;
    }

    // Convert to lowercase for consistency
    $word = strtolower($word);
    $rootWord = strtolower($rootWord);

    // Debugging log
    error_log("Searching for Word: " . $word);

    // Check if the word exists in the database
    $fetchStmt = $db->prepare("SELECT root_word, strict_synonym, synonym_partial_1, synonym_general, synonym_minor FROM synonym_de WHERE LOWER(word) = LOWER(?)");
    $fetchStmt->bind_param("s", $word);
    $fetchStmt->execute();
    $fetchResult = $fetchStmt->get_result()->fetch_assoc();

    if (!$fetchResult) {
        // If the word doesn't exist, insert it as a new root word
        error_log("❌ Word not found in DB. Inserting new root word: " . $rootWord);
        $insertStmt = $db->prepare("INSERT INTO synonym_de (root_word, word) VALUES (?, ?)");
        $insertStmt->bind_param("ss", $rootWord, $word);
        if (!$insertStmt->execute()) {
            error_log("❌ Insert Failed for Root Word: " . $rootWord);
            echo json_encode(["success" => false, "message" => "Error inserting root word."]);
            exit;
        }
        $insertStmt->close();
    }

    // Decode the selected synonyms from JSON
    $selectedSynonyms = json_decode($_POST['synonyms'], true);

    // Preserve existing values if no new values are selected
    $strictSynonyms = !empty($selectedSynonyms['S']) ? implode(", ", array_column($selectedSynonyms['S'], 'word')) : $fetchResult['strict_synonym'];
    $crossReferences = !empty($selectedSynonyms['Q']) ? implode(", ", array_column($selectedSynonyms['Q'], 'word')) : $fetchResult['synonym_partial_1'];
    $hypernyms = !empty($selectedSynonyms['O']) ? implode(", ", array_column($selectedSynonyms['O'], 'word')) : $fetchResult['synonym_general'];
    $hyponyms = !empty($selectedSynonyms['U']) ? implode(", ", array_column($selectedSynonyms['U'], 'word')) : $fetchResult['synonym_minor'];

    // Determine the value for synonym_ns: if a comment exists, set it to '1'; otherwise '0'
    $synonym_ns = !empty($comment) ? '1' : '0';

    // Update the database with new synonyms, root word, comment, and synonym_ns
    $updateStmt = $db->prepare("UPDATE synonym_de SET root_word = ?, strict_synonym = ?, synonym_partial_1 = ?, synonym_general = ?, synonym_minor = ?, synonym_comment = ?, synonym_ns = ? WHERE LOWER(word) = LOWER(?)");
    $updateStmt->bind_param("ssssssss", $rootWord, $strictSynonyms, $crossReferences, $hypernyms, $hyponyms, $comment, $synonym_ns, $word);

    if ($updateStmt->execute()) {
        error_log("Update Successful for: " . $word);
        echo json_encode(["success" => true, "message" => "Root word, synonyms, and comment updated successfully."]);
    } else {
        error_log("Update Failed for: " . $word);
        echo json_encode(["success" => false, "message" => "Database update failed."]);
    }

    $updateStmt->close();
}
?>
