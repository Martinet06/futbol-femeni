@props(['nom', 'ciutat', 'capacitat', 'equip_principal'])
<div class="estadi border rounded-lg shadow-md p-4 bg-white">
    <h2 class="text-xl font-bold text-blue-800">{{ $nom }}</h2>
    <p><strong>Ciutat:</strong> {{ $ciutat }}</p>
    <p><strong>Capacitat:</strong> {{ $capacitat }}</p>
    <p><strong>Equip principal:</strong> {{ $equip_principal }}</p>
    <br>
    <a href="{{ route('estadis.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tornar al llistat</a>
</div>