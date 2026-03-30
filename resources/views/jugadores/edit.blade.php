@extends('layouts.equip')
@section('title', __("Modificació de jugadora"))

@section('content')
@if ($errors->any())
<div class="bg-red-100 text-red-700 p-2 mb-4">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('jugadores.update', $jugadora->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label for="nom" class="block font-bold">Nom:</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $jugadora->nom) }}" class=" border p-2 w-full">
    </div>

    <div>
        <label for="equip_id" class="block font-bold">Equip:</label>
        <select name="equip_id" id="equip_id" class="border p-2 w-full">
            @foreach ($equips as $equip)
            <option value="{{ $equip->id }}" {{  old('equip_id', $jugadora->equip_id ?? '') == $equip->id ? 'selected' : '' }}>
                {{ $equip->nom }}
            </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="dorsal" class="block font-bold">Dorsal:</label>
        <input type="number" name="dorsal" id="dorsal" value="{{ old('dorsal', $jugadora->dorsal)}}" class="border p-2 w-full">
    </div>

    <div>
        <label for="data_naixement" class="block font-bold">Data de naixement:</label>
        <input type="date" name="data_naixement" id="data_naixement" value="{{ old('data_naixement', $jugadora->data_naixement) }}" class="border p-2 w-full">
    </div>

    <div>
        <label for="foto" class="block font-bold">Foto:</label>
        <input type="file" name="foto" id="foto" value="{{ old('foto', $jugadora->foto) }}" class="border p-2 w-full">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualitzar</button>
    <a href="{{ route('jugadores.index') }}" class="ml-2 text-blue-700 hover:underline">Tornar</a>
</form>
@endsection