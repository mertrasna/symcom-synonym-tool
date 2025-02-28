<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../ChatGPTSynonymFetcher.php';

class ChatGPT2 extends TestCase
{
    private $db;
    private $fetcher;

    protected function setUp(): void
    {
        $this->fetcher = new ChatGPTSynonymFetcher("sk-proj-mADIN..."); //Use key
        
        // Database Connection
        $this->db = new mysqli("127.0.0.1", "root", "root", "symcom_minified_db", 6000);
        if ($this->db->connect_error) {
            die("Database connection failed: " . $this->db->connect_error);
        }
    }

    protected function tearDown(): void
    {
        $this->db->close();
    }

    public function testFetchSynonymsAndCheckDatabase()
    {
        $word = "laufen";
        $response = $this->fetcher->fetchSynonyms($word);

        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('synonyms', $response);
        $this->assertIsArray($response['synonyms']);
        $this->assertNotEmpty($response['synonyms']);

        // Insert into database
        $synonym = implode(", ", $response['synonyms']);
        $stmt = $this->db->prepare("INSERT INTO synonyms (root_word, word, synonym, active) VALUES (?, ?, ?, 1)");
        $stmt->bind_param("sss", $word, $word, $synonym);
        $stmt->execute();
        $stmt->close();

        // Verify in database
        $query = $this->db->prepare("SELECT synonym FROM synonyms WHERE word = ?");
        $query->bind_param("s", $word);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        $query->close();

        $this->assertNotEmpty($row);
        $this->assertEquals($synonym, $row['synonym']);
    }

    public function testFetchSynonymsSuccess()
    {
        $word = "laufen"; // Example German word
        $response = $this->fetcher->fetchSynonyms($word);

        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('synonyms', $response);
        $this->assertIsArray($response['synonyms']);
        $this->assertNotEmpty($response['synonyms']);
    }


    
}
