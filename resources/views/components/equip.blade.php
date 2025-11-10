<div class="equip border rounded-lg shadow-md p-4 bg-white">
    <h2 class="text-xl font-bold text-blue-800">{{ $nom }}</h2>
    <p><strong>Estadi:</strong> {{ $estadi }}</p>
    <p><strong>Títols:</strong> {{ $titols }}</p>
    <br>
    <a href="{{ route('equips.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tornar al llistat</a>
</div>