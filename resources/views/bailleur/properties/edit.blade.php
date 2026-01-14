@extends('layouts.app')

@section('title', 'Modifier ' . $property->name)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('bailleur.properties.show', $property) }}" class="text-indigo-600 hover:underline">
            <i class="fas fa-arrow-left mr-2"></i>Retour au bien
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fas fa-edit text-indigo-600 mr-2"></i>Modifier {{ $property->name }}
        </h1>

        <form action="{{ route('bailleur.properties.update', $property) }}" method="POST" id="propertyForm">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Nom du bien *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $property->name) }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="property_type_id" class="block text-gray-700 font-medium mb-2">Type de bien *</label>
                    <select name="property_type_id" id="property_type_id" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Sélectionnez un type</option>
                        @foreach($propertyTypes as $type)
                            <option value="{{ $type->id }}"
                                    data-requires-address="{{ $type->requires_address ? '1' : '0' }}"
                                    {{ old('property_type_id', $property->property_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('description', $property->description) }}</textarea>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="surface" class="block text-gray-700 font-medium mb-2">Surface (m²)</label>
                    <input type="number" step="0.01" name="surface" id="surface" value="{{ old('surface', $property->surface) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="rooms" class="block text-gray-700 font-medium mb-2">Nombre de pièces</label>
                    <input type="number" name="rooms" id="rooms" value="{{ old('rooms', $property->rooms) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            {{-- Adresse (conditionnel) --}}
            <div id="addressFields" class="mt-6 border-t pt-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">
                    <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>Localisation
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="address" class="block text-gray-700 font-medium mb-2">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $property->address) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="city" class="block text-gray-700 font-medium mb-2">Ville</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $property->city) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="country" class="block text-gray-700 font-medium mb-2">Pays</label>
                        <input type="text" name="country" id="country" value="{{ old('country', $property->country) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="mt-6 border-t pt-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_for_rent" value="1" {{ old('is_for_rent', $property->is_for_rent) ? 'checked' : '' }}
                           class="rounded text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-gray-700">Ce bien est destiné à la location</span>
                </label>
                <p class="text-sm text-gray-500 mt-1">
                    Si coché, vos avocats associés seront notifiés de la mise à jour de ce bien.
                </p>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('bailleur.properties.show', $property) }}"
                   class="px-6 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-save mr-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('property_type_id');
    const addressFields = document.getElementById('addressFields');
    const addressInputs = addressFields.querySelectorAll('input');

    function toggleAddressFields() {
        const selectedOption = typeSelect.options[typeSelect.selectedIndex];
        const requiresAddress = selectedOption.dataset.requiresAddress === '1';

        if (requiresAddress) {
            addressFields.style.display = 'block';
            document.getElementById('address').required = true;
            document.getElementById('city').required = true;
        } else {
            addressFields.style.display = 'block'; // Toujours afficher mais optionnel
            document.getElementById('address').required = false;
            document.getElementById('city').required = false;
        }
    }

    typeSelect.addEventListener('change', toggleAddressFields);
    toggleAddressFields();
});
</script>
@endpush
@endsection
