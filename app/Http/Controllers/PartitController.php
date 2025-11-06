<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PartitController extends Controller
{

    public $partits = [
        [
            'local' => 'Barça Femení',
            'visitant' => 'Atlètic de Madrid',
            'data' => '2024-11-30',
            'resultat' => null,
        ],
        [
            'local' => 'Real Madrid Femení',
            'visitant' => 'Barça Femení',
            'data' => '2024-12-15',
            'resultat' => '0-3'
        ],
    ];

    public function index()
    {
        $partits = Session::get('partits', $this->partits);
        return view('partits.index', compact('partits'));
    }

    public function show(int $id)
    {
        $partits = Session::get('partits', $this->partits);
        abort_if(!isset($partits[$id]), 404);
        $partit = $partits[$id];
        return view('partits.show', compact('partit'));
    }

    public function create()
    {
        return view('partits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'local' => 'required|min:2',
            'visitant' => 'required|min:2|different:local',
            'data' => 'required|date_format:Y-m-d',
            'resultat' => ['nullable', 'regex:/^\d+-\d+$/'],
        ]);

        $partits = Session::get('partits', $this->partits);
        $partits[] = $validated;
        Session::put('partits', $partits);

        return redirect()->route('partits.index')->with('success', 'Partet afegit correctament!');
    }
}
