<?php

namespace Tests\Feature;

use App\Models\Equip;
use App\Models\Estadi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class EquipCrudFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // autoritza tot en tests per simplificar
        Gate::before(function () {
            return true;
        });
    }

    public function test_es_pot_llistar_equips()
    {
        $u = User::factory()->create();
        $this->actingAs($u);

        Equip::factory()->create(['nom' => 'FC Barcelona']);
        Equip::factory()->create(['nom' => 'Real Madrid']);

        $resp = $this->get('/equips'); // assegura rutes resource
        $resp->assertStatus(200);
        $resp->assertSee('FC Barcelona');
        $resp->assertSee('Real Madrid');
    }

    public function test_es_pot_crear_un_equip()
    {
        $u = User::factory()->create([
            'role' => 'administrador',     // per store/destroy
            'email_verified_at' => now(),  // per si algun middleware demana verified
        ]);
        $this->actingAs($u);

        $estadi = Estadi::factory()->create();
        Storage::fake('public');

        $resp = $this->from(route('equips.create')) // ← perquè si falla no et porte a '/'
            ->post('/equips', [
                'nom' => 'FC Barcelona',
                'titols' => 30,
                'estadi_id' => $estadi->id,
                'escut' => UploadedFile::fake()->image('escut.png'),
            ]);

        $resp->assertSessionHasNoErrors();          // ← clau per detectar validació
        $resp->assertRedirect(route('equips.index'));

        $this->assertDatabaseHas('equips', [
            'nom' => 'FC Barcelona',
            'titols' => 30,
            'estadi_id' => $estadi->id,
        ]);
    }

    public function test_es_pot_actualitzar_un_equip()
    {
        $u = User::factory()->create([
            'role' => 'manager',     // per store/destroy
            'email_verified_at' => now(),  // per si algun middleware demana verified
        ]);
        $this->actingAs($u);

        $estadi = Estadi::factory()->create();
        $equip = Equip::factory()->create([
            'nom' => 'FC Barcelona',
            'estadi_id' => $estadi->id,
            'titols' => 30,
        ]);

        $resp = $this->from(route('equips.edit', $equip))
            ->put("/equips/{$equip->id}", [
                'nom' => 'Barça',
                'estadi_id' => $estadi->id,   // si el rules el demana
                // 'titols' => 31,             // envia’l si el demanes com required
            ]);

        $resp->assertSessionHasNoErrors();
        $resp->assertRedirect(route('equips.index'));

        $this->assertDatabaseHas('equips', [
            'id' => $equip->id,
            'nom' => 'Barça',
        ]);
    }

    public function test_es_pot_esborrar_un_equip()
    {
        $u = User::factory()->create([
            'role' => 'administrador',     // per store/destroy
            'email_verified_at' => now(),  // per si algun middleware demana verified
        ]);
        $this->actingAs($u);

        $equip = Equip::factory()->create(['nom' => 'FC Barcelona']);

        $resp = $this->from(route('equips.index'))->delete("/equips/{$equip->id}");

        $resp->assertSessionHasNoErrors(); // normalment no hi haurà errors ací
        $resp->assertRedirect(route('equips.index'));

        $this->assertDatabaseMissing('equips', ['id' => $equip->id]);
    }
}
