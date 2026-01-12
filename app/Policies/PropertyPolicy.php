<?php
// app/Policies/PropertyPolicy.php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isBailleur() || $user->isAdmin();
    }

    public function view(User $user, Property $property): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isBailleur()) {
            return $property->user_id === $user->id;
        }

        if ($user->isAvocat()) {
            return $user->bailleurs()->where('bailleur_id', $property->user_id)->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isBailleur();
    }

    public function update(User $user, Property $property): bool
    {
        return $user->isBailleur() && $property->user_id === $user->id;
    }

    public function delete(User $user, Property $property): bool
    {
        return $user->isBailleur() && $property->user_id === $user->id;
    }
}