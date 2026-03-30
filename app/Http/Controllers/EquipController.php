<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipRequest;
use App\Http\Requests\UpdateEquipRequest;
use App\Models\Equip;
use App\Models\Estadi;
use App\Services\EquipService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Resources\EquipResource;

class EquipController extends Controller
{

    use AuthorizesRequests;
    public function __construct(private EquipService $servei) {}

    // GET /equips
    public function index()
    {
        return view('equips.index', ['equips' => $this->servei->llistar()]);
    }

    // GET /equips/create
    public function create()
    {
        $this->authorize('create', Equip::class);
        $estadis = Estadi::all();
        return view('equips.create', compact('estadis'));
    }
    // POST /equips
    public function store(StoreEquipRequest $request)
    {
        $validated = $request->validated();

        // Handle file upload
        if ($request->hasFile('escut')) {
            $validated['escut'] = $request->file('escut')->store('escuts', 'public');
        }

        $equip = Equip::create($validated);
        return redirect()->route('equips.index')->with('success', __('Equip creat correctament!'));
    }

    // GET /equips/{id}
    public function show(Equip $equip)
    {
        return view('equips.show', compact('equip'));
    }

    // GET /equips/{id}/edit
    public function edit(Equip $equip)
    {
        //$this->authorize('update', $equip);
        $estadis = Estadi::all();
        return view('equips.edit', compact('equip', 'estadis'));
    }

    // PUT /equips/{id}/edit
    public function update(UpdateEquipRequest $request, Equip $equip)
    {
        $this->servei->actualitzar($equip->id, $request->validated(), $request->file('escut'));
        return redirect()->route('equips.index')->with('ok', 'Equip actualitzat');
    }

    // DELETE /equips/{id}
    public function destroy(Equip $equip)
    {
        $this->authorize('delete', $equip);
        $this->servei->eliminar($equip->id);
        return redirect()->route('equips.index')->with('ok', 'Equip esborrat');
    }
}
