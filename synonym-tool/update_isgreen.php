<?php
include '../config/route.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $word = $_POST['word'] ?? '';
    $isgreen = $_POST['isgreen'] ?? 0;

    if (!empty($word)) {
        $stmt = $conn->prepare("UPDATE synonym_de SET isgreen = ? WHERE word = ?");
        $stmt->bind_param("is", $isgreen, $word);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Update failed"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid input"]);
    }
}

$conn->close();
?>
