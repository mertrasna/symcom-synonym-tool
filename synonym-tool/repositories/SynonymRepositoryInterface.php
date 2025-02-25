<?php
interface SynonymRepositoryInterface {
    public function findRootWord(string $word): ?array;
    public function insertWord(string $word, string $rootWord): bool;
    public function updateWord(string $word, string $rootWord, string $strictSynonyms, string $crossReferences, string $hypernyms, string $hyponyms, string $comment, string $non_secure_flag): bool;
}
?>
