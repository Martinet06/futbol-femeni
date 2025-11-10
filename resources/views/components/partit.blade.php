@props(['local', 'visitant', 'data', 'resultat'])
<div class="jugadora border rounded-lg shadow-md p-4 bg-white">
    <h2 class="text-xl font-bold text-blue-800">Resum</h2>
    <p><strong>Equip Local:</strong> {{ $local }}</p>
    <p><strong>Equip Visitant:</strong> {{ $visitant }}</p>
    <p><strong>Data:</strong> {{ $data }}</p>
    <p><strong>Resultat:</strong> {{ $resultat }}</p>
    <br>
    <a href="{{ route('partits.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tornar al llistat</a>
</div>