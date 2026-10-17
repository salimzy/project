<?php

namespace App\Policies;

use App\Models\Gig;
use App\Models\User;

class GigPolicy
{
    public function update(User $user, Gig $gig): bool
    {
        return $user->id === $gig->user_id || $user->role === 'admin';
    }
}
