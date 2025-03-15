<?php
// proxy_thesaurus.php
if (!isset($_GET['url'])) {
    http_response_code(400);
    echo "No URL provided.";
    exit;
}

$url = $_GET['url'];

// Basic URL validation
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

// Set headers to allow cross-origin access from your client
header("Content-Type: text/html");
header("Access-Control-Allow-Origin: *");
echo $response;
?>
