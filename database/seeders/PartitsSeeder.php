<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partit;
use App\Models\Equip;
use Carbon\Carbon;

class PartitsSeeder extends Seeder
{
    public function run(): void
    {
        $equips = Equip::all();

        // Recorrem tots els equips per generar partits d'anada i tornada
        foreach ($equips as $local) {
            foreach ($equips as $visitant) {
                if ($local->id === $visitant->id) {
                    continue; // evitem que un equip jugue contra si mateix
                }

                // Decideix aleatòriament si el partit ja s'ha jugat
                $esJugat = rand(0, 1) === 1;

                $dataPartit = $esJugat
                    ? Carbon::now()->subDays(rand(1, 300))   // partit ja jugat
                    : Carbon::now()->addDays(rand(1, 300));  // partit futur

                Partit::create([
                    'equip_local_id' => $local->id,
                    'equip_visitant_id' => $visitant->id,
                    'data_partit' => $dataPartit->format('Y-m-d'),
                    'gols_local' => $esJugat ? rand(0, 5) : null,
                    'gols_visitant' => $esJugat ? rand(0, 5) : null,
                ]);
            }
        }
    }
}
