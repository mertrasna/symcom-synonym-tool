<?php
require_once 'SynonymRepositoryInterface.php';


class SynonymRepository implements SynonymRepositoryInterface {
    private $db;
    private $tableName;
    

    // Constructor now accepts a masterId to determine the table
    public function __construct(mysqli $db, int $masterId = 5075) {
        $this->db = $db;
        if ($masterId === 5072) {
            $this->tableName = 'synonym_de';
        } elseif ($masterId === 5075) {
            $this->tableName = 'synonym_en';
        } else {
            $this->tableName = 'synonym_en'; // Default to English
        }
    }

    public function findRootWord(string $word): ?array {
        $stmt = $this->db->prepare("SELECT root_word FROM {$this->tableName} WHERE LOWER(word) = LOWER(?)");
        $stmt->bind_param("s", $word);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result ?: null;
    }

    public function insertWord(string $word, string $rootWord): bool {
        $stmt = $this->db->prepare("INSERT INTO {$this->tableName} (root_word, word) VALUES (?, ?)");
        $stmt->bind_param("ss", $rootWord, $word);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function insertPhrase(string $word): bool {
        $wordEscaped = mysqli_real_escape_string($this->db, trim($word));
    
        $insert_query = "
            INSERT INTO {$this->tableName} (word, isyellow) 
            VALUES ('$wordEscaped', 1) 
            ON DUPLICATE KEY UPDATE isyellow = 1
        ";
    
        error_log("🔹 Insert Phrase Query: " . $insert_query);
    
        if (!mysqli_query($this->db, $insert_query)) {
            error_log("❌ Insert Error: " . mysqli_error($this->db));
            return false;
        }
    
        return true;
    }
    
    

    public function updateWord(
        string $word,
        string $rootWord,
        string $strictSynonyms,
        string $crossReferences,
        string $hypernyms,
        string $hyponyms,
        string $comment,
        string $non_secure_flag
    ): bool {
        // Log the actual values being sent to the database
        error_log("Updating word in database: " . $word);
        error_log("Root word: " . $rootWord);
        error_log("Synonyms: " . $strictSynonyms);
        error_log("Cross-references: " . $crossReferences);
        error_log("Generic terms: " . $hypernyms);
        error_log("Sub-terms: " . $hyponyms);
        
        // Remove trailing commas from the word to be updated
        $word = rtrim(trim($word), ',');
        
        // Prepare the update query
        $query = "UPDATE {$this->tableName} SET 
                  root_word = ?, 
                  synonym = ?, 
                  cross_reference = ?, 
                  generic_term = ?, 
                  sub_term = ?, 
                  comment = ?, 
                  non_secure_flag = ?,
                  isgreen = ?
                  WHERE LOWER(word) = LOWER(?)";
                  
        // Set isgreen to 1 for single words
        $isGreen = (strpos($word, ' ') === false) ? 1 : 0;
        
        // Prepare and execute the statement
        $stmt = $this->db->prepare($query);
        
        if (!$stmt) {
            error_log("Prepare failed: " . $this->db->error);
            return false;
        }
        
        $stmt->bind_param("sssssssis", 
                         $rootWord, 
                         $strictSynonyms, 
                         $crossReferences, 
                         $hypernyms, 
                         $hyponyms, 
                         $comment, 
                         $non_secure_flag,
                         $isGreen,
                         $word);
                         
        $success = $stmt->execute();
        
        if (!$success) {
            error_log("Execute failed: " . $stmt->error);
        } else {
            error_log("Update successful. Affected rows: " . $stmt->affected_rows);
        }
        
        $stmt->close();
        return $success;
    }

    public function searchSynonym(string $word): array {
        $wordEscaped = trim(mysqli_real_escape_string($this->db, $word));
    
        $query = "SELECT * FROM {$this->tableName} 
                  WHERE LOWER(TRIM(word)) = LOWER(TRIM('$wordEscaped'))
                  OR LOWER(TRIM(word)) LIKE LOWER('%$wordEscaped%')
                  AND isyellow = 1";
    
        error_log("Executing Query: " . $query); // ✅ Log query
    
        $result = mysqli_query($this->db, $query);
        
        if (!$result) {
            error_log("MySQL Error: " . mysqli_error($this->db));
            return [];
        }
    
        $synonyms = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $synonyms[] = $row;
        }
    
        return $synonyms;
    }
    
    
    
