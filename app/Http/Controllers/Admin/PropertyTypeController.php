<?php
// app/Http/Controllers/Admin/PropertyTypeController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    public function index()
    {
        $propertyTypes = PropertyType::withCount('properties')->latest()->paginate(15);
        return view('admin.property-types.index', compact('propertyTypes'));
    }

    public function create()
    {
        return view('admin.property-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:property_types'],
            'description' => ['nullable', 'string'],
            'requires_address' => ['required', 'boolean'],
        ]);

        PropertyType::create($validated);

        return redirect()->route('admin.property-types.index')
            ->with('success', 'Type de bien créé avec succès.');
    }

    public function edit(PropertyType $propertyType)
    {
        return view('admin.property-types.edit', compact('propertyType'));
    }

    public function update(Request $request, PropertyType $propertyType)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:property_types,name,' . $propertyType->id],
            'description' => ['nullable', 'string'],
            'requires_address' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
        ]);

        $propertyType->update($validated);

        return redirect()->route('admin.property-types.index')
            ->with('success', 'Type de bien mis à jour avec succès.');
    }

    public function destroy(PropertyType $propertyType)
    {
        if ($propertyType->properties()->exists()) {
            return back()->with('error', 'Impossible de supprimer ce type : des biens y sont associés.');
        }

        $propertyType->delete();

        return redirect()->route('admin.property-types.index')
            ->with('success', 'Type de bien supprimé avec succès.');
    }

    public function toggleStatus(PropertyType $propertyType)
    {
        $propertyType->update(['is_active' => !$propertyType->is_active]);

        $status = $propertyType->is_active ? 'activé' : 'désactivé';
        return back()->with('success', "Type de bien {$status} avec succès.");
    }
}