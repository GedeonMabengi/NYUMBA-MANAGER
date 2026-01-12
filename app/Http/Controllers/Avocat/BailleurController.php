<?php
// app/Http/Controllers/Avocat/BailleurController.php

namespace App\Http\Controllers\Avocat;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Rental;

class BailleurController extends Controller
{
    public function index()
    {
        $bailleurs = auth()->user()->bailleurs()
            ->wherePivot('is_active', true)
            ->withCount(['properties', 'avocats'])
            ->get();

        return view('avocat.bailleurs.index', compact('bailleurs'));
    }

    public function show(User $bailleur)
    {
        // Vérifier que l'avocat est bien associé à ce bailleur
        if (!auth()->user()->bailleurs()->where('bailleur_id', $bailleur->id)->exists()) {
            abort(403);
        }

        $properties = $bailleur->properties()->with('propertyType')->get();
        $activeRentals = Rental::whereHas('property', fn($q) => $q->where('user_id', $bailleur->id))
            ->active()
            ->with(['property', 'tenant', 'documents'])
            ->get();

        return view('avocat.bailleurs.show', compact('bailleur', 'properties', 'activeRentals'));
    }

    public function properties(User $bailleur)
    {
        if (!auth()->user()->bailleurs()->where('bailleur_id', $bailleur->id)->exists()) {
            abort(403);
        }

        $properties = $bailleur->properties()
            ->with(['propertyType', 'activeRental.tenant'])
            ->paginate(15);

        return view('avocat.bailleurs.properties', compact('bailleur', 'properties'));
    }

    public function rentals(User $bailleur)
    {
        if (!auth()->user()->bailleurs()->where('bailleur_id', $bailleur->id)->exists()) {
            abort(403);
        }

        $rentals = Rental::whereHas('property', fn($q) => $q->where('user_id', $bailleur->id))
            ->with(['property', 'tenant', 'documents'])
            ->latest()
            ->paginate(15);

        return view('avocat.bailleurs.rentals', compact('bailleur', 'rentals'));
    }
}