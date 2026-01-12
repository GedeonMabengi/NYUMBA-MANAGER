@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6 space-y-6">

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Bailleurs</p>
            <h2 class="text-3xl font-bold text-gray-800">{{ $stats['total_bailleurs'] }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Avocats</p>
            <h2 class="text-3xl font-bold text-gray-800">{{ $stats['total_avocats'] }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Biens</p>
            <h2 class="text-3xl font-bold text-gray-800">{{ $stats['total_properties'] }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Locations actives</p>
            <h2 class="text-3xl font-bold text-gray-800">{{ $stats['total_rentals'] }}</h2>
        </div>

    </div>

    {{-- Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Nouveaux bailleurs --}}
        <div class="bg-white rounded-xl shadow">
            <div class="border-b px-5 py-3 font-semibold text-gray-700">
                Nouveaux bailleurs
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-2">Nom</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Téléphone</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($recentBailleurs as $bailleur)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 font-medium">{{ $bailleur->name }}</td>
                                <td class="px-4 py-2">{{ $bailleur->email }}</td>
                                <td class="px-4 py-2">{{ $bailleur->phone ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-400">
                                    Aucun bailleur trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Nouveaux biens --}}
        <div class="bg-white rounded-xl shadow">
            <div class="border-b px-5 py-3 font-semibold text-gray-700">
                Nouveaux biens
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-2">Nom</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Propriétaire</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($recentProperties as $property)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 font-medium">{{ $property->name }}</td>
                                <td class="px-4 py-2">{{ $property->propertyType->name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $property->owner->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-400">
                                    Aucun bien trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
