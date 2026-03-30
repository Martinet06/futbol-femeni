<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartitRequest;
use App\Models\Partit;
use App\Models\Equip;
use Illuminate\Http\Request;
use App\Services\PartitService;
use App\Services\WeatherService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Resources\PartitResource;

class PartitController extends Controller
{
    use AuthorizesRequests;
    public function __construct(private PartitService $servei) {}

    public function index()
    {
        $partits = $this->servei->llistar()->load(['equipLocal', 'equipVisitant']);
        return view('partits.index', compact('partits'));
    }

    public function show(Partit $partit)
    {
        $partit->load(['equipLocal', 'equipVisitant']);

        // Get weather forecast for match day
        $weather = null;
        if ($partit->equipLocal && $partit->equipLocal->estadi) {
            $weather = WeatherService::getStadiumWeather(
                $partit->equipLocal->estadi,
                $partit->data_partit
            );
        }

        return view('partits.show', compact('partit', 'weather'));
    }

    public function historic()
    {
        return view('partits.historic');
    }

    public function edit(Partit $partit)
    {
        $this->authorize('update', $partit);
        return view('partits.edit-resultat', compact('partit'));
    }

    public function update(PartitRequest $request, Partit $partit)
    {
        $this->authorize('update', $partit);
        $validated = $request->validated();
        $partit->update($validated);

        // If it's an API request (expects JSON), return JSON response
        if ($request->expectsJson()) {
            return new PartitResource($partit->load(['equipLocal', 'equipVisitant']));
        }

        // Otherwise redirect back with success message
        return redirect()->route('partits.index')->with('success', __('Resultat actualitzat correctament!'));
    }
}
