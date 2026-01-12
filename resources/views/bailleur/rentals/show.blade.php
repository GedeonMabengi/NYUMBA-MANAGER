@extends('layouts.app')

@section('title', 'Détails de la location')

@section('content')
<div class="max-w-6xl mx-auto p-6 space-y-6">

    {{-- En-tête --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">
            Location – {{ $rental->property->name }}
        </h1>

        <span class="px-3 py-1 rounded-full text-sm font-medium
            {{ $rental->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
            {{ ucfirst($rental->status) }}
        </span>
    </div>

    {{-- Infos principales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white shadow rounded-xl p-5 space-y-3">
            <h2 class="font-semibold text-gray-700">Bien immobilier</h2>
            <p><strong>Nom :</strong> {{ $rental->property->name }}</p>
            <p><strong>Type :</strong> {{ $rental->property->propertyType->name ?? '-' }}</p>
        </div>

        <div class="bg-white shadow rounded-xl p-5 space-y-3">
            <h2 class="font-semibold text-gray-700">Locataire</h2>
            <p><strong>Nom :</strong> {{ $rental->tenant->first_name }} {{ $rental->tenant->last_name }}</p>
            <p><strong>Téléphone :</strong> {{ $rental->tenant->phone }}</p>
            <p><strong>Email :</strong> {{ $rental->tenant->email ?? '-' }}</p>
        </div>

    </div>

    {{-- Détails du contrat --}}
    <div class="bg-white shadow rounded-xl p-5 space-y-3">
        <h2 class="font-semibold text-gray-700">Contrat</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <p><strong>Début :</strong> {{ $rental->start_date }}</p>
            <p><strong>Fin :</strong> {{ $rental->end_date ?? 'Indéterminée' }}</p>
            <p><strong>Loyer :</strong> {{ number_format($rental->rent_amount, 2) }} $</p>
            <p><strong>Caution :</strong> {{ $rental->deposit_amount ?? '0' }} $</p>
            <p><strong>Paiement :</strong> {{ ucfirst($rental->payment_frequency) }}</p>
        </div>

        @if($rental->notes)
            <p class="mt-3 text-gray-600"><strong>Notes :</strong> {{ $rental->notes }}</p>
        @endif
    </div>

    {{-- Documents --}}
    <div class="bg-white shadow rounded-xl p-5">
        <div class="flex justify-between items-center mb-3">
            <h2 class="font-semibold text-gray-700">Documents</h2>
            <a href=""
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                + Ajouter
            </a>
            {{--<!-- <a href="{{ route('bailleur.rentals.addDocument', $rental) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                + Ajouter
            </a> -->--}}
        </div>

        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left">Nom</th>
                    <th class="px-3 py-2">Type</th>
                    <th class="px-3 py-2">Taille</th>
                    <th class="px-3 py-2">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($rental->documents as $doc)
                    <tr>
                        <td class="px-3 py-2">{{ $doc->name }}</td>
                        <td class="px-3 py-2 text-center">{{ ucfirst($doc->document_type) }}</td>
                        <td class="px-3 py-2 text-center">
                            {{ round($doc->file_size / 1024, 1) }} KB
                        </td>
                        <td class="px-3 py-2 text-center">
                            <a href="{{ route('documents.download', $doc) }}"
                               class="text-blue-600 hover:underline">
                                Télécharger
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-400 py-4">
                            Aucun document
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Actions --}}
    @if($rental->status === 'active')
        <form method="POST" action="{{ route('bailleur.rentals.cancel', $rental) }}"
              class="bg-red-50 border border-red-200 p-4 rounded-xl">
            @csrf

            <label class="block text-sm font-medium text-red-700 mb-2">
                Motif d’annulation (optionnel)
            </label>

            <textarea name="cancellation_reason"
                      class="w-full border rounded p-2 mb-3"
                      rows="3"></textarea>

            <button type="submit"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Annuler la location
            </button>
        </form>
    @endif

</div>
@endsection
