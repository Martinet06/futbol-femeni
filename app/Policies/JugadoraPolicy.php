<?php

namespace App\Policies;

use App\Models\Jugadora;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JugadoraPolicy
{
    public function update(User $user, Jugadora $jugadora): bool
    {
        return $user->role === 'admin' ||
            ($user->role === 'manager' && $user->equip_id === $jugadora->equip_id);
    }

    public function delete(User $user, Jugadora $jugadora): bool
    {
        return $this->update($user, $jugadora);
    }
}
