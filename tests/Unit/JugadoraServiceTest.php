<?php

namespace Tests\Unit;

use App\Services\JugadoraService;
use App\Repositories\JugadoraRepository;
use App\Models\Jugadora;
use App\Models\Equip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class JugadoraServiceTest extends TestCase
{
    use RefreshDatabase;

    protected JugadoraService $service;
    protected $mockRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockRepo = Mockery::mock(JugadoraRepository::class);
        $this->service = new JugadoraService($this->mockRepo);
    }

    public function test_llistar_delega_al_repository()
    {
        $jugadores = collect([
            new Jugadora(['id' => 1, 'nom' => 'Jugadora 1']),
            new Jugadora(['id' => 2, 'nom' => 'Jugadora 2']),
        ]);

        $this->mockRepo->shouldReceive('getAll')->once()->andReturn($jugadores);

        $result = $this->service->llistar();

        $this->assertEquals($jugadores, $result);
    }

    public function test_guardar_delega_al_repository()
    {
        $data = [
            'nom' => 'Nova Jugadora',
            'equip_id' => 1,
            'dorsal' => 10,
            'data_naixement' => '2000-01-01',
        ];

        $jugadora = new Jugadora($data);
        $this->mockRepo->shouldReceive('create')->once()->with($data)->andReturn($jugadora);

        $result = $this->service->guardar($data);

        $this->assertEquals($jugadora, $result);
    }

    public function test_actualitzar_delega_al_repository()
    {
        $id = 1;
        $data = ['dorsal' => 11];

        $jugadora = new Jugadora(['id' => $id, 'dorsal' => 11]);
        $this->mockRepo->shouldReceive('update')->once()->with($id, $data)->andReturn($jugadora);

        $result = $this->service->actualitzar($id, $data);

        $this->assertEquals($jugadora, $result);
    }

    public function test_eliminar_delega_al_repository()
    {
        $id = 1;
        $this->mockRepo->shouldReceive('delete')->once()->with($id);

        $this->service->eliminar($id);

        $this->assertTrue(true); // Si no llança excepció, ha anat bé
    }

    public function test_trobar_delega_al_repository()
    {
        $id = 1;
        $jugadora = new Jugadora(['id' => $id, 'nom' => 'Test']);

        $this->mockRepo->shouldReceive('find')->once()->with($id)->andReturn($jugadora);

        $result = $this->service->trobar($id);

        $this->assertEquals($jugadora, $result);
    }
}
