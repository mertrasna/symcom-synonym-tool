<?php
include '../config/route.php';

if (isset($_POST['word'])) {
    // Get the word and sanitize it to avoid SQL injection
    $word = mysqli_real_escape_string($db, $_POST['word']);
    $strict_synonym = mysqli_real_escape_string($db, $_POST['strict_synonym']);
    $synonym_partial_1 = mysqli_real_escape_string($db, $_POST['synonym_partial_1']);
    $synonym_partial_2 = mysqli_real_escape_string($db, $_POST['synonym_partial_2']);
    $synonym_general = mysqli_real_escape_string($db, $_POST['synonym_general']);
    $synonym_minor = mysqli_real_escape_string($db, $_POST['synonym_minor']);
    $synonym_nn = mysqli_real_escape_string($db, $_POST['synonym_nn']);
    $synonym_comment = mysqli_real_escape_string($db, $_POST['synonym_comment']);
    $synonym_ns = mysqli_real_escape_string($db, $_POST['synonym_ns']);
    $source_reference_ns = mysqli_real_escape_string($db, $_POST['source_reference_ns']);
    $active = mysqli_real_escape_string($db, $_POST['active']);

    // Clean up and separate strict_synonym by commas, remove newlines, numbers, and full stops
    $strict_synonym = preg_replace('/\d+/', '', $_POST['strict_synonym']); // Remove numbers
    $strict_synonym = preg_replace('/[\r\n]+/', ', ', $strict_synonym); // Replace newlines with commas
    $strict_synonym = preg_replace('/\./', '', $strict_synonym); // Remove periods
    $strict_synonym = implode(',', array_map('trim', explode(',', $strict_synonym))); // Trim extra spaces and join by commas
    
    // Check if the word is already in stop_words to avoid duplicates (optional)
    $checkQuery = "SELECT * FROM stop_words WHERE name = '$word'";
    $checkResult = mysqli_query($db, $checkQuery);
    
    if (mysqli_num_rows($checkResult) == 0) {
        // Check if the word exists in synonym_de table
        $synonymCheckQuery = "SELECT * FROM synonym_de WHERE word = '$word'";
        $synonymCheckResult = mysqli_query($db, $synonymCheckQuery);
        
        if (mysqli_num_rows($synonymCheckResult) > 0) {
            // Get the current strict_synonym list
            $row = mysqli_fetch_assoc($synonymCheckResult);
            $existing_strict_synonym = $row['strict_synonym'];

            // Merge the existing and new synonyms while removing duplicates
            $updated_synonym = array_unique(array_merge(
                explode(',', $existing_strict_synonym),
                explode(',', $strict_synonym)
            ));

            // Concatenate the unique synonyms with commas
            $updated_strict_synonym = implode(',', $updated_synonym);

            // Update the strict_synonym column with the new concatenated value
            $updateQuery = "UPDATE synonym_de SET strict_synonym = '$updated_strict_synonym' WHERE word = '$word'";
            
            if (mysqli_query($db, $updateQuery)) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "Error: " . mysqli_error($db)]);
            }
        } else {
            // Insert the word and its synonyms into the synonym_de table
            $query = "INSERT INTO synonym_de (word, strict_synonym, synonym_partial_1, synonym_partial_2, synonym_general, synonym_minor, synonym_nn, synonym_comment, synonym_ns, source_reference_ns, active)
                      VALUES ('$word', '$strict_synonym', '$synonym_partial_1', '$synonym_partial_2', '$synonym_general', '$synonym_minor', '$synonym_nn', '$synonym_comment', '$synonym_ns', '$source_reference_ns', '$active')";

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
