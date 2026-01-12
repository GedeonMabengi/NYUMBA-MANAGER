<?php
// app/Http/Controllers/Bailleur/DashboardController.php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Rental;
use App\Models\Tenant;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_properties' => Property::ownedBy($user->id)->count(),
            'rented_properties' => Property::ownedBy($user->id)->rented()->count(),
            'available_properties' => Property::ownedBy($user->id)->available()->count(),
            'total_tenants' => Tenant::ownedBy($user->id)->count(),
            'active_rentals' => Rental::whereHas('property', fn($q) => $q->ownedBy($user->id))
                                      ->active()->count(),
        ];

        $recentProperties = Property::ownedBy($user->id)
            ->with('propertyType')
            ->latest()
            ->take(5)
            ->get();

        $activeRentals = Rental::whereHas('property', fn($q) => $q->ownedBy($user->id))
            ->active()
            ->with(['property', 'tenant'])
            ->latest()
            ->take(5)
            ->get();

        $avocats = $user->getActiveAvocats();

        return view('bailleur.dashboard', compact('stats', 'recentProperties', 'activeRentals', 'avocats'));
    }
}