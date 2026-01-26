<?php

namespace Tests\Unit\Policies;

use App\Policies\JugadoraPolicy;
use App\Models\Jugadora;
use App\Models\Equip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JugadoraPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected JugadoraPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new JugadoraPolicy();
    }

    public function test_admin_pot_gestionar_qualsevol_jugadora()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $jugadora = Jugadora::factory()->create();

        $this->assertTrue($this->policy->update($admin, $jugadora));
        $this->assertTrue($this->policy->delete($admin, $jugadora));
    }

    public function test_manager_només_pot_gestionar_jugadores_del_seu_equip()
    {
        $equip1 = Equip::factory()->create();
        $equip2 = Equip::factory()->create();
        $manager = User::factory()->create(['role' => 'manager', 'equip_id' => $equip1->id]);

        $jugadora1 = Jugadora::factory()->create(['equip_id' => $equip1->id]);
        $jugadora2 = Jugadora::factory()->create(['equip_id' => $equip2->id]);

        // Pot gestionar jugadores del seu equip
        $this->assertTrue($this->policy->update($manager, $jugadora1));
        $this->assertTrue($this->policy->delete($manager, $jugadora1));

        // NO pot gestionar jugadores d'un altre equip
        $this->assertFalse($this->policy->update($manager, $jugadora2));
        $this->assertFalse($this->policy->delete($manager, $jugadora2));
    }

    public function test_arbitre_no_te_permisos_sobre_jugadores()
    {
        $arbitre = User::factory()->create(['role' => 'arbitre']);
        $jugadora = Jugadora::factory()->create();

        $this->assertFalse($this->policy->update($arbitre, $jugadora));
        $this->assertFalse($this->policy->delete($arbitre, $jugadora));
    }
}
