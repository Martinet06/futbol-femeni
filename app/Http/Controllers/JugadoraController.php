<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJugadoraRequest;
use App\Http\Requests\UpdateJugadoraRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Jugadora;
use App\Models\Equip;
use App\Services\JugadoraService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JugadoraController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private JugadoraService $servei)
    {
        $this->authorizeResource(Jugadora::class, 'jugadora');
    }


    // GET /jugadores
    public function index()
    {
        $jugadores = $this->servei->llistar()->load('equip');
        return view('jugadores.index', compact('jugadores'));
    }


    // GET /jugadores/create
    public function create()
    {
        $equips = Equip::all();
        return view('jugadores.create', compact('equips'));
    }


    // POST /jugadores
    public function store(StoreJugadoraRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('jugadores', 'public');
        }

        $this->servei->guardar($data);

        return redirect()->route('jugadores.index')->with('success', 'Jugadora afegida correctament!');
    }

    public function llistar()
    {
        return Jugadora::with('equip')->get();
    }

    // GET /jugadores/{id}
    public function show(Jugadora $jugadora)
    {
        $jugadora->load('equip');
        return view('jugadores.show', compact('jugadora'));
    }

    // GET  /jugadores/{id}/edit
    public function edit(Jugadora $jugadora)
    {
        $equips = Equip::all();
        return view('jugadores.edit', compact('jugadores', 'equips'));
    }

    // PUT /jugadores/{id}
    public function update(UpdateJugadoraRequest $request, Jugadora $jugadora)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('jugadores', 'public');
        }

        $this->servei->actualitzar($jugadora->id, $data);

        return redirect()->route('jugadores.index')->with('success', 'Jugadora actualitzada correctament!');
    }

    // DELETE /jugadores/{id}
    public function destroy($id)
    {
        $this->servei->eliminar($id);
        return redirect()->route('jugadores.index')->with('succes', 'Jugadora eliminada amb èxit');
    }
}
