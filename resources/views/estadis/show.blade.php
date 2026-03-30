@extends('layouts.equip')
@section('title', "Detall d'Estadi")

@section('content')
<x-estadi :nom="$estadi->nom" :capacitat="$estadi->capacitat" :equips="$estadi->Equips" />

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
        <form action="{{ route('estadis.ai-description', $estadi) }}" method="POST" class="inline">
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

    @if($estadi->description)
    <p class="text-gray-700">{{ $estadi->description }}</p>
    @else
    <p class="text-gray-500 italic">No hi ha descripció disponible. Utilitza la IA per generar-ne una.</p>
    @endif
</div>
@endsection