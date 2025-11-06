@props(['nom', 'equip', 'posicio'])
<div class="jugadora border rounded-lg shadow-md p-4 bg-white">
    <h2 class="text-xl font-bold text-blue-800">{{ $nom }}</h2>
    <p><strong>Equip:</strong> {{ $equip }}</p>
    <p><strong>Posició:</strong> {{ $posicio }}</p>
</div>