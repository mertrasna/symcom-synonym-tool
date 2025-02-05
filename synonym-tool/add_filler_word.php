<?php
include '../config/route.php';

if (isset($_POST['word'])) {
    $word = mysqli_real_escape_string($db, $_POST['word']);

    // Check if the word is already in stop_words to avoid duplicates
    $checkQuery = "SELECT * FROM stop_words WHERE name = '$word'";
    $checkResult = mysqli_query($db, $checkQuery);
    
    if (mysqli_num_rows($checkResult) == 0) {
        // Insert the word into the stop_words table
        $query = "INSERT INTO stop_words (name, active) VALUES ('$word', 1)";
        if (mysqli_query($db, $query)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Error: " . mysqli_error($db)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Word already exists in stop words."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No word provided."]);
}
?>
