<?php
include '../config/route.php'; // Ensure this initializes $db

header('Content-Type: application/json'); // Force JSON response
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if $db is initialized, and initialize it if not
if (!isset($db)) {
    $db = new mysqli("127.0.0.1", "root", "root", "symcom_minified_db", 6000);
    if ($db->connect_error) {
        die(json_encode(["success" => false, "message" => "DB Connection Failed: " . $db->connect_error]));
    }
}

// Validate POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['word']) || empty($_POST['word'])) {
        echo json_encode(["success" => false, "message" => "No word provided"]);
        exit;
    }

    // ✅ Ensure master_id is retrieved correctly
    $word = trim(mysqli_real_escape_string($db, $_POST['word']));
    $masterId = isset($_POST['master_id']) ? intval($_POST['master_id']) : 5075;

    // ✅ Allow only predefined master IDs
    $validMasterIds = [5072, 5075];
    if (!in_array($masterId, $validMasterIds)) {
        echo json_encode(["success" => false, "message" => "Invalid master_id"]);
        exit;
    }

    // ✅ Choose the correct table based on master_id
    $table = ($masterId === 5072) ? 'synonym_de' : 'synonym_en';

    // ✅ Debugging logs (Optional: check server logs for debugging)
    error_log("🔍 Searching for exact word: $word in table: $table");

    // Query for exact match with isyellow = 1
    $queryYellow = "
        SELECT * FROM $table 
        WHERE isyellow = 1 
          AND word = '$word'
        LIMIT 1
    ";
    $resultYellow = mysqli_query($db, $queryYellow);
    $synonyms = [];

    if ($resultYellow && mysqli_num_rows($resultYellow) > 0) {
        while ($row = mysqli_fetch_assoc($resultYellow)) {
            $synonyms[] = $row;
        }
        echo json_encode([
            "success" => true,
            "synonyms" => $synonyms,
            "message" => "Yellow synonym(s) found"
        ]);
        exit; // Stop execution since yellow takes priority
    }

    // Query for exact match with isgreen = 1
    $queryGreen = "
        SELECT * FROM $table 
        WHERE isgreen = 1 
          AND word = '$word'
        LIMIT 1
    ";
    $resultGreen = mysqli_query($db, $queryGreen);
    if ($resultGreen && mysqli_num_rows($resultGreen) > 0) {
        while ($row = mysqli_fetch_assoc($resultGreen)) {
            $synonyms[] = $row;
        }
    }

    // Return synonyms if found
    if (!empty($synonyms)) {
        echo json_encode([
            "success" => true,
            "synonyms" => $synonyms,
            "message" => "Green synonym(s) found"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "No exact match found"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
}
?>
