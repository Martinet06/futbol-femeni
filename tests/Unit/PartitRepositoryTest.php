<?php

namespace Tests\Unit;

use App\Repositories\PartitRepository;
use App\Models\Partit;
use App\Models\Equip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartitRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected PartitRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new PartitRepository();
    }

    public function test_getAll_retorna_tots_amb_equips()
    {
        $local = Equip::factory()->create();
        $visitant = Equip::factory()->create();
        Partit::factory()->count(4)->create([
            'equip_local_id' => $local->id,
            'equip_visitant_id' => $visitant->id,
        ]);

        $partits = $this->repo->getAll();

        $this->assertCount(4, $partits);
        $this->assertTrue($partits->first()->relationLoaded('equipLocal'));
        $this->assertTrue($partits->first()->relationLoaded('equipVisitant'));
    }

    public function test_find_retorna_partit_amb_equips()
    {
        $partit = Partit::factory()->create();

        $result = $this->repo->find($partit->id);

        $this->assertEquals($partit->id, $result->id);
        $this->assertTrue($result->relationLoaded('equipLocal'));
        $this->assertTrue($result->relationLoaded('equipVisitant'));
    }

    public function test_create_insereix_partit()
    {
        $local = Equip::factory()->create();
        $visitant = Equip::factory()->create();
        $data = [
            'equip_local_id' => $local->id,
            'equip_visitant_id' => $visitant->id,
            'data_partit' => '2024-01-01',
            'gols_local' => 2,
            'gols_visitant' => 1,
        ];

        $partit = $this->repo->create($data);

        $this->assertDatabaseHas('partits', [
            'equip_local_id' => $local->id,
            'gols_local' => 2,
        ]);
        $this->assertEquals(2, $partit->gols_local);
    }

    public function test_update_modifica_partit()
    {
        $partit = Partit::factory()->create(['gols_local' => null]);

        $this->repo->update($partit->id, ['gols_local' => 3, 'gols_visitant' => 2]);

        $this->assertDatabaseHas('partits', [
            'id' => $partit->id,
            'gols_local' => 3,
            'gols_visitant' => 2,
        ]);
    }

    public function test_delete_esborra_partit()
    {
        $partit = Partit::factory()->create();

        $this->repo->delete($partit->id);

        $this->assertDatabaseMissing('partits', ['id' => $partit->id]);
    }
}
