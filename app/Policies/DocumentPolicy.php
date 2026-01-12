<?php
// app/Policies/DocumentPolicy.php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function view(User $user, Document $document): bool
    {
        $rental = $document->rental;
        $property = $rental->property;

        if ($user->isBailleur()) {
            return $property->user_id === $user->id;
        }

        if ($user->isAvocat()) {
            return $user->bailleurs()->where('bailleur_id', $property->user_id)->exists();
        }

        return false;
    }

    public function delete(User $user, Document $document): bool
    {
        $property = $document->rental->property;
        return $user->isBailleur() && $property->user_id === $user->id;
    }
}