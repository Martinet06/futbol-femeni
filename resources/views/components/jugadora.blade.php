@props(['nom', 'equip', 'dorsal', 'data_naixement', 'foto'])

<div class="jugadora border rounded-lg shadow-md p-4 bg-white max-w-md mx-auto">
    <h2 class="text-xl font-bold text-blue-800 mb-2">{{ $nom }}</h2>
    <p><strong>Equip:</strong> {{ $equip }}</p>
    <p><strong>Dorsal:</strong> {{ $dorsal }}</p>
    <p><strong>Data de naixement:</strong> {{ $data_naixement }}</p>

    @if($foto)
    <img src="{{ asset('storage/' . $foto) }}" alt="Foto" class="w-24 h-24 object-cover rounded mt-2">
    @else
    <p class="text-gray-500">Sense foto</p>
    @endif

    <br>
    <a href="{{ route('jugadores.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded mt-2 inline-block">
        Tornar al llistat
    </a>
</div>