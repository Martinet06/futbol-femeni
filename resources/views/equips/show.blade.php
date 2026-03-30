@extends('layouts.equip')
@section('title', "Detall d'Equip")
@section('content')
<x-equip
    :nom="$equip->nom"
    :estadi="$equip->estadi->nom"
    :titols="$equip->titols"
    :escut="$equip->escut" />

{{-- Missatges de feedback IA --}}
@if(session('success'))
<div class="max-w-lg mx-auto mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="max-w-lg mx-auto mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
    {{ session('error') }}
</div>
@endif

@if(session('info'))
<div class="max-w-lg mx-auto mt-4 p-3 bg-blue-100 border border-blue-400 text-blue-700 rounded">
    {{ session('info') }}
</div>
@endif

{{-- Descripció IA --}}
<div class="max-w-lg mx-auto mt-6 border rounded-lg shadow-md p-4 bg-white">
    <div class="flex justify-between items-center mb-3">
        <h2 class="text-xl font-bold text-blue-800">Descripció</h2>
        @auth
        @if(auth()->user()->role === 'admin')
        <form action="{{ route('equips.ai-description', $equip) }}" method="POST" class="inline">
            @csrf
            <select name="provider" class="text-sm border rounded px-2 py-1">
                <option value="gemini">Gemini</option>
                <option value="openai">ChatGPT</option>
            </select>
            <button type="submit" class="ml-2 px-3 py-1 bg-purple-600 text-white text-sm rounded hover:bg-purple-700">
                ✨ Generar amb IA
            </button>
        </form>
        @endif
        @endauth
    </div>

    @if($equip->description)
    <p class="text-gray-700">{{ $equip->description }}</p>
    @else
    <p class="text-gray-500 italic">No hi ha descripció disponible. Utilitza la IA per generar-ne una.</p>
    @endif
</div>

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