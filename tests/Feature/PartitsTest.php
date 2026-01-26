<?php

namespace Tests\Feature;

use App\Models\Partit;
use App\Models\Equip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartitsTest extends TestCase
{
    use RefreshDatabase;

    public function test_arbitre_pot_actualitzar_resultat_del_seu_partit()
    {
        $local = Equip::factory()->create();
        $visitant = Equip::factory()->create();
        $arbitre = User::factory()->create(['role' => 'arbitre']);

        $partit = Partit::create([
            'equip_local_id' => $local->id,
            'equip_visitant_id' => $visitant->id,
            'data_partit' => now(),
            'arbitre_id' => $arbitre->id,
        ]);

        $this->actingAs($arbitre)->put("/partits/{$partit->id}", [
            'gols_local' => 2,
            'gols_visitant' => 1,
        ])->assertRedirect();

        $this->assertDatabaseHas('partits', [
            'id' => $partit->id,
            'gols_local' => 2,
            'gols_visitant' => 1,
        ]);
    }

    public function test_arbitre_no_pot_actualitzar_partit_dun_altre()
    {
        $local = Equip::factory()->create();
        $visitant = Equip::factory()->create();
        $arbitre1 = User::factory()->create(['role' => 'arbitre']);
        $arbitre2 = User::factory()->create(['role' => 'arbitre']);

        $partit = Partit::create([
            'equip_local_id' => $local->id,
            'equip_visitant_id' => $visitant->id,
            'data_partit' => now(),
            'arbitre_id' => $arbitre1->id,
        ]);

        $this->actingAs($arbitre2)->put("/partits/{$partit->id}", [
            'gols_local' => 3,
            'gols_visitant' => 0,
        ])->assertForbidden();
    }

    public function test_admin_pot_actualitzar_qualsevol_partit()
    {
        $local = Equip::factory()->create();
        $visitant = Equip::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);

        $partit = Partit::create([
            'equip_local_id' => $local->id,
            'equip_visitant_id' => $visitant->id,
            'data_partit' => now(),
            'arbitre_id' => null,
        ]);

        $this->actingAs($admin)->put("/partits/{$partit->id}", [
            'gols_local' => 1,
            'gols_visitant' => 1,
        ])->assertRedirect();

        $this->assertDatabaseHas('partits', ['id' => $partit->id, 'gols_local' => 1]);
    }

    public function test_tots_poden_veure_llistat_partits()
    {
        Partit::factory()->count(3)->create();

        // Sense autenticar
        $this->get('/partits')->assertOk();

        // Com a usuari autenticat
        $user = User::factory()->create();
        $this->actingAs($user)->get('/partits')->assertOk();
    }
}
