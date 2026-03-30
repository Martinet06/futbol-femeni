@extends('layouts.equip')
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

    {{-- Meteorologia --}}
    @if($weather)
    <div class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-200 rounded-lg">
        <h3 class="text-lg font-bold text-blue-800 mb-2">🌤️ Meteorologia</h3>

        <div class="flex items-center gap-4">
            {{-- Icona del temps --}}
            <div class="text-5xl">
                @if($weather['is_rainy'])
                ☔
                @elseif(str_contains($weather['weather_description'], 'Cel clar'))
                ☀️
                @elseif(str_contains($weather['weather_description'], 'Ennuvolat'))
                ⛅
                @elseif(str_contains($weather['weather_description'], 'Pluja'))
                🌧️
                @elseif(str_contains($weather['weather_description'], 'Neu'))
                ❄️
                @elseif(str_contains($weather['weather_description'], 'Tempesta'))
                ⛈️
                @elseif(str_contains($weather['weather_description'], 'Boira'))
                🌫️
                @else
                🌤️
                @endif
            </div>

            {{-- Dades meteorològiques --}}
            <div class="flex-1">
                <p class="text-2xl font-bold text-gray-800">{{ $weather['temperature'] }}°C</p>
                <p class="text-sm text-gray-600">{{ $weather['weather_description'] }}</p>
                @if(isset($weather['temperature_min']))
                <p class="text-xs text-gray-500">
                    Min: {{ $weather['temperature_min'] }}°C · Max: {{ $weather['temperature'] }}°C
                </p>
                @endif
            </div>
        </div>

        {{-- Probabilitat de pluja --}}
        <div class="mt-3 flex items-center gap-2">
            <span class="text-sm text-gray-600">💧 Probabilitat de pluja:</span>
            <div class="flex-1 bg-gray-200 rounded-full h-2">
                <div
                    class="h-2 rounded-full {{ $weather['rain_probability'] > 50 ? 'bg-blue-600' : 'bg-green-500' }}"
                    style="width: {{ $weather['rain_probability'] }}%"></div>
            </div>
            <span class="text-sm font-semibold">{{ $weather['rain_probability'] }}%</span>
        </div>

        @if($weather['is_rainy'])
        <p class="mt-2 text-sm text-blue-700 font-semibold">
            ⚠️ Es recomana portar paraigües o impermeable.
        </p>
        @endif

        {{-- Altres dades --}}
        <div class="mt-3 flex gap-4 text-sm text-gray-600">
            <span>💨 Vent: {{ $weather['wind_speed'] }} km/h</span>
            <span>💧 Humitat: {{ $weather['humidity'] }}%</span>
        </div>
    </div>
    @endif

    <br>
    <a href="{{ route('partits.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
        Tornar al llistat
    </a>
</div>
@endsection