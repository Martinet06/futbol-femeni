<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartitRequest;
use App\Models\Partit;
use App\Models\Equip;
use Illuminate\Http\Request;
use App\Services\PartitService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
        return view('partits.show', compact('partit'));
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
        $partit->update($request->validated());
        return redirect()->route('partits.index')->with('success', 'Resultat actualitzat!');
    }
}
