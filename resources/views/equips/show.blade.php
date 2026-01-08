@extends('layouts.equip')
@section('title', "Detall d'Equip")
@section('content')
<x-equip
    :nom="$equip->nom"
    :estadi="$equip->estadi->nom"
    :titols="$equip->titols"
    :escut="$equip->escut" />

<div class="mt-6 border rounded-lg shadow-md p-4 bg-white max-w-lg mx-auto">
    <h2 class="text-xl font-bold text-blue-800 mb-4">Estadístiques</h2>

    <!-- Edat mitjana -->
    <p><strong>Edat mitjana de les jugadores:</strong>
        {{ $equip->edatMitjana() !== null ? $equip->edatMitjana() . ' anys' : 'N/A' }}
    </p>

    <!-- Últims 5 partits -->
    <h3 class="mt-4 text-lg font-semibold">Últims 5 partits</h3>
    @if($equip->ultimsPartits()->isEmpty())
    <p>No hi ha partits registrats.</p>
    @else
    <ul class="list-disc pl-5">
        @foreach($equip->ultimsPartits() as $partit)
        <li>
            {{ $partit->data_partit }}:
            {{ $partit->equipLocal->nom }}
            {{ $partit->gols_local !== null && $partit->gols_visitant !== null 
                                ? $partit->gols_local . ' - ' . $partit->gols_visitant 
                                : 'No jugat' 
                            }}
            {{ $partit->equipVisitant->nom }}
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection