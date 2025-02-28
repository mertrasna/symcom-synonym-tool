<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../ChatGPTSynonymFetcher.php';

class Chatgpt1 extends TestCase
{
    public function testFetchSynonymsSuccess()
    {
        $fetcher = new ChatGPTSynonymFetcher("sk-proj-mADIN..."); //Put a key
        $word = "laufen"; // Example German word
        $response = $fetcher->fetchSynonyms($word);

        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('synonyms', $response);
        $this->assertIsArray($response['synonyms']);
        $this->assertNotEmpty($response['synonyms']);
    }

    public function testFetchSynonymsFailure_EmptyWord()
    {
        $fetcher = new ChatGPTSynonymFetcher("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"); 
        $word = ""; // Empty word should trigger failure
        $response = $fetcher->fetchSynonyms($word);

        $this->assertArrayHasKey('success', $response);
        $this->assertFalse($response['success']);
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals("Word cannot be empty.", $response['message']);
    }

    public function testFetchSynonymsFailure_MissingApiKey()
    {
        $fetcher = new ChatGPTSynonymFetcher(""); // No API key
        $word = "rennen";
        $response = $fetcher->fetchSynonyms($word);

        $this->assertArrayHasKey('success', $response);
        $this->assertFalse($response['success']);
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals("API key is missing.", $response['message']);
    }
}
