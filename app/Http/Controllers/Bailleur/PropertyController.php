<?php
// app/Http/Controllers/Bailleur/PropertyController.php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\ActivityLog;
use App\Notifications\PropertyCreatedNotification;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::ownedBy(auth()->id())->with('propertyType');

        if ($request->filled('type')) {
            $query->where('property_type_id', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $properties = $query->latest()->paginate(15);
        $propertyTypes = PropertyType::active()->get();

        return view('bailleur.properties.index', compact('properties', 'propertyTypes'));
    }

    public function create()
    {
        $propertyTypes = PropertyType::active()->get();
        return view('bailleur.properties.create', compact('propertyTypes'));
    }

    public function store(Request $request)
    {
        $propertyType = PropertyType::findOrFail($request->property_type_id);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'property_type_id' => ['required', 'exists:property_types,id'],
            'is_for_rent' => ['required', 'boolean'],
            'surface' => ['nullable', 'numeric', 'min:0'],
            'rooms' => ['nullable', 'integer', 'min:0'],
        ];

        if ($propertyType->requires_address) {
            $rules['address'] = ['required', 'string', 'max:255'];
            $rules['city'] = ['required', 'string', 'max:255'];
            $rules['postal_code'] = ['required', 'string', 'max:20'];
            $rules['country'] = ['nullable', 'string', 'max:255'];
        } else {
            $rules['address'] = ['nullable', 'string', 'max:255'];
            $rules['city'] = ['nullable', 'string', 'max:255'];
            $rules['postal_code'] = ['nullable', 'string', 'max:20'];
            $rules['country'] = ['nullable', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'available';

        $property = Property::create($validated);

        ActivityLog::log('created', $property, null, $property->toArray());

        // Notifier les avocats si le bien est mis en location
        if ($property->is_for_rent) {
            $this->notifyAvocats($property, 'property_created');
        }

        return redirect()->route('bailleur.properties.show', $property)
            ->with('success', 'Bien créé avec succès.');
    }

    public function show(Property $property)
    {
        $this->authorize('view', $property);

        $property->load(['propertyType', 'rentals.tenant', 'activeRental.tenant', 'activeRental.documents']);

        return view('bailleur.properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $this->authorize('update', $property);

        $propertyTypes = PropertyType::active()->get();
        return view('bailleur.properties.edit', compact('property', 'propertyTypes'));
    }

    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $propertyType = PropertyType::findOrFail($request->property_type_id);
        $oldValues = $property->toArray();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'property_type_id' => ['required', 'exists:property_types,id'],
            'is_for_rent' => ['required', 'boolean'],
            'surface' => ['nullable', 'numeric', 'min:0'],
            'rooms' => ['nullable', 'integer', 'min:0'],
        ];

        if ($propertyType->requires_address) {
            $rules['address'] = ['required', 'string', 'max:255'];
            $rules['city'] = ['required', 'string', 'max:255'];
            $rules['postal_code'] = ['required', 'string', 'max:20'];
            $rules['country'] = ['nullable', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);

        $property->update($validated);

        ActivityLog::log('updated', $property, $oldValues, $property->toArray());

        return redirect()->route('bailleur.properties.show', $property)
            ->with('success', 'Bien mis à jour avec succès.');
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);

        if ($property->isRented()) {
            return back()->with('error', 'Impossible de supprimer un bien actuellement loué.');
        }

        ActivityLog::log('deleted', $property, $property->toArray(), null);

        $property->delete();

        return redirect()->route('bailleur.properties.index')
            ->with('success', 'Bien supprimé avec succès.');
    }

    public function getPropertyTypeInfo(PropertyType $propertyType)
    {
        return response()->json([
            'requires_address' => $propertyType->requires_address,
        ]);
    }

    protected function notifyAvocats(Property $property, string $eventType)
    {
        $bailleur = auth()->user();
        $avocats = $bailleur->getActiveAvocats();

        foreach ($avocats as $avocat) {
            $avocat->notify(new PropertyCreatedNotification($property, $bailleur));
        }
    }
}