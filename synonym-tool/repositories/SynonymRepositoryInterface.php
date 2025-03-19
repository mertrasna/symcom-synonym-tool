<?php
interface SynonymRepositoryInterface {
    public function findRootWord(string $word): ?array;
    public function insertWord(string $word, string $rootWord): bool;
    public function updateWord(string $word, string $rootWord, string $strictSynonyms, string $crossReferences, string $hypernyms, string $hyponyms, string $comment, string $non_secure_flag): bool;

    public function searchSynonym(string $word): array;

    public function updateIsGreen(string $word): bool;

    public function updateIsYellow(string $word): bool;

    public function scrapeSynonym(string $word): array;

    public function deleteStopWord(string $word): array;

    public function checkIfWordExistsInStopWords(string $word): bool;
    public function checkIfWordExistsInSynonymTable(string $word): bool;
    public function updateSynonym(string $word, string $updatedSynonym): bool;
    public function insertSynonymData(array $data): bool;
    
    public function getSynonym($word); 

    
}
?>
