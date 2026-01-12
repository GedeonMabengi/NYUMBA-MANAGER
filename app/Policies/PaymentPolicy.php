<?php
// app/Policies/PaymentPolicy.php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir la liste des paiements
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'bailleur';
    }

    /**
     * Détermine si l'utilisateur peut voir un paiement
     */
    public function view(User $user, Payment $payment): bool
    {
        return $user->id === $payment->user_id;
    }

    /**
     * Détermine si l'utilisateur peut créer un paiement
     */
    public function create(User $user): bool
    {
        return $user->role === 'bailleur';
    }

    /**
     * Détermine si l'utilisateur peut modifier un paiement
     */
    public function update(User $user, Payment $payment): bool
    {
        return $user->id === $payment->user_id;
    }

    /**
     * Détermine si l'utilisateur peut supprimer un paiement
     */
    public function delete(User $user, Payment $payment): bool
    {
        return $user->id === $payment->user_id;
    }
}