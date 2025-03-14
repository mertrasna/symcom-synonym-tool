<?php
require_once './repositories/SynonymRepositoryInterface.php';

class SynonymService {
    private $synonymRepository;
    private $scraperRepository;
    

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
        $non_secure_flag = !empty($comment) ? '1' : '0';

        if ($this->synonymRepository->updateWord($word, $rootWord, $strictSynonyms, $crossReferences, $hypernyms, $hyponyms, $comment, $non_secure_flag)) {
            return ["success" => true, "message" => "Root word, synonyms, and comment updated successfully without duplicates."];
        } else {
            return ["success" => false, "message" => "Database update failed."];
        }
    }

    public function processSynonymSearchAndUpdate(string $word): array {
        $synonyms = $this->synonymRepository->searchSynonym($word);

        if (!empty($synonyms)) {
            if ($this->synonymRepository->updateIsGreen($word)) {
                return [
                    'success' => true,
                    'synonyms' => $synonyms,
                    'message' => 'Synonym updated successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to update synonym'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'No synonym found'
            ];
        }
    }

    public function processScrapeSynonym(string $word): array {
        
        return $this->synonymRepository->scrapeSynonym($word);
    }

    public function processDeleteStopWord(string $word): array {
        // Call the repository method to delete the word
        return $this->synonymRepository->deleteStopWord($word);
    }

    public function processAddOrUpdateSynonym(array $data): array {
        // Check if the word exists in stop_words table
        if ($this->synonymRepository->checkIfWordExistsInStopWords($data['word'])) {
            return ["success" => false, "message" => "Word already exists in stop words."];
        }

        // Check if the word exists in synonym_de table
        if ($this->synonymRepository->checkIfWordExistsInSynonymTable($data['word'])) {
            // Get the existing synonym list, merge with the new ones, and update
            $existing_synonym = $data['existing_synonym'];
            $updated_synonym = array_unique(array_merge(
                explode(',', $existing_synonym),
                explode(',', $data['synonym'])
            ));
            $updated_synonym = implode(',', $updated_synonym);

            // Update the synonym list
            if ($this->synonymRepository->updateSynonym($data['word'], $updated_synonym)) {
                return ["success" => true];
            } else {
                return ["success" => false, "message" => "Error updating synonym."];
            }
        } else {
            // Insert new synonym data
            if ($this->synonymRepository->insertSynonymData($data)) {
                return ["success" => true];
            } else {
                return ["success" => false, "message" => "Error inserting synonym."];
            }
        }
    }

    
}

?>
