<?php
include_once '../config/route.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["word"]) && isset($_POST["synonyms"])) {
    global $db; // Use existing database connection

    $word = trim($_POST["word"]);
    $synonyms = json_decode($_POST["synonyms"], true); // Expecting JSON array

    if (!empty($word) && is_array($synonyms)) {
        foreach ($synonyms as $synonym) {
            $stmt = $db->prepare("INSERT INTO synonym_de (word, synonym) VALUES (?, ?)");
            $stmt->bind_param("ss", $word, $synonym);
            $stmt->execute();
        }
        echo json_encode(["success" => true, "message" => "Synonyms saved!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid input"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
