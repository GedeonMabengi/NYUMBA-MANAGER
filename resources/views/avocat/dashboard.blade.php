{{-- resources/views/avocat/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Tableau de bord - Avocat')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-tachometer-alt text-purple-600 mr-2"></i>Tableau de bord Avocat
    </h1>
    <p class="text-gray-600 mt-2">Bienvenue, Maître {{ auth()->user()->name }}</p>
</div>

{{-- Statistiques --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Clients bailleurs</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_bailleurs'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-building text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Biens suivis</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_properties'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="fas fa-file-contract text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Locations actives</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['active_rentals'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Clients bailleurs --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-users text-blue-600 mr-2"></i>Mes clients bailleurs
            </h2>
        </div>
        <div class="p-6">
            @if($bailleurs->isEmpty())
                <p class="text-gray-500 text-center py-4">Aucun client bailleur associé</p>
            @else
                <div class="space-y-4">
                    @foreach($bailleurs as $bailleur)
                        <a href="{{ route('avocat.bailleurs.show', $bailleur) }}" 
                           class="block p-4 border rounded-lg hover:bg-gray-50 transition">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $bailleur->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $bailleur->email }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm text-gray-600">
                                        {{ $bailleur->properties_count ?? 0 }} biens
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Événements récents --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-bell text-yellow-600 mr-2"></i>Événements récents
            </h2>
        </div>
        <div class="p-6">
            @if($recentEvents->isEmpty())
                <p class="text-gray-500 text-center py-4">Aucun événement récent</p>
            @else
                <div class="space-y-4">
                    @foreach($recentEvents as $event)
                        <div class="p-4 border rounded-lg 
                            {{ $event['type'] === 'rental_created' ? 'border-l-4 border-green-500' : 
                               ($event['type'] === 'rental_ended' ? 'border-l-4 border-red-500' : 'border-l-4 border-blue-500') }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @if($event['type'] === 'rental_created')
                                        <i class="fas fa-handshake text-green-500"></i>
                                    @elseif($event['type'] === 'rental_ended')
                                        <i class="fas fa-times-circle text-red-500"></i>
                                    @else
                                        <i class="fas fa-plus-circle text-blue-500"></i>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    @if($event['type'] === 'rental_created')
                                        <p class="text-gray-800">
                                            Nouvelle location : <strong>{{ $event['data']->property->name }}</strong>
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Locataire : {{ $event['data']->tenant->full_name }}
                                        </p>
                                    @elseif($event['type'] === 'rental_ended')
                                        <p class="text-gray-800">
                                            Fin de location : <strong>{{ $event['data']->property->name }}</strong>
                                        </p>
                                    @else
                                        <p class="text-gray-800">
                                            Nouveau bien : <strong>{{ $event['data']->name }}</strong>
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Par {{ $event['data']->owner->name }}
                                        </p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $event['date']->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection