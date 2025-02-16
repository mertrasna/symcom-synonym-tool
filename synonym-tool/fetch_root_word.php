<?php
include '../config/route.php'; // Ensure this initializes $db

header('Content-Type: application/json'); // Force JSON response
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['word']) && !empty($_POST['word'])) {
        $word = mysqli_real_escape_string($db, $_POST['word']);
        
        // Search for root word in synonym_de table
        $query = "SELECT root_word FROM synonym_de WHERE word = '$word' LIMIT 1";
        $result = mysqli_query($db, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode(['success' => true, 'word' => $row['root_word']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No root word found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No word provided']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
