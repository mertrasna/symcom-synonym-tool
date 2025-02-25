<?php
require_once 'SynonymRepositoryInterface.php';

class SynonymRepository implements SynonymRepositoryInterface {
    private $db;

    public function __construct(mysqli $db) {
        $this->db = $db;
    }

    public function findRootWord(string $word): ?array {
        $stmt = $this->db->prepare("SELECT root_word FROM synonym_de WHERE LOWER(word) = LOWER(?)");
        $stmt->bind_param("s", $word);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result ?: null;
    }

    public function insertWord(string $word, string $rootWord): bool {
        $stmt = $this->db->prepare("INSERT INTO synonym_de (root_word, word) VALUES (?, ?)");
        $stmt->bind_param("ss", $rootWord, $word);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function updateWord(string $word, string $rootWord, string $strictSynonyms, string $crossReferences, string $hypernyms, string $hyponyms, string $comment, string $non_secure_flag): bool {
        $stmt = $this->db->prepare("UPDATE synonym_de SET root_word = ?, synonym = ?, cross_reference = ?, generic_term = ?, sub_term = ?, comment = ?, non_secure_flag = ? WHERE LOWER(word) = LOWER(?)");
        $stmt->bind_param("ssssssss", $rootWord, $strictSynonyms, $crossReferences, $hypernyms, $hyponyms, $comment, $non_secure_flag, $word);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function searchSynonym(string $word): array {
        $word = mysqli_real_escape_string($this->db, $word);
        $query = "
            SELECT * FROM synonym_de 
            WHERE 
                word LIKE '%$word%' OR
                synonym LIKE '%$word%' OR
                cross_reference LIKE '%$word%' OR 
                synonym_partial_2 LIKE '%$word%' OR
                generic_term LIKE '%$word%' OR
                sub_term LIKE '%$word%' OR
                synonym_nn LIKE '%$word%' OR
                comment LIKE '%$word%'
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
        $word = mysqli_real_escape_string($this->db, $word);
        $update_query = "
            UPDATE synonym_de 
            SET isgreen = 1
            WHERE 
                word LIKE '%$word%' OR
                synonym LIKE '%$word%' OR
                cross_reference LIKE '%$word%' OR
                synonym_partial_2 LIKE '%$word%' OR
                generic_term LIKE '%$word%' OR
                sub_term LIKE '%$word%' OR
                synonym_nn LIKE '%$word%' OR
                comment LIKE '%$word%'
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

        // If all good, return the HTML inside a response array
        return [
            "success" => true,
            "html" => $response
        ];
    }

    public function deleteStopWord(string $word): array {
        global $db; // Ensure that the database connection is available

        // Sanitize and escape the word for SQL
        $word = mysqli_real_escape_string($db, $word);

        // Prepare and execute the delete query
        $query = "DELETE FROM stop_words WHERE name = '$word' AND active = 1";

        if (mysqli_query($db, $query)) {
            return [
                "success" => true
            ];
        } else {
            return [
                "success" => false,
                "message" => "Error: " . mysqli_error($db)
            ];
        }
    }
    // Check if the word exists in the stop_words table
    public function checkIfWordExistsInStopWords(string $word): bool {
        global $db;
        $query = "SELECT * FROM stop_words WHERE name = '$word'";
        $result = mysqli_query($db, $query);
        return mysqli_num_rows($result) > 0;
    }

    // Check if the word exists in the synonym_de table
    public function checkIfWordExistsInSynonymTable(string $word): bool {
        global $db;
        $query = "SELECT * FROM synonym_de WHERE word = '$word'";
        $result = mysqli_query($db, $query);
        return mysqli_num_rows($result) > 0;
    }

    // Update the synonym list for an existing word
    public function updateSynonym(string $word, string $updatedSynonym): bool {
        global $db;
        $query = "UPDATE synonym_de SET synonym = '$updatedSynonym' WHERE word = '$word'";
        return mysqli_query($db, $query);
    }

    // Insert new synonym data into the synonym_de table
    public function insertSynonymData(array $data): bool {
        global $db;
        $query = "INSERT INTO synonym_de (word, synonym, cross_reference, synonym_partial_2, generic_term, sub_term, synonym_nn, comment, non_secure_flag, source_reference_ns, active)
                  VALUES ('{$data['word']}', '{$data['synonym']}', '{$data['cross_reference']}', '{$data['synonym_partial_2']}', '{$data['generic_term']}', '{$data['sub_term']}', '{$data['synonym_nn']}', '{$data['comment']}', '{$data['non_secure_flag']}', '{$data['source_reference_ns']}', '{$data['active']}')";
        return mysqli_query($db, $query);
    }

    
}
?>
