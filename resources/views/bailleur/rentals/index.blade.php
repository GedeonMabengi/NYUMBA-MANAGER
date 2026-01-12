@extends('layouts.bailleur')

@section('title', 'Mes locations')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- En-tête --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Mes locations</h1>

        <a href="{{ route('bailleur.rentals.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Nouvelle location
        </a>
    </div>

    {{-- Filtres --}}
    <form method="GET" class="bg-white shadow rounded-xl p-4 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm text-gray-600">Statut</label>
            <select name="status" class="border rounded px-3 py-2">
                <option value="">Tous</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                    Annulée
                </option>
            </select>
        </div>

        <button type="submit"
                class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900">
            Filtrer
        </button>
    </form>

    {{-- Table --}}
    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Bien</th>
                    <th class="px-4 py-3">Locataire</th>
                    <th class="px-4 py-3">Début</th>
                    <th class="px-4 py-3">Loyer</th>
                    <th class="px-4 py-3">Statut</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">

                @forelse($rentals as $rental)
                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-3 font-medium">
                            {{ $rental->property->name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $rental->tenant->first_name }}
                            {{ $rental->tenant->last_name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $rental->start_date }}
                        </td>

                        <td class="px-4 py-3">
                            {{ number_format($rental->rent_amount, 2) }} $
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $rental->status === 'active'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($rental->status) }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <a href="{{ route('bailleur.rentals.show', $rental) }}"
                               class="text-blue-600 hover:underline text-sm">
                                Voir
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-400 py-6">
                            Aucune location trouvée
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div>
        {{ $rentals->links() }}
    </div>

</div>
@endsection
