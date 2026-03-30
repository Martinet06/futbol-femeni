<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EstadiResource;
use App\Http\Resources\EstadiCollection;
use App\Http\Requests\StoreEstadiRequest;
use App\Http\Requests\UpdateEstadiRequest;
use App\Models\Estadi;

class EstadiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new EstadiCollection(Estadi::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstadiRequest $request)
    {
        $estadi = Estadi::create($request->validated());
        return response()->json($estadi, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Estadi $estadi)
    {
        return new EstadiResource($estadi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstadiRequest $request, Estadi $estadi)
    {
        $estadi->update($request->validated());
        return response()->json($estadi, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estadi $estadi)
    {
        $estadi->delete();
        return response()->noContent();
    }
}
