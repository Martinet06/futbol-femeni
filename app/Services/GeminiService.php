<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    public static function getResponse(string $question): string|array
    {
        try {
            $client = new Client([
                'base_uri' => 'https://generativelanguage.googleapis.com/',
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $model = config('services.gemini.model');
            $response = $client->post("v1beta/models/{$model}:generateContent", [
                'headers' => [
                    'x-goog-api-key' => config('services.gemini.api_key'),
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $question],
                            ],
                        ],
                    ],
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            return $body['candidates'][0]['content']['parts'][0]['text'] ?? '';
        } catch (\Exception $e) {
            Log::error('Error en la resposta de Gemini: ' . $e->getMessage());
            return ['error' => 'No s\'ha pogut obtenir una resposta.'];
        }
    }
}
