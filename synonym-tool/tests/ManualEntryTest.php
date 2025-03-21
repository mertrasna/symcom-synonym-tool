<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

class ManualEntryTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        // connect using the confirmed working settings from route.php
        $this->db = new \mysqli('mysql', 'root', 'root', 'symcom_minified_db', 3306);

        if ($this->db->connect_error) {
            $this->fail("database connection error: " . $this->db->connect_error);
        }

        // UTF-8 
        $this->db->set_charset("utf8mb4");
    }

    protected function tearDown(): void
    {
        if ($this->db instanceof \mysqli) {
            $this->db->close();
        }
    }

    // testing manual synonym entry 
    public function testManualSynonymEntry()
    {
        // unique test data 
        $testWord = "test_" . uniqid();
        $testRootWord = "root_" . uniqid();
        $testManualSynonym = "manual_" . uniqid();
        
        // insterting it in db
        $wordEscaped = $this->db->real_escape_string($testWord);
        $rootWordEscaped = $this->db->real_escape_string($testRootWord);
        
        // insterting word and root word
        $insertQuery = "INSERT INTO synonym_en (word, root_word) VALUES ('$wordEscaped', '$rootWordEscaped')";
        $insertResult = $this->db->query($insertQuery);
        $this->assertTrue($insertResult, "failed to insert test word: " . $this->db->error);
        
        // adding synonym to the word
        $synonymEscaped = $this->db->real_escape_string($testManualSynonym);
        $updateQuery = "UPDATE synonym_en SET synonym = '$synonymEscaped' WHERE word = '$wordEscaped'";
        $updateResult = $this->db->query($updateQuery);
        $this->assertTrue($updateResult, "failed to update synonym: " . $this->db->error);
        
        // checking the db entry
        $query = "SELECT synonym FROM synonym_en WHERE word = '$wordEscaped'";
        $result = $this->db->query($query);
        
        $this->assertNotFalse($result, "database query failed: " . $this->db->error);
        $this->assertGreaterThan(0, $result->num_rows, "No records found for the test word");
        
        $row = $result->fetch_assoc();
        $this->assertEquals($testManualSynonym, $row['synonym'], "manual synonym does not match expected value");
        
        // cleaning test data
        $this->db->query("DELETE FROM synonym_en WHERE word = '$wordEscaped'");
    }

    // manual synonym entry with a specific type (Q - Cross-reference)
    public function testManualSynonymWithSpecificType()
    {
        // test data
        $testWord = "test_" . uniqid();
        $testRootWord = "root_" . uniqid();
        $testManualSynonym = "manual_" . uniqid();
        
        // instering in db
        $wordEscaped = $this->db->real_escape_string($testWord);
        $rootWordEscaped = $this->db->real_escape_string($testRootWord);
        
        // instering root word and word
        $insertQuery = "INSERT INTO synonym_en (word, root_word) VALUES ('$wordEscaped', '$rootWordEscaped')";
        $insertResult = $this->db->query($insertQuery);
        $this->assertTrue($insertResult, "failed to insert test word: " . $this->db->error);
        
        // selecting Q - Cross-reference
        $synonymEscaped = $this->db->real_escape_string($testManualSynonym);
        $updateQuery = "UPDATE synonym_en SET cross_reference = '$synonymEscaped' WHERE word = '$wordEscaped'";
        $updateResult = $this->db->query($updateQuery);
        $this->assertTrue($updateResult, "failed to update cross-reference: " . $this->db->error);
        
        // checking db entry
        $query = "SELECT synonym, cross_reference, generic_term, sub_term FROM synonym_en WHERE word = '$wordEscaped'";
        $result = $this->db->query($query);
        
        $this->assertNotFalse($result, "database query failed: " . $this->db->error);
        $this->assertGreaterThan(0, $result->num_rows, "no records found for the test word");
        
        $row = $result->fetch_assoc();
        
        // checking the cross_reference column
        $this->assertEmpty($row['synonym'], "Synonym column should be empty");
        $this->assertEquals($testManualSynonym, $row['cross_reference'], "Cross-reference does not match expected value");
        $this->assertEmpty($row['generic_term'], "Generic term column should be empty");
        $this->assertEmpty($row['sub_term'], "Sub-term column should be empty");
        
        // ckleaning test data
        $this->db->query("DELETE FROM synonym_en WHERE word = '$wordEscaped'");
    }
}