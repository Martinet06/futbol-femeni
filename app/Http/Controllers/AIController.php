<?php

namespace App\Http\Controllers;

use App\Models\Equip;
use App\Models\Estadi;
use App\Services\GeminiService;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AIController extends Controller
{
    /**
     * Generate description for a team using AI
     */
    public function generateEquipDescription(Equip $equip, Request $request)
    {
        $provider = $request->input('provider', 'gemini'); // gemini or openai
        
        // Check cache first (24 hours)
        $cacheKey = "ai_description_equip_{$equip->id}";
        $cached = Cache::get($cacheKey);
        
        if ($cached) {
            return back()->with('info', 'Descripció generada prèviament (cache).');
        }

        $prompt = "Dona una descripció breu i informativa (màxim 150 paraules) del equip de futbol femení '{$equip->nom}'. Inclou informació sobre la seua història, èxits i importància en el futbol femení. Respon en valencià.";
        
        if ($equip->estadi) {
            $prompt .= " Juga els seus partits a l'estadi '{$equip->estadi->nom}'.";
        }

        if ($equip->titols > 0) {
            $prompt .= " Ha guanyat {$equip->titols} títols.";
        }

        $description = '';
        
        if ($provider === 'openai') {
            $result = OpenAIService::getResponse($prompt);
        } else {
            $result = GeminiService::getResponse($prompt);
        }

        if (is_array($result) && isset($result['error'])) {
            return back()->with('error', $result['error']);
        }

        $description = $result;

        // Save to database
        $equip->update(['description' => $description]);
        
        // Cache for 24 hours
        Cache::put($cacheKey, $description, 3600 * 24);

        return back()->with('success', 'Descripció generada correctament amb IA.');
    }

    /**
     * Generate description for a stadium using AI
     */
    public function generateEstadiDescription(Estadi $estadi, Request $request)
    {
        $provider = $request->input('provider', 'gemini');
        
        // Check cache first
        $cacheKey = "ai_description_estadi_{$estadi->id}";
        $cached = Cache::get($cacheKey);
        
        if ($cached) {
            return back()->with('info', 'Descripció generada prèviament (cache).');
        }

        $prompt = "Dona una descripció breu i informativa (màxim 150 paraules) de l'estadi '{$estadi->nom}'. Inclou informació sobre la seua capacitat, ubicació, història i importància en el futbol femení. Respon en valencià.";

        if ($estadi->capacitat) {
            $prompt .= " Té una capacitat de {$estadi->capacitat} espectadors.";
        }

        $description = '';
        
        if ($provider === 'openai') {
            $result = OpenAIService::getResponse($prompt);
        } else {
            $result = GeminiService::getResponse($prompt);
        }

        if (is_array($result) && isset($result['error'])) {
            return back()->with('error', $result['error']);
        }

        $description = $result;

        // Save to database
        $estadi->update(['description' => $description]);
        
        // Cache for 24 hours
        Cache::put($cacheKey, $description, 3600 * 24);

        return back()->with('success', 'Descripció generada correctament amb IA.');
    }
}
