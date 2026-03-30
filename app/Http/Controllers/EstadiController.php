<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstadiRequest;
use App\Http\Requests\UpdateEstadiRequest;
use App\Models\Estadi;
use Illuminate\Http\Request;
use App\Http\Resources\EstadiResource;
use App\Services\EstadiService;

class EstadiController extends Controller
{
    public function __construct(private EstadiService $servei) {}

    public function index()
    {
        $estadis = Estadi::all();
        return view('estadis.index', compact('estadis'));
    }
    public function show(Estadi $estadi)
    {
        return view('estadis.show', compact('estadi'));
    }

    public function create()
    {
        return view('estadis.create');
    }

    public function store(StoreEstadiRequest $request)
    {
        $data = $request->validated();

        $this->servei->guardar($data);

        return redirect()->route('estadis.index')->with('success', 'Estadi afegit correctament');
    }

    public function edit(Estadi $estadi)
    {
        return view('estadis.edit', compact('estadi'));
    }

    public function update(UpdateEstadiRequest $request, $estadiId)
    {
        $estadi = $this->servei->trobar($estadiId);
        $data = $request->validated();

        $this->servei->actualitzar($estadi, $data);
        return redirect()->route('estadis.show', $estadiId)->with('success', 'Estadi Atualitzat correctament!');
    }

    public function destroy(Estadi $estadi)
    {
        $estadi->delete();
        return redirect()->route('estadis.index')->with('success', 'Estadi Eliminat correctament!');
    }
}
