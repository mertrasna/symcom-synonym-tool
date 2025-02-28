<?php
use PHPUnit\Framework\TestCase;

class FetchWordInfoTest extends TestCase
{
    protected $db;

    protected function setUp(): void
    {
        // DB connection 
        $this->db = new mysqli("127.0.0.1", "root", "root", "symcom_minified_db", 6000);

        // Check if the connection was successful
        if ($this->db->connect_error) {
            $this->fail('Connection failed: ' . $this->db->connect_error);
        } else {
            $this->assertTrue(true, 'Database connected successfully!');
        }
    }

    protected function tearDown(): void
    {
        // Close the DB connection after the test
        $this->db->close();
    }

    public function testFetchWordInfoAuswurf()
    {
        // Check if the word 'Auswurf' exists in the database before proceeding
        $word = 'Auswurf';
        $query = "SELECT COUNT(*) as count FROM synonym_de WHERE word = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $word);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            // Word exists, proceed with the test

            // Simulate the POST request data with the word 'Auswurf'
            $_POST['word'] = 'Auswurf';

            // Simulate the request method as POST
            $_SERVER['REQUEST_METHOD'] = 'POST';

            // Start output buffering to capture the script's output
            ob_start();

            // Include the PHP script 
            include __DIR__ . '/../fetch_word_info.php'; 

            // Get the output and clean the buffer
            $output = ob_get_clean();  

            // Decode the JSON response
            $response = json_decode($output, true);

            // Assert that the response is successful
            $this->assertTrue($response['success'], 'Response was not successful');

            // Assert that synonyms are found for the word 'Auswurf'
            $this->assertNotEmpty($response['synonyms'], 'No synonyms found for Auswurf');

            $foundAuswurf = false;
            foreach ($response['synonyms'] as $synonym) {
                if (strpos($synonym['word'], 'Auswurf') !== false) {
                    $foundAuswurf = true;
                    break;
                }
            }

            $this->assertTrue($foundAuswurf, 'Synonyms do not include "Auswurf"');
        } else {
            $this->markTestSkipped("The word 'Auswurf' does not exist in the database, skipping test.");
        }
    }

    public function testFetchWordInfoNonExistentWord()
    {
        // Simulate the POST request data with a non-existent word
        $word = 'nonexistentword';
        $_POST['word'] = $word;

        // Simulate the request method as POST
        $_SERVER['REQUEST_METHOD'] = 'POST';

        // Start output buffering to capture the script's output
        ob_start();

        // Include the PHP script 
        include __DIR__ . '/../fetch_word_info.php'; // Adjusted the path here

        // Get the output and clean the buffer
        $output = ob_get_clean();  

        // Decode the JSON response
        $response = json_decode($output, true);

        // Assert that the response is unsuccessful as the word does not exist in the database
        $this->assertFalse($response['success'], 'Response should be unsuccessful for non-existent word.');

        // Assert that the message indicates no synonym was found
        $this->assertEquals('No synonym found', $response['message']);
    }
}
