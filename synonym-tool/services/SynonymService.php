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

    public function processSynonymSearchAndUpdate(string $word): array
{
    error_log("Processing word: " . $word);

    // Check if the word is a phrase
    $isPhrase = $this->isPhrase($word);

    // Fetch synonyms before updating
    $synonyms = $this->synonymRepository->searchSynonym($word);

    if (!empty($synonyms)) {
        $non_secure_flag = isset($synonyms[0]['non_secure_flag']) ? intval($synonyms[0]['non_secure_flag']) : 0;


        if ($isPhrase) {
            error_log("Detected phrase, updating isyellow...");
            $yellowUpdated = $this->synonymRepository->updateIsYellow($word);
            $greenUpdated = false; // Make sure green is set to false in the database
        } else {
            error_log("Detected single word, updating isgreen...");
            $greenUpdated = $this->synonymRepository->updateIsGreen($word);
            $yellowUpdated = false; // Make sure yellow is set to false in the database
        }

        return [
            'success' => ($yellowUpdated || $greenUpdated),
            'synonyms' => $synonyms,
            'non_secure_flag' => $non_secure_flag,
            'message' => ($yellowUpdated || $greenUpdated) ? 'Synonym updated successfully' : 'Failed to update synonym'
        ];
    }

    return [
        'success' => false,
        'message' => 'No synonym found'
    ];
}

/**
 * Determines if a given word is a phrase (multiple words).
 *
 * @param string $word The input word or phrase.
 * @return bool Returns true if it is a phrase, false otherwise.
 */
private function isPhrase(string $word): bool {
    // Normalize spaces and trim input
    $trimmedWord = trim(preg_replace('/\s+/', ' ', $word));

    // Count words using regex (to handle spaces properly)
    $wordCount = preg_match_all('/\b\w+\b/u', $trimmedWord);

    // Debugging log
    error_log("Checking phrase detection: '$trimmedWord' - Word count: " . $wordCount);

    return $wordCount > 1;
}



    

    public function processScrapeSynonym(string $word): array {
        
        return $this->synonymRepository->scrapeSynonym($word);
    }

    public function processDeleteStopWord(string $word): array {
        // Call the repository method to delete the word
        return $this->synonymRepository->deleteStopWord($word);
    }

    public function processAddOrUpdateSynonym(array $data): array {
        // Check if the word exists in the stop_words table
        if ($this->synonymRepository->checkIfWordExistsInStopWords($data['word'])) {
            return ["success" => false, "message" => "Word already exists in stop words."];
        }
    
        // Flag to track if the operation (update/insert) succeeded
        $operationSucceeded = false;
    
        // Check if the word exists in the synonym table (English or German)
        if ($this->synonymRepository->checkIfWordExistsInSynonymTable($data['word'])) {
            // Get the existing synonym list, merge with the new ones, and update
            $existingSynonymFromDb = $this->synonymRepository->getSynonym($data['word']);
            $updated_synonym = array_unique(array_merge(
                explode(',', $existingSynonymFromDb),
                explode(',', $data['synonym'])
            ));
            $updated_synonym = implode(',', $updated_synonym);
    
            // Update the synonym list
            $operationSucceeded = $this->synonymRepository->updateSynonym($data['word'], $updated_synonym);
        } else {
            // Insert new synonym data
            $operationSucceeded = $this->synonymRepository->insertSynonymData($data);
        }
    
        // After updating/inserting, if the operation succeeded and the word is a phrase, force isyellow update
        if ($operationSucceeded) {
            if (str_word_count($data['word']) > 1) {
                $this->synonymRepository->updateIsYellow($data['word']);
            }
            return ["success" => true, "message" => "Synonym updated successfully"];
        } else {
            return ["success" => false, "message" => "Error updating/inserting synonym."];
        }
    }
}    

?>
