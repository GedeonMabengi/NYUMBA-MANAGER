<?php
// app/Http/Controllers/Bailleur/TenantController.php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::ownedBy(auth()->id())->with('activeRentals.property');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $tenants = $query->latest()->paginate(15);

        return view('bailleur.tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('bailleur.tenants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'id_card_number' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = auth()->id();

        $tenant = Tenant::create($validated);

        return redirect()->route('bailleur.tenants.show', $tenant)
            ->with('success', 'Locataire créé avec succès.');
    }

    public function show(Tenant $tenant)
    {
        $this->authorize('view', $tenant);

        $tenant->load(['rentals.property', 'rentals.documents']);

        return view('bailleur.tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant)
    {
        $this->authorize('update', $tenant);

        return view('bailleur.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $this->authorize('update', $tenant);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'id_card_number' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $tenant->update($validated);

        return redirect()->route('bailleur.tenants.show', $tenant)
            ->with('success', 'Locataire mis à jour avec succès.');
    }

    public function destroy(Tenant $tenant)
    {
        $this->authorize('delete', $tenant);

        if ($tenant->activeRentals()->exists()) {
            return back()->with('error', 'Impossible de supprimer un locataire avec des locations actives.');
        }

        $tenant->delete();

        return redirect()->route('bailleur.tenants.index')
            ->with('success', 'Locataire supprimé avec succès.');
    }
}