<?php

namespace Tests\Unit\Policies;

use App\Policies\EquipPolicy;
use App\Models\Equip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected EquipPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new EquipPolicy();
    }

    public function test_admin_pot_fer_tot()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $equip = Equip::factory()->create();

        $this->assertTrue($this->policy->create($admin));
        $this->assertTrue($this->policy->update($admin, $equip));
        $this->assertTrue($this->policy->delete($admin, $equip));
    }

    public function test_manager_només_pot_actualitzar_el_seu_equip()
    {
        $equip1 = Equip::factory()->create();
        $equip2 = Equip::factory()->create();
        $manager = User::factory()->create(['role' => 'manager', 'equip_id' => $equip1->id]);

        // Pot actualitzar el seu equip
        $this->assertTrue($this->policy->update($manager, $equip1));

        // NO pot actualitzar un altre equip
        $this->assertFalse($this->policy->update($manager, $equip2));

        // NO pot crear ni eliminar equips
        $this->assertFalse($this->policy->create($manager));
        $this->assertFalse($this->policy->delete($manager, $equip1));
    }

    public function test_arbitre_no_te_permisos_sobre_equips()
    {
        $arbitre = User::factory()->create(['role' => 'arbitre']);
        $equip = Equip::factory()->create();

        $this->assertFalse($this->policy->create($arbitre));
        $this->assertFalse($this->policy->update($arbitre, $equip));
        $this->assertFalse($this->policy->delete($arbitre, $equip));
    }
}
