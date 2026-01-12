{{-- resources/views/bailleur/properties/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Mes biens')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-building text-indigo-600 mr-2"></i>Mes biens
    </h1>
    <a href="{{ route('bailleur.properties.create') }}" 
       class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
        <i class="fas fa-plus mr-2"></i>Ajouter un bien
    </a>
</div>

{{-- Filtres --}}
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form action="{{ route('bailleur.properties.index') }}" method="GET" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..."
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="w-48">
            <select name="type" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                <option value="">Tous les types</option>
                @foreach($propertyTypes as $type)
                    <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="w-48">
            <select name="status" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                <option value="">Tous les statuts</option>
                <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Disponible</option>
                <option value="rented" {{ request('status') === 'rented' ? 'selected' : '' }}>Loué</option>
                <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Indisponible</option>
            </select>
        </div>
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            <i class="fas fa-search mr-2"></i>Filtrer
        </button>
    </form>
</div>

{{-- Liste des biens --}}
<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($properties->isEmpty())
        <div class="p-8 text-center text-gray-500">
            <i class="fas fa-building text-4xl mb-4"></i>
            <p>Aucun bien trouvé</p>
            <a href="{{ route('bailleur.properties.create') }}" class="text-indigo-600 hover:underline mt-2 inline-block">
                Ajouter votre premier bien
            </a>
        </div>
    @else
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bien</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Localisation</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($properties as $property)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $property->name }}</div>
                            @if($property->surface)
                                <div class="text-sm text-gray-500">{{ $property->surface }} m²</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs bg-indigo-100 text-indigo-800 rounded-full">
                                {{ $property->propertyType->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($property->full_address)
                                <div class="text-sm text-gray-900">{{ $property->city }}</div>
                                <div class="text-sm text-gray-500">{{ $property->address }}</div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $property->status === 'available' ? 'bg-green-100 text-green-800' : 
                                   ($property->status === 'rented' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $property->status === 'available' ? 'Disponible' : 
                                   ($property->status === 'rented' ? 'Loué' : 'Indisponible') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($property->is_for_rent)
                                <span class="text-green-600"><i class="fas fa-check"></i> À louer</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('bailleur.properties.show', $property) }}" 
                               class="text-indigo-600 hover:text-indigo-900 mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('bailleur.properties.edit', $property) }}" 
                               class="text-yellow-600 hover:text-yellow-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($property->isAvailable() && $property->is_for_rent)
                                <a href="{{ route('bailleur.rentals.create', ['property_id' => $property->id]) }}" 
                                   class="text-green-600 hover:text-green-900 mr-3" title="Attribuer un locataire">
                                    <i class="fas fa-user-plus"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t">
            {{ $properties->links() }}
        </div>
    @endif
</div>
@endsection