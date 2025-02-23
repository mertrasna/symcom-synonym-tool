<?php
// scrape_korrekturen.php

if (!isset($_GET['word'])) {
    echo json_encode(["success" => false, "message" => "No word provided."]);
    exit;
}

$word = $_GET['word'];
$url = 'https://www.korrekturen.de/synonyme/' . urlencode($word) . '/';

// Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); // Mimic a real browser

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    // If cURL had an error, return a JSON object with success=false
    echo json_encode([
        "success" => false,
        "message" => "cURL Error: " . $error
    ]);
    exit;
}

// If all good, return the HTML inside a JSON response
echo json_encode([
    "success" => true,
    "html" => $response
]);
