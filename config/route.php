<?php
session_start();
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 0);
ini_set('memory_limit', -1);
ini_set('max_input_vars', 10000);
// Central European timezone
date_default_timezone_set('Europe/Vienna');

//session controls starts
// Setting the session timeout to 2 hours
$sessionTimeout = 7200;

// Check if the session is set
if (isset($_SESSION['last_activity'])) {
    // Check if the session has expired
    $elapsedTime = time() - $_SESSION['last_activity'];
    if ($elapsedTime > $sessionTimeout) {
        // Session has expired, destroy it
        session_unset();
        session_destroy();
        session_start(); // Optionally start a new session
    }
}

// Update the last activity timestamp
$_SESSION['last_activity'] = time();
//session controls ends

// Check if the script is run from a web server or CLI
if (php_sapi_name() == "cli") {
    // Default values or alternative handling when running from CLI
    $_SERVER['HTTP_HOST'] = 'localhost';
    $_SERVER['REQUEST_URI'] = '/';
}
// Full URL of a page
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://"
    . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost')
    . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/');

// Site domain
$absoluteUrl = "http://localhost/symcom-synonym-tool/";

// api base url
$baseApiURL = $absoluteUrl.'symcom/api/public/v1/';
// $baseApiURL = 'http://dev.reference-repertory.com/symcom/api/public/v1/';

// DB Config details
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'new_database_synonym_test';

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}

// Change character set to utf8
mysqli_set_charset($db,"utf8");
mb_internal_encoding("UTF-8");

$date = date("Y-m-d H:i:s"); 
?>