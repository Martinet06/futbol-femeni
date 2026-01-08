@extends('layouts.equip')
@section('title', __("Modificació d'Equip"))

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

<form action="{{ route('equips.update', $equip->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label for="nom" class="block font-bold">{{ __('Nom')}}:</label>
        <input type="text" name="nom" id="nom"
            value="{{ old('nom', $equip->nom) }}"
            class="border p-2 w-full">
    </div>

    <div>
        <label for="estadi_id" class="block font-bold">{{ __('Estadi')}}:</label>
        <select name="estadi_id" id="estadi_id" class="border p-2 w-full">
            @foreach ($estadis as $estadi)
            <option value="{{ $estadi->id }}"
                {{ old('estadi_id', $equip->estadi_id) == $estadi->id ? 'selected' : '' }}>
                {{ $estadi->nom }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label for="escut" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Escut')}}:</label>
        @if ($equip->escut)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $equip->escut) }}" alt="Escut actual" class="h-16">
        </div>
        @endif
        <input type="file" name="escut" id="escut"
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <label for="titols" class="block font-bold">{{__('Títols')}}:</label>
        <input type="number" name="titols" id="titols"
            value="{{ old('titols', $equip->titols) }}"
            class="border p-2 w-full">
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">{{__('Actualitzar')}}</button>
</form>
@endsection