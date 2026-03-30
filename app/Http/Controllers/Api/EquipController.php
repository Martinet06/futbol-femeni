<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipResource;
use App\Http\Resources\EquipCollection;
use App\Http\Requests\StoreEquipRequest;
use App\Http\Requests\UpdateEquipRequest;
use App\Models\Equip;

class EquipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new EquipCollection(Equip::with('estadi')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipRequest $request)
    {
        $data = $request->validated();
        
        // Handle escut upload if present
        if ($request->hasFile('escut')) {
            $data['escut'] = $request->file('escut')->store('escuts', 'public');
        }
        
        $equip = Equip::create($data);
        return response()->json($equip, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Equip $equip)
    {
        $equip->load('estadi');
        return new EquipResource($equip);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipRequest $request, Equip $equip)
    {
        $data = $request->validated();
        
        // Handle escut upload if present
        if ($request->hasFile('escut')) {
            $data['escut'] = $request->file('escut')->store('escuts', 'public');
        }
        
        $equip->update($data);
        return response()->json($equip, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equip $equip)
    {
        $equip->delete();
        return response()->noContent();
    }
}
