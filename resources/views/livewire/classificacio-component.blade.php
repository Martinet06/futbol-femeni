<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                📊 Classificació {{ $temporada }}
            </h1>
            <button
                wire:click="actualitzarClassificacio"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                🔄 Actualitzar
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">#</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Equip</th>
                        <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">PJ</th>
                        <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">PG</th>
                        <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">PE</th>
                        <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">PP</th>
                        <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">GF</th>
                        <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">GC</th>
                        <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">DG</th>
                        <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">PTS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classificacio as $index => $equip)
                    <tr class="hover:bg-gray-50 transition duration-200 {{ $index < 3 ? 'bg-yellow-50' : '' }}">
                        <td class="py-3 px-4 border-b text-left">
                            <span class="font-bold {{ $index === 0 ? 'text-yellow-500 text-xl' : ($index < 3 ? 'text-orange-500' : 'text-gray-600') }}">
                                {{ $index + 1 }}
                                @if($index === 0) 🥇 @elseif($index === 1) 🥈 @elseif($index === 2) 🥉 @endif
                            </span>
                        </td>
                        <td class="py-3 px-4 border-b text-left font-bold text-gray-800">
                            {{ $equip['nom'] }}
                        </td>
                        <td class="py-3 px-4 border-b text-center">{{ $equip['partits_jugats'] }}</td>
                        <td class="py-3 px-4 border-b text-center text-green-600">{{ $equip['partits_guanyats'] }}</td>
                        <td class="py-3 px-4 border-b text-center text-yellow-600">{{ $equip['partits_empatats'] }}</td>
                        <td class="py-3 px-4 border-b text-center text-red-600">{{ $equip['partits_perduts'] }}</td>
                        <td class="py-3 px-4 border-b text-center font-semibold">{{ $equip['gols_favor'] }}</td>
                        <td class="py-3 px-4 border-b text-center font-semibold">{{ $equip['gols_contra'] }}</td>
                        <td class="py-3 px-4 border-b text-center {{ $equip['diferencia'] >= 0 ? 'text-green-600' : 'text-red-600' }} font-semibold">
                            {{ $equip['diferencia'] >= 0 ? '+' . $equip['diferencia'] : $equip['diferencia'] }}
                        </td>
                        <td class="py-3 px-4 border-b text-center font-bold text-blue-600 text-lg">
                            {{ $equip['punts'] }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="py-6 text-center text-gray-500">
                            No hi ha dades disponibles
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-sm text-gray-500">
            <p>PJ = Partits Jugats | PG = Partits Guanyats | PE = Partits Empatats | PP = Partits Perduts</p>
            <p>GF = Gols a Favor | GC = Gols en Contra | DG = Diferència de Gols | PTS = Punts</p>
        </div>
    </div>
</div>