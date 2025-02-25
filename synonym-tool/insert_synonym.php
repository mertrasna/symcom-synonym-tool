<?php
include '../config/route.php';

if (isset($_POST['word'])) {
    // Get the word and sanitize it to avoid SQL injection
    $word = mysqli_real_escape_string($db, $_POST['word']);
    $synonym = mysqli_real_escape_string($db, $_POST['synonym']);
    $cross_reference = mysqli_real_escape_string($db, $_POST['cross_reference']);
    $synonym_partial_2 = mysqli_real_escape_string($db, $_POST['synonym_partial_2']);
    $generic_term = mysqli_real_escape_string($db, $_POST['generic_term']);
    $sub_term = mysqli_real_escape_string($db, $_POST['sub_term']);
    $synonym_nn = mysqli_real_escape_string($db, $_POST['synonym_nn']);
    $comment = mysqli_real_escape_string($db, $_POST['comment']);
    $non_secure_flag = mysqli_real_escape_string($db, $_POST['non_secure_flag']);
    $source_reference_ns = mysqli_real_escape_string($db, $_POST['source_reference_ns']);
    $active = mysqli_real_escape_string($db, $_POST['active']);

    // Clean up and separate synonym by commas, remove newlines, numbers, and full stops
    $synonym = preg_replace('/\d+/', '', $_POST['synonym']); // Remove numbers
    $synonym = preg_replace('/[\r\n]+/', ', ', $synonym); // Replace newlines with commas
    $synonym = preg_replace('/\./', '', $synonym); // Remove periods
    $synonym = implode(',', array_map('trim', explode(',', $synonym))); // Trim extra spaces and join by commas
    
    // Check if the word is already in stop_words to avoid duplicates (optional)
    $checkQuery = "SELECT * FROM stop_words WHERE name = '$word'";
    $checkResult = mysqli_query($db, $checkQuery);
    
    if (mysqli_num_rows($checkResult) == 0) {
        // Check if the word exists in synonym_de table
        $synonymCheckQuery = "SELECT * FROM synonym_de WHERE word = '$word'";
        $synonymCheckResult = mysqli_query($db, $synonymCheckQuery);
        
        if (mysqli_num_rows($synonymCheckResult) > 0) {
            // Get the current synonym list
            $row = mysqli_fetch_assoc($synonymCheckResult);
            $existing_synonym = $row['synonym'];

            // Merge the existing and new synonyms while removing duplicates
            $updated_synonym = array_unique(array_merge(
                explode(',', $existing_synonym),
                explode(',', $synonym)
            ));

            // Concatenate the unique synonyms with commas
            $updated_synonym = implode(',', $updated_synonym);

            // Update the synonym column with the new concatenated value
            $updateQuery = "UPDATE synonym_de SET synonym = '$updated_synonym' WHERE word = '$word'";
            
            if (mysqli_query($db, $updateQuery)) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "Error: " . mysqli_error($db)]);
            }
        } else {
            // Insert the word and its synonyms into the synonym_de table
            $query = "INSERT INTO synonym_de (word, synonym, cross_reference, synonym_partial_2, generic_term, sub_term, synonym_nn, comment, non_secure_flag, source_reference_ns, active)
                      VALUES ('$word', '$synonym', '$cross_reference', '$synonym_partial_2', '$generic_term', '$sub_term', '$synonym_nn', '$comment', '$non_secure_flag', '$source_reference_ns', '$active')";

            if (mysqli_query($db, $query)) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "Error: " . mysqli_error($db)]);
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "Word already exists in stop words."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No word provided."]);
}
?>
