@props(['nom', 'ciutat', 'capacitat', 'equip_principal'])
<div class="estadi border rounded-lg shadow-md p-4 bg-white">
    <h2 class="text-xl font-bold text-blue-800">{{ $nom }}</h2>
    <p><strong>Capacitat:</strong> {{ $capacitat }}</p>
    @if(!empty($equips) && count($equips) > 0)
    <p><strong>Equips:</strong></p>
    <ul class="list-disc ml-6">
        @foreach($equips as $equip)
        <li>{{ $equip->nom }}</li>
        @endforeach
    </ul>
    @else
    <p><em>No hi ha equips associats.</em></p>
    @endif
    <br>
    <a href="{{ route('estadis.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tornar al llistat</a>
</div>