<?php

namespace Tests\Unit\Policies;

use App\Policies\PartitPolicy;
use App\Models\Partit;
use App\Models\Equip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartitPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected PartitPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new PartitPolicy();
    }

    public function test_admin_pot_actualitzar_qualsevol_partit()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $local = Equip::factory()->create();
        $visitant = Equip::factory()->create();

        $partit = Partit::create([
            'equip_local_id' => $local->id,
            'equip_visitant_id' => $visitant->id,
            'data_partit' => now(),
            'arbitre_id' => null,
        ]);

        $this->assertTrue($this->policy->update($admin, $partit));
    }

    public function test_arbitre_només_pot_actualitzar_seus_partits()
    {
        $local = Equip::factory()->create();
        $visitant = Equip::factory()->create();
        $arbitre1 = User::factory()->create(['role' => 'arbitre']);
        $arbitre2 = User::factory()->create(['role' => 'arbitre']);

        $partit1 = Partit::create([
            'equip_local_id' => $local->id,
            'equip_visitant_id' => $visitant->id,
            'data_partit' => now(),
            'arbitre_id' => $arbitre1->id,
        ]);

        $partit2 = Partit::create([
            'equip_local_id' => $local->id,
            'equip_visitant_id' => $visitant->id,
            'data_partit' => now(),
            'arbitre_id' => $arbitre2->id,
        ]);

        // Arbitre 1 pot actualitzar el seu partit
        $this->assertTrue($this->policy->update($arbitre1, $partit1));

        // Arbitre 1 NO pot actualitzar el partit de l'arbitre 2
        $this->assertFalse($this->policy->update($arbitre1, $partit2));

        // Arbitre 2 pot actualitzar el seu partit
        $this->assertTrue($this->policy->update($arbitre2, $partit2));
    }

    public function test_no_es_permet_crear_partits_manualment()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $manager = User::factory()->create(['role' => 'manager']);
        $arbitre = User::factory()->create(['role' => 'arbitre']);

        // Cap rol pot crear partits manualment
        $this->assertFalse($this->policy->create($admin));
        $this->assertFalse($this->policy->create($manager));
        $this->assertFalse($this->policy->create($arbitre));
    }
}
