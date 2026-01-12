<?php
// app/Http/Controllers/Avocat/DashboardController.php

namespace App\Http\Controllers\Avocat;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Property;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $bailleurs = $user->bailleurs()->wherePivot('is_active', true)->get();
        $bailleurIds = $bailleurs->pluck('id');

        $stats = [
            'total_bailleurs' => $bailleurs->count(),
            'total_properties' => Property::whereIn('user_id', $bailleurIds)->count(),
            'active_rentals' => Rental::whereHas('property', fn($q) => $q->whereIn('user_id', $bailleurIds))
                                      ->active()->count(),
        ];

        $recentEvents = $this->getRecentEvents($bailleurIds);

        return view('avocat.dashboard', compact('stats', 'bailleurs', 'recentEvents'));
    }

    protected function getRecentEvents($bailleurIds)
    {
        // Récupérer les locations récentes (créées ou annulées)
        $rentals = Rental::whereHas('property', fn($q) => $q->whereIn('user_id', $bailleurIds))
            ->with(['property.owner', 'tenant'])
            ->latest()
            ->take(10)
            ->get();

        // Récupérer les biens récemment mis en location
        $properties = Property::whereIn('user_id', $bailleurIds)
            ->where('is_for_rent', true)
            ->with('owner')
            ->latest()
            ->take(10)
            ->get();

        $events = collect();

        foreach ($rentals as $rental) {
            $events->push([
                'type' => $rental->status === 'active' ? 'rental_created' : 'rental_ended',
                'date' => $rental->created_at,
                'data' => $rental,
            ]);
        }

        foreach ($properties as $property) {
            $events->push([
                'type' => 'property_for_rent',
                'date' => $property->created_at,
                'data' => $property,
            ]);
        }

        return $events->sortByDesc('date')->take(15)->values();
    }
}