@extends('layouts.equip')
@section('title', "Llistat de Partits")

@section('content')
<h1 class="text-3xl font-bold text-blue-800 mb-6">Llistat de Partits</h1>

<table class="w-full border-collapse border border-gray-300">
    <thead class="bg-gray-200">
        <tr>
            <th class="border border-gray-300 p-2">Data</th>
            <th class="border border-gray-300 p-2">Local</th>
            <th class="border border-gray-300 p-2">Visitant</th>
            <th class="border border-gray-300 p-2">Resultat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($partits as $partit)
        <tr class="hover:bg-gray-100">
            <td class="border border-gray-300 p-2">{{ $partit->data_partit }}</td>
            <td class="border border-gray-300 p-2">{{ $partit->equipLocal->nom }}</td>
            <td class="border border-gray-300 p-2">{{ $partit->equipVisitant->nom }}</td>
            <td class="border border-gray-300 p-2">
                <a href="{{ route('partits.show', $partit) }}" class="text-blue-700 hover:underline">
                    @if($partit->gols_local === null || $partit->gols_visitant === null)
                    No jugat
                    @else
                    {{ $partit->gols_local }} - {{ $partit->gols_visitant }}
                    @endif
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection