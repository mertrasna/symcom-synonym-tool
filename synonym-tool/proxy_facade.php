<?php
class ProxyFacade {
    public static function handleRequest() {
        // Enable error reporting for debugging
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Check for required parameters
        if (!isset($_GET['type']) || !isset($_GET['targetUrl'])) {
            http_response_code(400);
            echo "Missing required parameters: type and targetUrl.";
            exit;
        }

        $type = $_GET['type'];
        $targetUrl = $_GET['targetUrl'];

        // Validate the target URL
        if (!filter_var($targetUrl, FILTER_VALIDATE_URL)) {
            http_response_code(400);
            echo "Invalid targetUrl.";
            exit;
        }

        // Delegate to the appropriate proxy script
        switch ($type) {
            case 'thesaurus':
                $_GET['url'] = $targetUrl;
                require 'proxy_thesaurus.php';
                break;
            case 'dictionary':
                $_GET['url'] = $targetUrl;
                require 'proxy_dictionary.php';
                break;
            default:
                http_response_code(400);
                echo "Invalid type parameter. Use 'thesaurus' or 'dictionary'.";
                exit;
        }
    }
}

// Execute the facade to handle the incoming request
ProxyFacade::handleRequest();
?>
