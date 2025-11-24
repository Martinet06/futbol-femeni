<?php

namespace App\Http\Controllers;

use App\Models\Partit;
use App\Models\Equip;
use Illuminate\Http\Request;
use App\Services\PartitService;

class PartitController extends Controller
{
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
}
