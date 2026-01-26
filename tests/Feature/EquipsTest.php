<?php

namespace Tests\Feature;

use App\Models\Equip;
use App\Models\Estadi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pot_crear_equip()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $estadi = Estadi::factory()->create();

        $this->actingAs($admin)->post('/equips', [
            'nom' => 'Nou Equip Test',
            'estadi_id' => $estadi->id,
            'titols' => 5,
        ])->assertRedirect();

        $this->assertDatabaseHas('equips', ['nom' => 'Nou Equip Test']);
    }

    public function test_manager_no_pot_crear_equip()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $estadi = Estadi::factory()->create();

        $this->actingAs($manager)->post('/equips', [
            'nom' => 'Equip Illegal',
            'estadi_id' => $estadi->id,
            'titols' => 0,
        ])->assertForbidden();
    }

    public function test_tots_poden_veure_llistat_equips()
    {
        Equip::factory()->count(3)->create();

        // Sense autenticar
        $this->get('/equips')->assertOk();

        // Com a usuari autenticat
        $user = User::factory()->create();
        $this->actingAs($user)->get('/equips')->assertOk();
    }

    public function test_manager_pot_actualitzar_el_seu_equip()
    {
        $equip = Equip::factory()->create();
        $manager = User::factory()->create(['role' => 'manager', 'equip_id' => $equip->id]);

        $this->actingAs($manager)->put("/equips/{$equip->id}", [
            'nom' => 'Equip Actualitzat',
            'estadi_id' => $equip->estadi_id,
            'titols' => 10,
        ])->assertRedirect();

        $this->assertDatabaseHas('equips', ['id' => $equip->id, 'nom' => 'Equip Actualitzat']);
    }

    public function test_manager_no_pot_actualitzar_altre_equip()
    {
        $equip1 = Equip::factory()->create();
        $equip2 = Equip::factory()->create();
        $manager = User::factory()->create(['role' => 'manager', 'equip_id' => $equip1->id]);

        $this->actingAs($manager)->put("/equips/{$equip2->id}", [
            'nom' => 'Equip Alien',
            'estadi_id' => $equip2->estadi_id,
            'titols' => 99,
        ])->assertForbidden();
    }
}
