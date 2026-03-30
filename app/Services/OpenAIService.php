<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    public static function getResponse(string $question): string|array
    {
        try {
            $client = new Client([
                'base_uri' => 'https://api.openai.com/',
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . config('services.openai.api_key'),
                ],
            ]);

            $response = $client->post('v1/chat/completions', [
                'json' => [
                    'model' => config('services.openai.model'),
                    'messages' => [
                        ['role' => 'user', 'content' => $question],
                    ],
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            return $body['choices'][0]['message']['content'] ?? '';
        } catch (\Exception $e) {
            Log::error('Error en la resposta d\'OpenAI: ' . $e->getMessage());
            return ['error' => 'No s\'ha pogut obtenir una resposta.'];
        }
    }
}
