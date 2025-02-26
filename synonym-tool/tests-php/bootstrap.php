<?php
// Load the project’s autoload and configuration files
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/route.php'; // Adjust if needed

// Set up test database connection
$db = new mysqli("localhost", "test_user", "test_password", "test_db");

if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}
?>
