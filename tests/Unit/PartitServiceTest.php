<?php

namespace Tests\Unit;

use App\Services\PartitService;
use App\Repositories\PartitRepository;
use App\Models\Partit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class PartitServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PartitService $service;
    protected $mockRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockRepo = Mockery::mock(PartitRepository::class);
        $this->service = new PartitService($this->mockRepo);
    }

    public function test_llistar_delega_al_repository()
    {
        $partits = collect([
            new Partit(['id' => 1, 'equip_local_id' => 1]),
            new Partit(['id' => 2, 'equip_local_id' => 2]),
        ]);

        $this->mockRepo->shouldReceive('getAll')->once()->andReturn($partits);

        $result = $this->service->llistar();

        $this->assertEquals($partits, $result);
    }

    public function test_guardar_delega_al_repository()
    {
        $data = [
            'equip_local_id' => 1,
            'equip_visitant_id' => 2,
            'data_partit' => '2024-01-01',
        ];

        $partit = new Partit($data);
        $this->mockRepo->shouldReceive('create')->once()->with($data)->andReturn($partit);

        $result = $this->service->guardar($data);

        $this->assertEquals($partit, $result);
    }

    public function test_actualitzar_delega_al_repository()
    {
        $id = 1;
        $data = ['gols_local' => 2];

        $partit = new Partit(['id' => $id, 'gols_local' => 2]);
        $this->mockRepo->shouldReceive('update')->once()->with($id, $data)->andReturn($partit);

        $result = $this->service->actualitzar($id, $data);

        $this->assertEquals($partit, $result);
    }

    public function test_eliminar_delega_al_repository()
    {
        $id = 1;
        $this->mockRepo->shouldReceive('delete')->once()->with($id);

        $this->service->eliminar($id);

        $this->assertTrue(true);
    }

    public function test_trobar_delega_al_repository()
    {
        $id = 1;
        $partit = new Partit(['id' => $id]);

        $this->mockRepo->shouldReceive('find')->once()->with($id)->andReturn($partit);

        $result = $this->service->trobar($id);

        $this->assertEquals($partit, $result);
    }
}
