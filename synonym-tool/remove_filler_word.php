<?php
include '../config/route.php';

if (isset($_POST['word'])) {
    $word = mysqli_real_escape_string($db, $_POST['word']);

    // Remove the word from the stop_words table
    $query = "DELETE FROM stop_words WHERE name = '$word' AND active = 1";

    if (mysqli_query($db, $query)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . mysqli_error($db)]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No word provided."]);
}
?>
