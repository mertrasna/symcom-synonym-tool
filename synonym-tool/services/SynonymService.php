<?php
require_once './repositories/SynonymRepositoryInterface.php';

class SynonymService {
    private $synonymRepository;

    public function __construct(SynonymRepositoryInterface $synonymRepository) {
        $this->synonymRepository = $synonymRepository;
    }

    // Move removeDuplicates out of the method
    private function removeDuplicates($synonyms) {
        return implode(", ", array_unique(array_map(function($item) { return trim($item['word']); }, $synonyms ?? [])));

    }

    public function processSynonymUpdate($word, $rootWord, $comment, $selectedSynonyms) {
        if (empty($word) || empty($rootWord)) {
            return ["success" => false, "message" => "Error: Selected word and root word are required."];
        }

        $word = strtolower($word);
        $rootWord = strtolower($rootWord);

        $existingWord = $this->synonymRepository->findRootWord($word);

        if (!$existingWord) {
            if (!$this->synonymRepository->insertWord($word, $rootWord)) {
                return ["success" => false, "message" => "Error inserting root word."];
            }
        }

        $strictSynonyms = $this->removeDuplicates($selectedSynonyms['S'] ?? []);
        $crossReferences = $this->removeDuplicates($selectedSynonyms['Q'] ?? []);
        $hypernyms = $this->removeDuplicates($selectedSynonyms['O'] ?? []);
        $hyponyms = $this->removeDuplicates($selectedSynonyms['U'] ?? []);
        $synonym_ns = !empty($comment) ? '1' : '0';

        if ($this->synonymRepository->updateWord($word, $rootWord, $strictSynonyms, $crossReferences, $hypernyms, $hyponyms, $comment, $synonym_ns)) {
            return ["success" => true, "message" => "Root word, synonyms, and comment updated successfully without duplicates."];
        } else {
            return ["success" => false, "message" => "Database update failed."];
        }
    }
}

?>
