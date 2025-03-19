<?php
require_once './repositories/SynonymRepositoryInterface.php';

class SynonymService {
    private $synonymRepository;
    private $scraperRepository;
    
    public function __construct(SynonymRepositoryInterface $synonymRepository) {
        $this->synonymRepository = $synonymRepository;
    }

    // Improved removeDuplicates function to handle both arrays and strings
    private function removeDuplicates($synonyms) {
        if (is_array($synonyms)) {
            // Convert array of objects to array of strings
            $wordArray = array_map(function($item) {
                return is_array($item) && isset($item['word']) ? trim($item['word']) : trim($item);
            }, $synonyms);
            
            // Filter out empty entries and get unique values
            $wordArray = array_filter(array_unique($wordArray), function($word) {
                return !empty($word);
            });
            
            return implode(", ", $wordArray);
        } else if (is_string($synonyms)) {
            // Handle if a string is passed
            $words = array_map('trim', explode(',', $synonyms));
            $words = array_filter(array_unique($words));
            return implode(", ", $words);
        }
        
        return ""; // Return empty string for invalid input
    }

    public function processSynonymUpdate($word, $rootWord, $comment, $selectedSynonyms) {
        // Trim any trailing commas from word and root_word
        $word = rtrim(trim(strtolower($word)), ',');
        $rootWord = rtrim(trim(strtolower($rootWord)), ',');
        
        if (empty($word) || empty($rootWord)) {
            return ["success" => false, "message" => "Error: Selected word and root word are required."];
        }

        $existingWord = $this->synonymRepository->findRootWord($word);

        if (!$existingWord) {
            if (!$this->synonymRepository->insertWord($word, $rootWord)) {
                return ["success" => false, "message" => "Error inserting root word."];
            }
        }

        // Process each category of synonyms
        $strictSynonyms = $this->removeDuplicates($selectedSynonyms['S'] ?? []);
        $crossReferences = $this->removeDuplicates($selectedSynonyms['Q'] ?? []);
        $hypernyms = $this->removeDuplicates($selectedSynonyms['O'] ?? []);
        $hyponyms = $this->removeDuplicates($selectedSynonyms['U'] ?? []);
        $non_secure_flag = !empty($comment) ? '1' : '0';

        // Debug output
        error_log("Updating synonyms for word: $word");
        error_log("S (synonyms): $strictSynonyms");
        error_log("Q (cross-references): $crossReferences");
        error_log("O (generic terms): $hypernyms");
        error_log("U (sub-terms): $hyponyms");

        if ($this->synonymRepository->updateWord($word, $rootWord, $strictSynonyms, $crossReferences, $hypernyms, $hyponyms, $comment, $non_secure_flag)) {
            return [
                "success" => true, 
                "message" => "Root word, synonyms, and comment updated successfully.",
                "word" => $word,
                "root_word" => $rootWord,
                "synonyms" => [
                    "S" => $strictSynonyms,
                    "Q" => $crossReferences,
                    "O" => $hypernyms,
                    "U" => $hyponyms
                ]
            ];
        } else {
            return ["success" => false, "message" => "Database update failed."];
        }
    }

    public function processSynonymSearchAndUpdate(string $word): array {
        error_log("🔍 Processing word: " . $word);
    
        // Check if the word is a phrase
        $isPhrase = $this->isPhrase($word);
    
        // Fetch synonyms explicitly checking for yellow words
        $synonyms = $this->synonymRepository->searchSynonym($word);
    
        if (!empty($synonyms)) {
            $non_secure_flag = isset($synonyms[0]['non_secure_flag']) ? intval($synonyms[0]['non_secure_flag']) : 0;
            $isYellowDB = isset($synonyms[0]['isyellow']) ? intval($synonyms[0]['isyellow']) : 0;
    
            error_log("🟡 Phrase Detected: " . ($isPhrase ? "Yes" : "No"));
            error_log("🟡 Database says isyellow = " . $isYellowDB);
    
            if ($isPhrase || $isYellowDB) {
                error_log("🟡 Updating isyellow for phrase...");
                $yellowUpdated = $this->synonymRepository->updateIsYellow($word);
                $greenUpdated = false; // Ensure it does not get marked as green
            } else {
                error_log("✅ Updating isgreen for single word...");
                $greenUpdated = $this->synonymRepository->updateIsGreen($word);
                $yellowUpdated = false; 
            }
    
            return [
                'success' => ($yellowUpdated || $greenUpdated),
                'synonyms' => $synonyms,
                'isYellow' => ($isPhrase || $isYellowDB),
                'non_secure_flag' => $non_secure_flag,
                'message' => ($yellowUpdated || $greenUpdated) ? 'Synonym updated successfully' : 'Failed to update synonym'
            ];
        }
    
        error_log("⚠️ No synonyms found for '$word'!");
    
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

        return str_word_count($trimmedWord) > 1;

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