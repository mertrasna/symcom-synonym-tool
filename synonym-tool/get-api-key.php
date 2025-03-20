<?php
require_once '../config/route.php'; // Ensure this file retrieves the key from GitHub Secrets

header('Content-Type: application/json');

// Ensure API key exists
if (!defined("OPENAI_API_KEY") || empty(OPENAI_API_KEY)) {
    http_response_code(500);
    echo json_encode(["error" => "API key is missing"]);
    exit;
}

// Send the key securely to the frontend
echo json_encode(["key" => OPENAI_API_KEY]);
?>
