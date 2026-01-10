<?php

namespace App\Policies;

use App\Models\Partit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PartitPolicy
{
    public function update(User $user, Partit $partit): bool
    {
        return $user->role === 'admin' ||
            ($user->role === 'arbitre' && $user->id === $partit->arbitre_id);
    }

    // No es permet crear partits manualment
    public function create(User $user): bool
    {
        return false; // desactivat
    }
}
