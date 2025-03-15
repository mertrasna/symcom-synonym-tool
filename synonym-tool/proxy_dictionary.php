<?php
// proxy_dictionary.php
if (!isset($_GET['url'])) {
    http_response_code(400);
    echo "No URL provided.";
    exit;
}

$url = $_GET['url'];

// Basic validation (you may want to add further checks)
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo "Invalid URL.";
    exit;
}

// Fetch the remote content
$response = file_get_contents($url);
if ($response === FALSE) {
    http_response_code(500);
    echo "Error fetching URL.";
    exit;
}

// Add header so browser accepts this response
header("Content-Type: text/html");
header("Access-Control-Allow-Origin: *");
echo $response;
?>
