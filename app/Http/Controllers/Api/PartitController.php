<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartitResource;
use App\Http\Resources\PartitCollection;
use App\Http\Requests\PartitRequest;
use App\Models\Partit;

class PartitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PartitCollection(Partit::with(['equipLocal', 'equipVisitant', 'arbitre'])->paginate(10));
    }

    /**
     * Display the specified resource.
     */
    public function show(Partit $partit)
    {
        $partit->load(['equipLocal', 'equipVisitant', 'arbitre']);
        return new PartitResource($partit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PartitRequest $request, Partit $partit)
    {
        $partit->update($request->validated());
        return response()->json($partit, 200);
    }

    /**
     * Store a newly created resource in storage.
     * Not allowed for matches - they are generated automatically.
     */
    public function store()
    {
        return response()->json(['message' => 'No es permet crear partits manualment. Es generen automàticament.'], 403);
    }

    /**
     * Remove the specified resource from storage.
     * Not allowed for matches.
     */
    public function destroy(Partit $partit)
    {
        return response()->json(['message' => 'No es permet eliminar partits.'], 403);
    }
}
