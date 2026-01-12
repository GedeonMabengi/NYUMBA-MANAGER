<?php
// app/Http/Controllers/Bailleur/RentalController.php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Rental;
use App\Models\Document;
use App\Models\ActivityLog;
use App\Notifications\RentalCreatedNotification;
use App\Notifications\RentalCancelledNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class RentalController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::whereHas('property', fn($q) => $q->ownedBy(auth()->id()))
            ->with(['property', 'tenant']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rentals = $query->latest()->paginate(15);

        return view('bailleur.rentals.index', compact('rentals'));
    }

    public function create(Request $request)
    {
        $properties = Property::ownedBy(auth()->id())
            ->available()
            ->forRent()
            ->with('propertyType')
            ->get();

        $tenants = Tenant::ownedBy(auth()->id())->get();

        $selectedProperty = null;
        if ($request->filled('property_id')) {
            $selectedProperty = Property::find($request->property_id);
        }

        return view('bailleur.rentals.create', compact('properties', 'tenants', 'selectedProperty'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => ['required', 'exists:properties,id'],
            'tenant_id' => ['nullable', 'exists:tenants,id'],
            'new_tenant' => ['nullable', 'array'],
            'new_tenant.first_name' => ['required_without:tenant_id', 'string', 'max:255'],
            'new_tenant.last_name' => ['required_without:tenant_id', 'string', 'max:255'],
            'new_tenant.phone' => ['required_without:tenant_id', 'string', 'max:20'],
            'new_tenant.email' => ['nullable', 'email', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'rent_amount' => ['required', 'numeric', 'min:0'],
            'deposit_amount' => ['nullable', 'numeric', 'min:0'],
            'payment_frequency' => ['required', 'in:monthly,quarterly,yearly'],
            'notes' => ['nullable', 'string'],
            'lease_contract' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $property = Property::findOrFail($validated['property_id']);
        $this->authorize('update', $property);

        if (!$property->isAvailable()) {
            return back()->with('error', 'Ce bien n\'est pas disponible à la location.');
        }

        // Créer ou récupérer le locataire
        if (!empty($validated['tenant_id'])) {
            $tenant = Tenant::findOrFail($validated['tenant_id']);
        } else {
            $tenant = Tenant::create([
                'user_id' => auth()->id(),
                'first_name' => $validated['new_tenant']['first_name'],
                'last_name' => $validated['new_tenant']['last_name'],
                'phone' => $validated['new_tenant']['phone'],
                'email' => $validated['new_tenant']['email'] ?? null,
            ]);
        }

        // Créer la location
        $rental = Rental::create([
            'property_id' => $property->id,
            'tenant_id' => $tenant->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
            'rent_amount' => $validated['rent_amount'],
            'deposit_amount' => $validated['deposit_amount'] ?? null,
            'payment_frequency' => $validated['payment_frequency'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'active',
        ]);

        // Upload du contrat
        if ($request->hasFile('lease_contract')) {
            $file = $request->file('lease_contract');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('contracts/' . auth()->id(), $fileName, 'private');

            Document::create([
                'rental_id' => $rental->id,
                'name' => 'Contrat de bail',
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'document_type' => 'lease_contract',
                'uploaded_by' => auth()->id(),
            ]);
        }

        // Marquer le bien comme loué
        $property->markAsRented();

        ActivityLog::log('rental_started', $rental, null, $rental->toArray());

        // Notifier les avocats
        $this->notifyAvocats($rental, 'rental_created');

        return redirect()->route('bailleur.rentals.show', $rental)
            ->with('success', 'Location créée avec succès.');
    }

    public function show(Rental $rental)
    {
        $this->authorize('view', $rental->property);

        $rental->load(['property.propertyType', 'tenant', 'documents']);

        return view('bailleur.rentals.show', compact('rental'));
    }

    public function cancel(Request $request, Rental $rental)
    {
        $this->authorize('update', $rental->property);

        if (!$rental->isActive()) {
            return back()->with('error', 'Cette location n\'est pas active.');
        }

        $validated = $request->validate([
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $oldValues = $rental->toArray();

        $rental->cancel($validated['cancellation_reason'] ?? null);

        ActivityLog::log('rental_ended', $rental, $oldValues, $rental->toArray());

        // Notifier les avocats
        $this->notifyAvocats($rental, 'rental_cancelled');

        return redirect()->route('bailleur.rentals.index')
            ->with('success', 'Location annulée avec succès.');
    }

    public function addDocument(Request $request, Rental $rental)
    {
        $this->authorize('update', $rental->property);

        $validated = $request->validate([
            'document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'document_type' => ['required', 'in:lease_contract,amendment,inventory,other'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $file = $request->file('document');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('contracts/' . auth()->id(), $fileName, 'private');

        Document::create([
            'rental_id' => $rental->id,
            'name' => $validated['name'],
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'document_type' => $validated['document_type'],
            'uploaded_by' => auth()->id(),
        ]);

        return back()->with('success', 'Document ajouté avec succès.');
    }

    protected function notifyAvocats(Rental $rental, string $eventType)
    {
        $bailleur = auth()->user();
        $avocats = $bailleur->getActiveAvocats();

        foreach ($avocats as $avocat) {
            if ($eventType === 'rental_created') {
                $avocat->notify(new RentalCreatedNotification($rental, $bailleur));
            } elseif ($eventType === 'rental_cancelled') {
                $avocat->notify(new RentalCancelledNotification($rental, $bailleur));
            }
        }
    }
}