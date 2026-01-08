@extends('layouts.equip')
@section('title', 'Nou Partit')

@section('content')
<h1 class="text-2xl font-bold mb-4">Crear Partit</h1>

<form action="{{ route('partits.store') }}" method="POST">
    @csrf

    <label class="block mb-2">Equip Local:</label>
    <select name="equip_local_id" class="border p-2 mb-4 w-full">
        @foreach($equips as $equip)
        <option value="{{ $equip->id }}">{{ $equip->nom }}</option>
        @endforeach
    </select>

    <label class="block mb-2">Equip Visitant:</label>
    <select name="equip_visitant_id" class="border p-2 mb-4 w-full">
        @foreach($equips as $equip)
        <option value="{{ $equip->id }}">{{ $equip->nom }}</option>
        @endforeach
    </select>

    <label class="block mb-2">Data del Partit:</label>
    <input type="date" name="data_partit" class="border p-2 mb-4 w-full">

    <label class="block mb-2">Gols Local:</label>
    <input type="number" name="gol_local" class="border p-2 mb-4 w-full">

    <label class="block mb-2">Gols Visitant:</label>
    <input type="number" name="gol_visitant" class="border p-2 mb-4 w-full">

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Crear Partit</button>
</form>
@endsection