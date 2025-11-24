<?php

namespace Database\Seeders;

use App\Models\Equip;
use App\Models\Jugadora;
use Illuminate\Database\Seeder;

class JugadoresSeeder extends Seeder
{
    public function run(): void
    {
        $barca = Equip::where('nom', 'Barça Femení')->first();
        $atletic = Equip::where('nom', 'Atlètic de Madrid')->first();
        $madrid = Equip::where('nom', 'Real Madrid Femení')->first();

        $seedEquips = [$barca, $atletic, $madrid];

        foreach ($seedEquips as $equip) {
            if ($equip) {
                Jugadora::factory()->count(3)->create([
                    'equip_id' => $equip->id
                ]);
            }
        }

        $equips = Equip::all();
        Jugadora::factory()->count(10)->create([
            'equip_id' => $equips->random()->id
        ]);
    }
}
