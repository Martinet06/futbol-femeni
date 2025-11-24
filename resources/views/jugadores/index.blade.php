@extends('layouts.app')
@section('title', "Llistat de Jugadores")

@section('content')
<h1 class="text-3xl font-bold text-blue-800 mb-6">Llistat de Jugadores</h1>

@if (session('success'))
<div class="bg-green-100 text-green-700 p-2 mb-4">{{ session('success') }}</div>
@endif

<p class="mb-4">
    <a href="{{ route('jugadores.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded">Nova Jugadora</a>
</p>

<table class="w-full border-collapse border border-gray-300">
    <thead class="bg-gray-200">
        <tr>
            <th class="border border-gray-300 p-2">Nom</th>
            <th class="border border-gray-300 p-2">Equip</th>
            <th class="border border-gray-300 p-2">Dorsal</th>
            <th class="border border-gray-300 p-2">Data Naixement</th>
            <th class="border border-gray-300 p-2">Foto</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jugadores as $jugadora)
        <tr class="hover:bg-gray-100">
            <td class="border border-gray-300 p-2">
                <a href="{{ route('jugadores.show', $jugadora) }}" class="text-blue-700 hover:underline">
                    {{ $jugadora->nom }}
                </a>
            </td>
            <td class="border border-gray-300 p-2">{{ $jugadora->equip->nom }}</td>
            <td class="border border-gray-300 p-2">{{ $jugadora->dorsal }}</td>
            <td class="border border-gray-300 p-2">{{ $jugadora->data_naixement }}</td>
            <td class="border border-gray-300 p-2">
                @if($jugadora->foto)
                <img src="{{ asset('storage/' . $jugadora->foto) }}" alt="Foto" class="w-12 h-12 object-cover rounded">
                @else
                -
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection