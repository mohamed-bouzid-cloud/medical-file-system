<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;

class GeminiTest extends Component
{
    use WithFileUploads;

    public $testFile;
    public $result;
    public $processing = false;

    public function submit()
    {
        $this->validate([
            'testFile' => 'required|file|mimes:txt|max:10240',
        ]);
    
        $content = file_get_contents($this->testFile->getRealPath());
        $apiKey = config('services.gemini.key');
        $model = 'gemini-1.5-flash-latest';
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
    
        $this->processing = true;
    
        try {
            $prompt = "Extract conditions, allergies, and medications from this text and return as JSON with keys: 'conditions'[], 'allergies'[], 'medications'[]. Do not include any other text. Text: " . $content;
    
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->post($endpoint, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);
    
            if (!$response->successful()) {
                $this->result = 'API Error: ' . $response->body();
                $this->processing = false;
                return;
            }
    
            $responseBody = $response->json();
    
            $textOutput = $responseBody['candidates'][0]['content']['parts'][0]['text'] ?? null;
    
            if ($textOutput) {
                $structuredData = json_decode($textOutput, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->result = "JSON Decode Error: " . json_last_error_msg() . "\nResponse: " . $textOutput;
                } else {
                    $this->result = $structuredData;
                }
            } else {
                $this->result = 'No output received from Gemini.';
            }
    
        } catch (\Exception $e) {
            $this->result = 'Exception: ' . $e->getMessage();
        }
    
        $this->processing = false;
    }
}    