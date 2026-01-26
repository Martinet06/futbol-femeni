<?php

namespace Tests\Unit;

use App\Repositories\JugadoraRepository;
use App\Models\Jugadora;
use App\Models\Equip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JugadoraRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected JugadoraRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new JugadoraRepository();
    }

    public function test_getAll_retorna_totes_amb_equip()
    {
        $equip = Equip::factory()->create();
        Jugadora::factory()->count(3)->create(['equip_id' => $equip->id]);

        $jugadores = $this->repo->getAll();

        $this->assertCount(3, $jugadores);
        $this->assertTrue($jugadores->first()->relationLoaded('equip'));
    }

    public function test_find_retorna_jugadora_amb_equip()
    {
        $jugadora = Jugadora::factory()->create();

        $result = $this->repo->find($jugadora->id);

        $this->assertEquals($jugadora->id, $result->id);
        $this->assertTrue($result->relationLoaded('equip'));
    }

    public function test_create_insereix_jugadora()
    {
        $equip = Equip::factory()->create();
        $data = [
            'nom' => 'Maria García',
            'equip_id' => $equip->id,
            'dorsal' => 10,
            'data_naixement' => '2000-05-15',
        ];

        $jugadora = $this->repo->create($data);

        $this->assertDatabaseHas('jugadores', ['nom' => 'Maria García', 'dorsal' => 10]);
        $this->assertEquals('Maria García', $jugadora->nom);
    }

    public function test_update_modifica_jugadora()
    {
        $jugadora = Jugadora::factory()->create(['dorsal' => 9]);

        $this->repo->update($jugadora->id, ['dorsal' => 11]);

        $this->assertDatabaseHas('jugadores', ['id' => $jugadora->id, 'dorsal' => 11]);
    }

    public function test_delete_esborra_jugadora()
    {
        $jugadora = Jugadora::factory()->create();

        $this->repo->delete($jugadora->id);

        $this->assertDatabaseMissing('jugadores', ['id' => $jugadora->id]);
    }
}
