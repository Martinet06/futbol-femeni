<?php

namespace Database\Factories;

use App\Models\Equip;
use App\Models\Partit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PartitFactory extends Factory
{
    protected $model = Partit::class;

    public function definition(): array
    {
        $equips = Equip::pluck('id')->toArray();

        // Equip local i visitant poden coincidir
        $local = $this->faker->randomElement($equips);
        $visitant = $this->faker->randomElement($equips);

        // 50% partits jugats, 50% partits futurs
        $esJugat = $this->faker->boolean();

        if ($esJugat) {
            // PARTIT JA JUGAT
            $data = Carbon::now()->subDays(rand(1, 300));
            $golsLocal = $this->faker->numberBetween(0, 5);
            $golsVisitant = $this->faker->numberBetween(0, 5);
        } else {
            // PARTIT FUTUR
            $data = Carbon::now()->addDays(rand(1, 300));
            $golsLocal = null;
            $golsVisitant = null;
        }

        return [
            'equip_local_id' => $local,
            'equip_visitant_id' => $visitant,
            'data_partit' => $data->format('Y-m-d'),
            'gols_local' => $golsLocal,
            'gols_visitant' => $golsVisitant,
        ];
    }
}
