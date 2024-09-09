<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait GeminiTrait
{
    public function generateText($prompt)
    {
        $client = new Client();

        $response = $client->post('https://api.gemini.google.com/v1/generate_text', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('GEMINI_API_KEY'),
            ],
            'json' => [
                'prompt' => $prompt,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        return $data['text'];
    }
}
