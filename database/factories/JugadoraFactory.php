<?php

namespace Database\Factories;

use App\Models\Equip;
use App\Models\Jugadora;
use Illuminate\Database\Eloquent\Factories\Factory;

class JugadoraFactory extends Factory
{
    protected $model = Jugadora::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->firstNameFemale . ' ' . $this->faker->lastName,
            'equip_id' => Equip::inRandomOrder()->first()->id ?? Equip::factory(),
            'data_naixement' => $this->faker->dateTimeBetween('-35 years', '-18 years')->format('Y-m-d'),
            'dorsal' => $this->faker->numberBetween(1, 99),
            'foto' => null,
        ];
    }
}
