<?php
class SynonymRepository {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function fetchByWord($word) {
        $stmt = $this->db->prepare("SELECT root_word, strict_synonym, synonym_partial_1, synonym_general, synonym_minor FROM synonym_de WHERE LOWER(word) = LOWER(?)");
        $stmt->bind_param("s", $word);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    public function insertNewWord($rootWord, $word) {
        $stmt = $this->db->prepare("INSERT INTO synonym_de (root_word, word) VALUES (?, ?)");
        $stmt->bind_param("ss", $rootWord, $word);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function updateSynonym($word, $rootWord, $strictSynonyms, $crossReferences, $hypernyms, $hyponyms, $comment, $synonym_ns) {
        $stmt = $this->db->prepare("UPDATE synonym_de SET root_word = ?, strict_synonym = ?, synonym_partial_1 = ?, synonym_general = ?, synonym_minor = ?, synonym_comment = ?, synonym_ns = ? WHERE LOWER(word) = LOWER(?)");
        $stmt->bind_param("ssssssss", $rootWord, $strictSynonyms, $crossReferences, $hypernyms, $hyponyms, $comment, $synonym_ns, $word);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
?>
