<div>
    <div class="flex space-x-4">
        <input wire:model="equip" type="text" placeholder="Cerca equip" class="border px-4 py-2">
        <input wire:model="data" type="date" class="border px-4 py-2">
        <button wire:click="filtrar" class="bg-blue-500 text-white px-4 py-2">Filtrar</button>
    </div>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th>Data</th>
                <th>Equip Local</th>
                <th>Equip Visitant</th>
                <th>Resultat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($partits as $partit)
            <tr>

                <td align="center">{{ $partit->data_partit }}</td>
                <td align="center">{{ $partit->equipLocal->nom }}</td>
                <td align="center">{{ $partit->equipVisitant->nom }}</td>
                <td align="center">{{ $partit->gols_local }} - {{ $partit->gols_visitant }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>