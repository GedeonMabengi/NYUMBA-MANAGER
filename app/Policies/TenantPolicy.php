<?php
// app/Policies/TenantPolicy.php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;

class TenantPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isBailleur();
    }

    public function view(User $user, Tenant $tenant): bool
    {
        if ($user->isBailleur()) {
            return $tenant->user_id === $user->id;
        }

        if ($user->isAvocat()) {
            return $user->bailleurs()->where('bailleur_id', $tenant->user_id)->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isBailleur();
    }

    public function update(User $user, Tenant $tenant): bool
    {
        return $user->isBailleur() && $tenant->user_id === $user->id;
    }

    public function delete(User $user, Tenant $tenant): bool
    {
        return $user->isBailleur() && $tenant->user_id === $user->id;
    }
}