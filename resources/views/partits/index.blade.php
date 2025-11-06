@extends('layouts.app')
@section('title', "Llistat de partits")

@section('content')
<h1 class="text-3xl font-bold text-blue-800 mb-6">Llistat de partits</h1>

@if (session('success'))
<div class="bg-green-100 text-green-700 p-2 mb-4">{{ session('success') }}</div>
@endif

<p class="mb-4">
    <a href="{{ route('partits.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded">Nou Partit</a>
</p>

<table class="w-full border-collapse border border-gray-300">
    <thead class="bg-gray-200">
        <tr>
            <th class="border border-gray-300 p-2">Vore Resum</th>
            <th class="border border-gray-300 p-2">Equip Local</th>
            <th class="border border-gray-300 p-2">Equip Visitant</th>
            <th class="border border-gray-300 p-2">Data</th>
            <th class="border border-gray-300 p-2">Resultat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($partits as $key => $partit)
        <tr class="hover:bg-gray-100">
            <td class="border border-gray-300 p-2"><a href="{{ route('partits.show', $key) }}" class="text-blue-700 hover:underline">Vore</a></td>
            <td class="border border-gray-300 p-2">{{ $partit['local'] }}</td>
            <td class="border border-gray-300 p-2">{{ $partit['visitant'] }}</td>
            <td class="border border-gray-300 p-2">{{ $partit['data'] }}</td>
            <td class="border border-gray-300 p-2">{{ $partit['resultat'] ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection