<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

class NoteFunctionalityTest extends TestCase
{
    private $db;
    private $testWord;
    private $testNote;
    private $notesTableEn;
    private $notesTableDe;
    private $synonymTableEn;
    private $synonymTableDe;

    protected function setUp(): void
    {
        // connect using the confirmed working settings from route.php
        $this->db = new \mysqli('mysql', 'root', 'root', 'symcom_minified_db', 3306);

        if ($this->db->connect_error) {
            $this->fail("Database connection failed: " . $this->db->connect_error);
        }

        // UTF-8
        $this->db->set_charset("utf8mb4");
        
        // Set up test data with unique identifiers
        $this->testWord = "test_note_" . uniqid();
        $this->testNote = "This is a test note created by PHPUnit at " . date('Y-m-d H:i:s');
        
        // table names
        $this->notesTableEn = "synonym_en_notes";
        $this->notesTableDe = "synonym_de_notes";
        $this->synonymTableEn = "synonym_en";
        $this->synonymTableDe = "synonym_de";
    }

    protected function tearDown(): void
    {
        $escapedWord = $this->db->real_escape_string($this->testWord);
        
        // getting the Id 
        $result = $this->db->query("SELECT id FROM {$this->synonymTableEn} WHERE word = '$escapedWord'");
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $synonymId = $row['id'];
            
            // deleting the note  
            $this->db->query("DELETE FROM {$this->notesTableEn} WHERE synonym_id = $synonymId");
            
            // deleting the synonym
            $this->db->query("DELETE FROM {$this->synonymTableEn} WHERE id = $synonymId");
        }
        
        // same for German
        $result = $this->db->query("SELECT id FROM {$this->synonymTableDe} WHERE word = '$escapedWord'");
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $synonymId = $row['id'];
            
            // delete the note
            $this->db->query("DELETE FROM {$this->notesTableDe} WHERE synonym_id = $synonymId");
            
            // delete the synonym
            $this->db->query("DELETE FROM {$this->synonymTableDe} WHERE id = $synonymId");
        }
        
        // close the database connection
        if ($this->db instanceof \mysqli) {
            $this->db->close();
        }
    }

    // test saving a note for a word
    public function testSaveNote()
    {
        // inserting a word into the synonym table
        $wordEscaped = $this->db->real_escape_string($this->testWord);
        $insertSynonymQuery = "INSERT INTO {$this->synonymTableEn} (word, root_word) VALUES ('$wordEscaped', '$wordEscaped')";
        $insertResult = $this->db->query($insertSynonymQuery);
        
        $this->assertTrue($insertResult, "failed to insert test synonym: " . $this->db->error);
        
        // get the synonym ID
        $synonymId = $this->db->insert_id;
        $this->assertGreaterThan(0, $synonymId, "failed to get synonym ID");
        
        // instering the note
        $noteEscaped = $this->db->real_escape_string($this->testNote);
        $insertNoteQuery = "INSERT INTO {$this->notesTableEn} (synonym_id, note, created_at) VALUES ($synonymId, '$noteEscaped', NOW())";
        $noteResult = $this->db->query($insertNoteQuery);
        
        // check if the note was saved
        $this->assertTrue($noteResult, "failed to insert test note in db: " . $this->db->error);
        
        // check the note was saved in the database
        $query = "SELECT note FROM {$this->notesTableEn} WHERE synonym_id = $synonymId";
        $result = $this->db->query($query);
        
        // check if the note was saved
        $this->assertNotFalse($result, "database query failed: " . $this->db->error);
        $this->assertGreaterThan(0, $result->num_rows, "no note found for the created test word");
        
        $row = $result->fetch_assoc();
        // check if the note is the same
        $this->assertEquals($this->testNote, $row['note'], "saved note does not match expected value");
    }
    
    // Test updating an existing note
    public function testUpdateNote()
    {
        // insterting test word into the synonym table
        $wordEscaped = $this->db->real_escape_string($this->testWord);
        $insertSynonymQuery = "INSERT INTO {$this->synonymTableEn} (word, root_word) VALUES ('$wordEscaped', '$wordEscaped')";
        $this->db->query($insertSynonymQuery);
        
        $synonymId = $this->db->insert_id;
        
        // insterting previous note
        $noteEscaped = $this->db->real_escape_string($this->testNote);
        $insertNoteQuery = "INSERT INTO {$this->notesTableEn} (synonym_id, note, created_at) VALUES ($synonymId, '$noteEscaped', NOW())";
        $this->db->query($insertNoteQuery);
        
        // updating the note
        $updatedNote = $this->testNote . " [UPDATED]";
        
        $updatedNoteEscaped = $this->db->real_escape_string($updatedNote);
        $updateQuery = "UPDATE {$this->notesTableEn} SET note = '$updatedNoteEscaped', updated_at = NOW() WHERE synonym_id = $synonymId";
        $updateResult = $this->db->query($updateQuery);
        
        // check if the note was updated
        $this->assertTrue($updateResult, "failed to update note: " . $this->db->error);
        
        // check if the note was updated in the database
        $query = "SELECT note FROM {$this->notesTableEn} WHERE synonym_id = $synonymId";
        $result = $this->db->query($query);
        
        $row = $result->fetch_assoc();
        // check if the note was updated
        $this->assertEquals($updatedNote, $row['note'], "updated note does not  match expected value");
    }
    
    // Test note functionality with German language selection - synonym_de_notes table
    public function testGermanNoteSystem()
    {
        // instert a word into the synonym_de table
        $wordEscaped = $this->db->real_escape_string($this->testWord);
        $insertSynonymQuery = "INSERT INTO {$this->synonymTableDe} (word, root_word) VALUES ('$wordEscaped', '$wordEscaped')";
        $this->db->query($insertSynonymQuery);
        
        $synonymId = $this->db->insert_id;
        
        // insterting in synonym_de_notes table
        $noteEscaped = $this->db->real_escape_string($this->testNote);
        $insertNoteQuery = "INSERT INTO {$this->notesTableDe} (synonym_id, note, created_at) VALUES ($synonymId, '$noteEscaped', NOW())";
        $insertResult = $this->db->query($insertNoteQuery);
        
        // check if the note was saved
        $this->assertTrue($insertResult, "failed to insert German note: " . $this->db->error);
        
        // checking if the note was saved in the database
        $query = "SELECT note FROM {$this->notesTableDe} WHERE synonym_id = $synonymId";
        $result = $this->db->query($query);
        
        // checking if the note was saved
        $this->assertNotFalse($result, "database query failed: " . $this->db->error);
        $this->assertGreaterThan(0, $result->num_rows, "No note found in german table");
        
        $row = $result->fetch_assoc();
        $this->assertEquals($this->testNote, $row['note'], "saved note in german table does not match expected value");
    }
}