    public function updateIsGreen(string $word): bool {
        $wordEscaped = mysqli_real_escape_string($this->db, $word);
        $update_query = "
            UPDATE {$this->tableName} 
            SET isgreen = 1
            WHERE 
                word LIKE '%$wordEscaped%' OR
                synonym LIKE '%$wordEscaped%' OR
                cross_reference LIKE '%$wordEscaped%' OR
                synonym_partial_2 LIKE '%$wordEscaped%' OR
                generic_term LIKE '%$wordEscaped%' OR
                sub_term LIKE '%$wordEscaped%' OR
                synonym_nn LIKE '%$wordEscaped%' OR
                comment LIKE '%$wordEscaped%'
        ";
        return mysqli_query($this->db, $update_query);
    }

    public function updateIsYellow(string $word): bool {
        // Normalize and trim the word
        $wordEscaped = trim(mysqli_real_escape_string($this->db, $word));
        
        // Force update only if the word is a phrase (more than one word)
        if (str_word_count($wordEscaped) > 1) {
            // We'll use an exact match (ignoring case) to force the update
            $updateQuery = "
                UPDATE {$this->tableName} 
                SET isyellow = 1, isgreen = 0 
                WHERE LOWER(word) = LOWER(?)
            ";
            
            $stmt = $this->db->prepare($updateQuery);
            if ($stmt === false) {
                error_log("Prepare failed: " . $this->db->error);
                return false;
            }
            
            $stmt->bind_param("s", $wordEscaped);
            $success = $stmt->execute();
            $affectedRows = $stmt->affected_rows;
            
            if (!$success) {
                error_log("Update IsYellow Error: " . $stmt->error);
                $stmt->close();
                return false;
            }
            
            error_log("Force updated isyellow for '$wordEscaped' - Rows Affected: $affectedRows");
            $stmt->close();
            return true;
        } else {
            error_log("Word '$wordEscaped' is not a phrase, skipping isyellow update.");
            return false;
        }
    }
    
    
    
    // Method to scrape synonym data from the website
    public function scrapeSynonym(string $word): array {
        $url = 'https://www.korrekturen.de/synonyme/' . urlencode($word) . '/';

        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); // Mimic a real browser

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return [
                "success" => false,
                "message" => "cURL Error: " . $error
            ];
        }

        return [
            "success" => true,
            "html" => $response
        ];
    }

    // Stop word methods remain language agnostic if your stop_words table is shared
    public function deleteStopWord(string $word): array {
        $wordEscaped = mysqli_real_escape_string($this->db, $word);
        $query = "UPDATE stop_words SET active = 0 WHERE name = '$wordEscaped'";
    
        if (mysqli_query($this->db, $query)) {
            return ["success" => true, "message" => "Stop word deactivated."];
        } else {
            return ["success" => false, "message" => "Error: " . mysqli_error($this->db)];
        }
    }

    public function checkIfWordExistsInStopWords(string $word): bool {
        $wordEscaped = mysqli_real_escape_string($this->db, $word);
       $query = "SELECT * FROM stop_words WHERE name = '$wordEscaped' AND active = 1";
        $result = mysqli_query($this->db, $query);
        return mysqli_num_rows($result) > 0;
    }

    public function checkIfWordExistsInSynonymTable(string $word): bool {
        $wordEscaped = mysqli_real_escape_string($this->db, $word);
        $query = "SELECT * FROM {$this->tableName} WHERE word = '$wordEscaped'";
        $result = mysqli_query($this->db, $query);
        return mysqli_num_rows($result) > 0;
    }

    public function updateSynonym(string $word, string $updatedSynonym): bool {
        $wordEscaped = mysqli_real_escape_string($this->db, $word);
        $updatedSynonymEscaped = mysqli_real_escape_string($this->db, $updatedSynonym);
        $query = "UPDATE {$this->tableName} SET synonym = '$updatedSynonymEscaped' WHERE word = '$wordEscaped'";
        return mysqli_query($this->db, $query);
    }

    public function insertSynonymData(array $data): bool {
        $query = "INSERT INTO {$this->tableName} (word, synonym, cross_reference, synonym_partial_2, generic_term, sub_term, synonym_nn, comment, non_secure_flag, source_reference_ns, active)
                  VALUES ('{$data['word']}', '{$data['synonym']}', '{$data['cross_reference']}', '{$data['synonym_partial_2']}', '{$data['generic_term']}', '{$data['sub_term']}', '{$data['synonym_nn']}', '{$data['comment']}', '{$data['non_secure_flag']}', '{$data['source_reference_ns']}', '{$data['active']}')";
        return mysqli_query($this->db, $query);
    }

    public function getSynonym($word) {
        $wordEscaped = mysqli_real_escape_string($this->db, $word);
        $query = "SELECT synonym FROM {$this->tableName} WHERE word = '$wordEscaped'";
        $result = mysqli_query($this->db, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row ? $row['synonym'] : '';
        }
        return '';
    }
    
}
?>
