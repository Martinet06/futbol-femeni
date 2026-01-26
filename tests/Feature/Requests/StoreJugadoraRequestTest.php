<?php

namespace Tests\Feature\Requests;

use App\Http\Requests\StoreJugadoraRequest;
use App\Models\Equip;
use App\Models\User;
use App\Models\Jugadora;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreJugadoraRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_valida_dorsal_unic_per_equip()
    {
        $equip = Equip::factory()->create();
        $manager = User::factory()->create(['role' => 'manager', 'equip_id' => $equip->id]);

        // Creem una jugadora amb dorsal 10
        $this->actingAs($manager)->post('/jugadores', [
            'nom' => 'Jugadora 1',
            'equip_id' => $equip->id,
            'dorsal' => 10,
            'data_naixement' => '2005-01-01',
        ]);

        // Intentem crear una altra amb el mateix dorsal → ha de fallar
        $response = $this->actingAs($manager)->post('/jugadores', [
            'nom' => 'Jugadora 2',
            'equip_id' => $equip->id,
            'dorsal' => 10, // mateix dorsal!
            'data_naixement' => '2005-01-01',
        ]);

        $response->assertSessionHasErrors('dorsal');
    }

    public function test_valida_edat_minima_16_anys()
    {
        $equip = Equip::factory()->create();
        $manager = User::factory()->create(['role' => 'manager', 'equip_id' => $equip->id]);

        // Data de naixement fa 15 anys → ha de fallar
        $response = $this->actingAs($manager)->post('/jugadores', [
            'nom' => 'Jugadora Jove',
            'equip_id' => $equip->id,
            'dorsal' => 99,
            'data_naixement' => now()->subYears(15)->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('data_naixement');

        // Data de naixement fa 16 anys → ha de passar
        $response = $this->actingAs($manager)->post('/jugadores', [
            'nom' => 'Jugadora Major',
            'equip_id' => $equip->id,
            'dorsal' => 99,
            'data_naixement' => now()->subYears(16)->format('Y-m-d'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('jugadores', ['nom' => 'Jugadora Major']);
    }

    public function test_valida_foto_només_png()
    {
        $equip = Equip::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);

        // Intentar pujar JPG → ha de fallar
        $fotoJpg = \Illuminate\Http\UploadedFile::fake()->image('test.jpg');
        $response = $this->actingAs($admin)->post('/jugadores', [
            'nom' => 'Jugadora amb JPG',
            'equip_id' => $equip->id,
            'dorsal' => 7,
            'data_naixement' => '2000-01-01',
            'foto' => $fotoJpg,
        ]);

        $response->assertSessionHasErrors('foto');

        // Pujar PNG → ha de passar
        $fotoPng = \Illuminate\Http\UploadedFile::fake()->image('test.png');
        $response = $this->actingAs($admin)->post('/jugadores', [
            'nom' => 'Jugadora amb PNG',
            'equip_id' => $equip->id,
            'dorsal' => 7,
            'data_naixement' => '2000-01-01',
            'foto' => $fotoPng,
        ]);

        $response->assertRedirect();
    }

    public function test_manager_només_pot_crear_jugadores_del_seu_equip()
    {
        $equip1 = Equip::factory()->create();
        $equip2 = Equip::factory()->create();
        $manager = User::factory()->create(['role' => 'manager', 'equip_id' => $equip1->id]);

        // Intentem crear jugadora per a un altre equip → ha de fallar authorize()
        $response = $this->actingAs($manager)->post('/jugadores', [
            'nom' => 'Jugadora Alien',
            'equip_id' => $equip2->id, // equip diferent!
            'dorsal' => 7,
            'data_naixement' => '2000-01-01',
        ]);

        $response->assertForbidden(); // 403 - no autoritzat
    }

    public function test_admin_pot_crear_jugadores_per_a_qualsevol_equip()
    {
        $equip = Equip::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/jugadores', [
            'nom' => 'Jugadora Admin',
            'equip_id' => $equip->id,
            'dorsal' => 9,
            'data_naixement' => '2000-01-01',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('jugadores', ['nom' => 'Jugadora Admin']);
    }
}
