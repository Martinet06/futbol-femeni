@props(['local', 'visitant', 'data', 'resultat'])
<div class="jugadora border rounded-lg shadow-md p-4 bg-white">
    <h2 class="text-xl font-bold text-blue-800">Resum</h2>
    <p><strong>Equip Local:</strong> {{ $local }}</p>
    <p><strong>Equip Visitant:</strong> {{ $visitant }}</p>
    <p><strong>Data:</strong> {{ $data }}</p>
    <p><strong>Resultat:</strong> {{ $resultat }}</p>
</div>