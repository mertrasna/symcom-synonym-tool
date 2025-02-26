<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

class SynonymSearchTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        // Ensure we include the configuration file correctly
        $configPath = dirname(__DIR__, 2) . "/config/route.php";
        if (!file_exists($configPath)) {
            die("Error: Config file not found at " . $configPath);
        }
        
        include $configPath;

        // Use the global `$db` from the config
        global $db;
        $this->db = $db;

        if (!$this->db) {
            die("Database connection failed: " . mysqli_connect_error());
        }
    }

    protected function tearDown(): void
    {
        // Close connection only if it was established
        if ($this->db instanceof \mysqli) {
            $this->db->close();
        }

        // Reset global variables
        $_POST = [];
    }

    public function testSearchSynonym()
    {
        $_POST['word'] = "anstrengen";
        ob_start();
        include dirname(__DIR__) . "/search_synonym.php";
        $output = ob_get_clean();
        $response = json_decode($output, true);

        $this->assertArrayHasKey('success', $response, "Missing 'success' key in response");
        $this->assertTrue($response['success'], "Expected 'success' to be true");
        $this->assertArrayHasKey('synonyms', $response, "Missing 'synonyms' key in response");
        $this->assertNotEmpty($response['synonyms'], "Synonyms list should not be empty");
    }

    public function testFetchRootWord()
    {
        $_POST['word'] = "laufen";
        ob_start();
        include dirname(__DIR__) . "/fetch_root_word.php";
        $output = ob_get_clean();
        $response = json_decode($output, true);

        $this->assertArrayHasKey('success', $response, "Missing 'success' key in response");
        $this->assertTrue($response['success'], "Expected 'success' to be true");
        $this->assertArrayHasKey('word', $response, "Missing 'word' key in response");
        $this->assertEquals("gehen", $response['word'], "Root word does not match expected value");
    }

    public function testUpdateSynonym()
    {
        $_POST = [
            'word' => "schnell",
            'root_word' => "rasch",
            'synonyms' => json_encode(['S' => ["fix"], 'Q' => ["prompt"]]),
            'comment' => "Added manually"
        ];
        ob_start();
        include dirname(__DIR__) . "/update_synonym.php";
        $output = ob_get_clean();
        $response = json_decode($output, true);

        $this->assertArrayHasKey('success', $response, "Missing 'success' key in response");
        $this->assertTrue($response['success'], "Expected 'success' to be true");
        $this->assertEquals("Synonyms updated successfully", $response['message'], "Unexpected response message");
    }
}
