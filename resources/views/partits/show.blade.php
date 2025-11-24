@extends('layouts.app')
@section('title', "Detall del Partit")

@section('content')
<div class="border rounded-lg shadow-md p-4 bg-white max-w-md mx-auto">
    <h2 class="text-xl font-bold text-blue-800 mb-2">
        {{ $partit->equipLocal->nom }} vs {{ $partit->equipVisitant->nom }}
    </h2>
    <p><strong>Data:</strong> {{ $partit->data_partit }}</p>
    <p><strong>Resultat:</strong>
        @if($partit->gols_local === null || $partit->gols_visitant === null)
        No jugat
        @else
        {{ $partit->gols_local }} - {{ $partit->gols_visitant }}
        @endif
    </p>

    <br>
    <a href="{{ route('partits.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
        Tornar al llistat
    </a>
</div>
@endsection