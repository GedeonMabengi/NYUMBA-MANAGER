@extends('layouts.bailleur')

@section('title', 'Mes locataires')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- En-tête --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Mes locataires</h1>

        <a href="{{ route('bailleur.tenants.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Nouveau locataire
        </a>
    </div>

    {{-- Recherche --}}
    <form method="GET" class="bg-white shadow rounded-xl p-4 flex flex-wrap gap-4 items-end">
        <div class="flex-1">
            <label class="block text-sm text-gray-600">Recherche</label>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Nom, email, téléphone..."
                   class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit"
                class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900">
            Rechercher
        </button>
    </form>

    {{-- Table --}}
    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Nom</th>
                    <th class="px-4 py-3">Téléphone</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Locations actives</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">

                @forelse($tenants as $tenant)
                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-3 font-medium">
                            {{ $tenant->first_name }} {{ $tenant->last_name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $tenant->phone }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $tenant->email ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $tenant->activeRentals->count() }}
                        </td>

                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('bailleur.tenants.show', $tenant) }}"
                               class="text-blue-600 hover:underline text-sm">
                                Voir
                            </a>

                            <a href="{{ route('bailleur.tenants.edit', $tenant) }}"
                               class="text-yellow-600 hover:underline text-sm">
                                Modifier
                            </a>

                            <form action="{{ route('bailleur.tenants.destroy', $tenant) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Supprimer ce locataire ?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-red-600 hover:underline text-sm">
                                    Supprimer
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-400 py-6">
                            Aucun locataire trouvé
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div>
        {{ $tenants->links() }}
    </div>

</div>
@endsection
