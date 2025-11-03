@extends('layouts.app')
@section('title', 'Afegir nova jugadora')

@section('content')
<h1 class="text-2xl font-bold mb-4">Afegir nova jugadora</h1>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-2 mb-4">
    <ul>
        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
</div>
@endif

<form action="{{ route('jugadores.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label for="nom" class="block font-bold">Nom:</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="border p-2 w-full">
    </div>
    <div>
        <label for="equip" class="block font-bold">Equip:</label>
        <input type="text" name="equip" id="equip" value="{{ old('equip') }}" class="border p-2 w-full">
    </div>
    <div>
        <label for="posicio" class="block font-bold">Posició:</label>
        <select name="capacitat" id="capacitat" value="{{ old('capacitat') }}" class="border p-2 w-full">
            <option value="Portera">Portera</option>
            <option value="Defensa">Defensa</option>
            <option value="Migcampista">Migcampista</option>
            <option value="Davantera">Davantera</option>
        </select>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Afegir</button>
</form>
@endsection