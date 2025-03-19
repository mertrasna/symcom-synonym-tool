<?php

class ChatGPTSynonymFetcher
{
    private $apiKey;

    public function fetchSynonyms($word)
{
    if (empty(trim($word))) {
        return ["success" => false, "message" => "Word cannot be empty."];
    }

    if (empty($this->apiKey)) {
        return ["success" => false, "message" => "API key is missing."];
    }

    $requestBody = [
        "model" => "gpt-4",
        "messages" => [
            ["role" => "system", "content" => "You are a helpful assistant."],
            ["role" => "user", "content" => "Give me a list of 5 English synonyms for the word \"$word\""]
        ],
        "max_tokens" => 50,
        "temperature" => 0.7,
    ];

    $ch = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $this->apiKey
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        return ["success" => false, "message" => "API request failed with HTTP code $httpCode."];
    }

    $data = json_decode($response, true);
    
    // Debugging: Log full API response
    error_log("OpenAI Response: " . print_r($data, true));

    if (isset($data['choices'][0]['message']['content'])) {
        $synonyms = explode(",", $data['choices'][0]['message']['content']);
        return [
            "success" => true,
            "synonyms" => array_map('trim', $synonyms)
        ];
    }

    return ["success" => false, "message" => "Invalid response from API."];
}

}
