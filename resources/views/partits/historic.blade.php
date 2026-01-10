@extends('layouts.equip')

@section('title', __('Històric de partits' ))

@section('content')

<!-- Afegim el component Livewire aquí -->
<div class="mt-8">
    @livewire('historial-partits')
</div>
@endsection