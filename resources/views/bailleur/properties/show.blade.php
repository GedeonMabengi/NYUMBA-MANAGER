@extends('layouts.app')

@section('title', $property->name)

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- En-tête --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">
            {{ $property->name }}
        </h1>

        <div class="flex gap-2">
            <a href="{{ route('bailleur.properties.edit', $property) }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                Modifier
            </a>

            <form action="{{ route('bailleur.properties.destroy', $property) }}"
                  method="POST"
                  onsubmit="return confirm('Supprimer ce bien ?')">
                @csrf
                @method('DELETE')
                <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Infos principales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white shadow rounded-xl p-6 space-y-3">
            <h2 class="font-semibold text-lg">Informations générales</h2>

            <p><strong>Type :</strong> {{ $property->propertyType->name }}</p>
            <p><strong>Statut :</strong>
                <span class="px-3 py-1 rounded-full text-sm
                    {{ $property->status === 'available' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst($property->status) }}
                </span>
            </p>

            <p><strong>Surface :</strong> {{ $property->surface ?? '-' }} m²</p>
            <p><strong>Pièces :</strong> {{ $property->rooms ?? '-' }}</p>
            <p><strong>Location :</strong> {{ $property->is_for_rent ? 'Oui' : 'Non' }}</p>
        </div>

        <div class="bg-white shadow rounded-xl p-6 space-y-3">
            <h2 class="font-semibold text-lg">Adresse</h2>

            <p>{{ $property->address ?? '—' }}</p>
            <p>{{ $property->city ?? '' }} {{ $property->postal_code ?? '' }}</p>
            <p>{{ $property->country ?? '' }}</p>
        </div>
    </div>

    {{-- Description --}}
    @if($property->description)
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="font-semibold text-lg mb-2">Description</h2>
            <p class="text-gray-700">{{ $property->description }}</p>
        </div>
    @endif

    {{-- Location active --}}
    @if($property->activeRental)
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <h2 class="font-semibold text-lg mb-3">Location en cours</h2>

            <p><strong>Locataire :</strong>
                {{ $property->activeRental->tenant->first_name }}
                {{ $property->activeRental->tenant->last_name }}
            </p>

            <p><strong>Date début :</strong> {{ $property->activeRental->start_date }}</p>
            <p><strong>Loyer :</strong> {{ $property->activeRental->rent_amount }}</p>
        </div>
    @endif

    {{-- Historique des locations --}}
    @if($property->rentals->count())
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <h2 class="font-semibold text-lg p-4 border-b">Historique des locations</h2>

            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Locataire</th>
                        <th class="px-4 py-2">Début</th>
                        <th class="px-4 py-2">Fin</th>
                        <th class="px-4 py-2">Loyer</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($property->rentals as $rental)
                        <tr>
                            <td class="px-4 py-2">
                                {{ $rental->tenant->first_name }}
                                {{ $rental->tenant->last_name }}
                            </td>
                            <td class="px-4 py-2">{{ $rental->start_date }}</td>
                            <td class="px-4 py-2">{{ $rental->end_date ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $rental->rent_amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
