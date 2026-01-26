<?php

namespace Tests\Feature\Requests;

use App\Models\User;
use App\Models\Estadi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EstadiRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_només_admin_pot_crear_estadi()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $admin = User::factory()->create(['role' => 'admin']);

        // Manager intenta crear estadi → prohibido
        $this->actingAs($manager)->post('/estadis', [
            'nom' => 'Estadi Prohibit',
            'capacitat' => 50000,
        ])->assertForbidden();

        // Admin crea estadi → OK
        $this->actingAs($admin)->post('/estadis', [
            'nom' => 'Estadi Permès',
            'capacitat' => 50000,
        ])->assertRedirect();

        $this->assertDatabaseHas('estadis', ['nom' => 'Estadi Permès']);
    }

    public function test_valida_capacitat_positiva()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/estadis', [
            'nom' => 'Estadi Petit',
            'capacitat' => -100, // negatiu → error
        ]);

        $response->assertSessionHasErrors('capacitat');

        $response = $this->actingAs($admin)->post('/estadis', [
            'nom' => 'Estadi Correcte',
            'capacitat' => 1500, // mínim 1000 → OK
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('estadis', ['capacitat' => 1500]);
    }

    public function test_valida_nom_unic()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Estadi::factory()->create(['nom' => 'Camp Nou']);

        $response = $this->actingAs($admin)->post('/estadis', [
            'nom' => 'Camp Nou', // ja existeix
            'capacitat' => 99000,
        ]);

        $response->assertSessionHasErrors('nom');
    }
}
