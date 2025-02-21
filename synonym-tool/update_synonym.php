<?php
include '../config/route.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $word = isset($_POST['word']) ? trim($_POST['word']) : '';
    $rootWord = isset($_POST['root_word']) ? trim($_POST['root_word']) : '';
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

    error_log("Received Word: " . $word);
    error_log("Received Root Word: " . $rootWord);

    if (empty($word) || empty($rootWord)) {
        echo json_encode(["success" => false, "message" => "Error: Selected word and root word are required."]);
        exit;
    }

    $word = strtolower($word);
    $rootWord = strtolower($rootWord);

    $fetchStmt = $db->prepare("SELECT root_word FROM synonym_de WHERE LOWER(word) = LOWER(?)");
    $fetchStmt->bind_param("s", $word);
    $fetchStmt->execute();
    $fetchResult = $fetchStmt->get_result()->fetch_assoc();
    $fetchStmt->close();

    if (!$fetchResult) {
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

    // 🛠️ Decode the selected synonyms from JSON
    $selectedSynonyms = json_decode($_POST['synonyms'], true);

    // ✅ Duplication Fix: Only save selected synonyms (no merging with old ones)
    function removeDuplicates($synonyms) {
        return implode(", ", array_unique(array_map(function ($item) {
            return trim($item['word']);
        }, $synonyms ?? [])));
    }

    $strictSynonyms = removeDuplicates($selectedSynonyms['S'] ?? []);
    $crossReferences = removeDuplicates($selectedSynonyms['Q'] ?? []);
    $hypernyms = removeDuplicates($selectedSynonyms['O'] ?? []);
    $hyponyms = removeDuplicates($selectedSynonyms['U'] ?? []);
    $synonym_ns = !empty($comment) ? '1' : '0';

    // 📝 Update the database with duplicates removed
    $updateStmt = $db->prepare("UPDATE synonym_de SET root_word = ?, strict_synonym = ?, synonym_partial_1 = ?, synonym_general = ?, synonym_minor = ?, synonym_comment = ?, synonym_ns = ? WHERE LOWER(word) = LOWER(?)");
    $updateStmt->bind_param("ssssssss", $rootWord, $strictSynonyms, $crossReferences, $hypernyms, $hyponyms, $comment, $synonym_ns, $word);

    if ($updateStmt->execute()) {
        error_log("✅ Update Successful for: " . $word);
        echo json_encode(["success" => true, "message" => "Root word, synonyms, and comment updated successfully without duplicates."]);
    } else {
        error_log("❌ Update Failed for: " . $word);
        echo json_encode(["success" => false, "message" => "Database update failed."]);
    }

    $updateStmt->close();
}
?>