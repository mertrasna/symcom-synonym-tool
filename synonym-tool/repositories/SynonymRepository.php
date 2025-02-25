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

    public function updateWord(string $word, string $rootWord, string $strictSynonyms, string $crossReferences, string $hypernyms, string $hyponyms, string $comment, string $synonym_ns): bool {
        $stmt = $this->db->prepare("UPDATE synonym_de SET root_word = ?, strict_synonym = ?, synonym_partial_1 = ?, synonym_general = ?, synonym_minor = ?, synonym_comment = ?, synonym_ns = ? WHERE LOWER(word) = LOWER(?)");
        $stmt->bind_param("ssssssss", $rootWord, $strictSynonyms, $crossReferences, $hypernyms, $hyponyms, $comment, $synonym_ns, $word);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
?>
