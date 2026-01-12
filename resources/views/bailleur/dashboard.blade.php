{{-- resources/views/bailleur/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Tableau de bord - Bailleur')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-tachometer-alt text-indigo-600 mr-2"></i>Tableau de bord
    </h1>
    <p class="text-gray-600 mt-2">Bienvenue, {{ auth()->user()->name }}</p>
</div>

{{-- Statistiques --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-building text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total biens</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_properties'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Disponibles</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['available_properties'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="fas fa-key text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Loués</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['rented_properties'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
                <i class="fas fa-users text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Locataires</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_tenants'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-indigo-100 rounded-full">
                <i class="fas fa-file-contract text-indigo-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Locations actives</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['active_rentals'] }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Actions rapides --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('bailleur.properties.create') }}" 
       class="bg-indigo-600 text-white rounded-lg p-6 hover:bg-indigo-700 transition flex items-center justify-center">
        <i class="fas fa-plus-circle text-2xl mr-3"></i>
        <span class="text-lg font-medium">Ajouter un bien</span>
    </a>
    <a href="{{ route('bailleur.rentals.create') }}" 
       class="bg-green-600 text-white rounded-lg p-6 hover:bg-green-700 transition flex items-center justify-center">
        <i class="fas fa-handshake text-2xl mr-3"></i>
        <span class="text-lg font-medium">Nouvelle location</span>
    </a>
    <a href="{{ route('payments.create') }}" 
       class="bg-green-600 text-white rounded-lg p-6 hover:bg-green-700 transition flex items-center justify-center">
        <i class="fas fa-plus-circle text-2xl mr-3"></i>
        <span class="text-lg font-medium">Ajouter un payment</span>
    </a>
    <a href="{{ route('bailleur.avocats.create') }}" 
       class="bg-purple-600 text-white rounded-lg p-6 hover:bg-purple-700 transition flex items-center justify-center">
        <i class="fas fa-user-tie text-2xl mr-3"></i>
        <span class="text-lg font-medium">Associer un avocat</span>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Biens récents --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-building text-indigo-600 mr-2"></i>Biens récents
            </h2>
        </div>
        <div class="p-6">
            @if($recentProperties->isEmpty())
                <p class="text-gray-500 text-center py-4">Aucun bien enregistré</p>
            @else
                <div class="space-y-4">
                    @foreach($recentProperties as $property)
                        <a href="{{ route('bailleur.properties.show', $property) }}" 
                           class="block p-4 border rounded-lg hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $property->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $property->propertyType->name }}</p>
                                    @if($property->full_address)
                                        <p class="text-sm text-gray-400">{{ $property->full_address }}</p>
                                    @endif
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $property->status === 'available' ? 'bg-green-100 text-green-800' : 
                                       ($property->status === 'rented' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ $property->status === 'available' ? 'Disponible' : 
                                       ($property->status === 'rented' ? 'Loué' : 'Indisponible') }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Locations actives --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-file-contract text-green-600 mr-2"></i>Locations actives
            </h2>
        </div>
        <div class="p-6">
            @if($activeRentals->isEmpty())
                <p class="text-gray-500 text-center py-4">Aucune location active</p>
            @else
                <div class="space-y-4">
                    @foreach($activeRentals as $rental)
                        <a href="{{ route('bailleur.rentals.show', $rental) }}" 
                           class="block p-4 border rounded-lg hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $rental->property->name }}</h3>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-user mr-1"></i>{{ $rental->tenant->full_name }}
                                    </p>
                                    <p class="text-sm text-gray-400">
                                        Depuis le {{ $rental->start_date->format('d/m/Y') }}
                                    </p>
                                </div>
                                <span class="text-indigo-600 font-medium">
                                    {{ number_format($rental->rent_amount, 0, ',', ' ') }} €/mois
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Avocats associés --}}
@if($avocats->isNotEmpty())
<div class="mt-8 bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-user-tie text-purple-600 mr-2"></i>Mes avocats
        </h2>
    </div>
    <div class="p-6">
        <div class="flex flex-wrap gap-4">
            @foreach($avocats as $avocat)
                <div class="flex items-center bg-gray-50 rounded-lg p-4">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-tie text-purple-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-gray-800">{{ $avocat->name }}</p>
                        <p class="text-sm text-gray-500">{{ $avocat->email }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection