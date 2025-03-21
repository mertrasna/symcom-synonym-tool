<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

class ManualEntryTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        // database connection
        $configPath = dirname(__DIR__, 2) . "/config/route.php";
        if (!file_exists($configPath)) {
            die("Error: Config file not found at " . $configPath);
        }
        
        include $configPath;

        
        global $db;
        $this->db = $db;

        if (!$this->db) {
            die("Database connection failed: " . mysqli_connect_error());
        }
    }

    protected function tearDown(): void
    {
        if ($this->db instanceof \mysqli) {
            $this->db->close();
        }
        $_POST = [];
    }

    // testing if the manual entry correctly passed
    public function testManualSynonymEntry()
    {
        $testWord = "test_" . uniqid();
        $testRootWord = "root_" . uniqid();
        $testManualSynonym = "manual_" . uniqid();
        
        // Set up POST data simulating a form submission with manual entry
        $_POST = [
            'word' => $testWord,
            'root_word' => $testRootWord,
            'synonyms' => json_encode([
                'S' => [], 'Q' => [], 'O' => [], 'U' => []
            ]),
            'manual_synonym' => $testManualSynonym,
            'manual_synonym_types' => json_encode(['S']),
            'master_id' => 5075 // Use English table
        ];

        // capturing output of update_synonym.php
        ob_start();
        include dirname(__DIR__) . "/update_synonym.php";
        $output = ob_get_clean();
        
        $response = json_decode($output, true);
        $this->assertArrayHasKey('success', $response, "Missing 'success' key in response");
        $this->assertTrue($response['success'], "Expected 'success' to be true");
        
        // verifying the synonym was stored in the database
        $wordEscaped = mysqli_real_escape_string($this->db, $testWord);
        $query = "SELECT synonym FROM synonym_en WHERE word = '$wordEscaped'";
        $result = mysqli_query($this->db, $query);
        
        $this->assertNotFalse($result, "Database query failed: " . mysqli_error($this->db));
        $this->assertGreaterThan(0, mysqli_num_rows($result), "No records found for the test word");
        
        $row = mysqli_fetch_assoc($result);
        $this->assertStringContainsString($testManualSynonym, $row['synonym'], "Manual synonym was not found in the database");
        
        // removing test data 
        mysqli_query($this->db, "DELETE FROM synonym_en WHERE word = '$wordEscaped'");
    }

}