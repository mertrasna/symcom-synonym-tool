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
        $stmt = $this->db->prepare("UPDATE {$this->tableName} SET root_word = ?, synonym = ?, cross_reference = ?, generic_term = ?, sub_term = ?, comment = ?, non_secure_flag = ? WHERE LOWER(word) = LOWER(?)");
        $stmt->bind_param("ssssssss", $rootWord, $strictSynonyms, $crossReferences, $hypernyms, $hyponyms, $comment, $non_secure_flag, $word);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function searchSynonym(string $word): array {
        $wordEscaped = mysqli_real_escape_string($this->db, $word);
        $query = "
            SELECT * FROM {$this->tableName} 
            WHERE 
                word LIKE '$wordEscaped'         
        ";

        $result = mysqli_query($this->db, $query);
        $synonyms = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $synonyms[] = $row;
            }
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
        // Use $this->db instead of global $db
        $wordEscaped = mysqli_real_escape_string($this->db, $word);
        $query = "DELETE FROM stop_words WHERE name = '$wordEscaped' AND active = 1";

        if (mysqli_query($this->db, $query)) {
            return ["success" => true];
        } else {
            return ["success" => false, "message" => "Error: " . mysqli_error($this->db)];
        }
    }

    public function checkIfWordExistsInStopWords(string $word): bool {
        $wordEscaped = mysqli_real_escape_string($this->db, $word);
        $query = "SELECT * FROM stop_words WHERE name = '$wordEscaped'";
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
