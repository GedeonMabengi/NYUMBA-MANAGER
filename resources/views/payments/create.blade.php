{{-- resources/views/payments/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Nouveau paiement')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- En-tête -->
    <div class="mb-6">
        <a href="{{ route('payments.index') }}" class="text-gray-600 hover:text-gray-900 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux paiements
        </a>
        <h1 class="text-2xl font-bold text-gray-900">
            <i class="fas fa-plus-circle mr-2 text-green-600"></i>
            Enregistrer un paiement
        </h1>
        <p class="text-gray-600 mt-1">Remplissez les informations du paiement reçu</p>
    </div>

    <!-- Formulaire -->
    <form action="{{ route('payments.store') }}" method="POST" class="bg-white rounded-lg shadow-lg overflow-hidden">
        @csrf

        <div class="p-6 space-y-6">
            <!-- Section Bailleur -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user-tie mr-2"></i>Bailleur
                </h3>
                <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
            </div>

            <!-- Sélection de la location -->
            <div>
                <label for="rental_id" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-file-contract mr-1 text-gray-400"></i>
                    Location concernée <span class="text-red-500">*</span>
                </label>
                <select name="rental_id" id="rental_id" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('rental_id') border-red-500 @enderror">
                    <option value="">-- Sélectionnez une location --</option>
                    @foreach($rentals as $rental)
                        <option value="{{ $rental->id }}" 
                                {{ (old('rental_id', $selectedRental?->id) == $rental->id) ? 'selected' : '' }}
                                data-tenant="{{ $rental->tenant->first_name }} {{ $rental->tenant->last_name }}"
                                data-rent="{{ $rental->rent_amount }}">
                            {{ $rental->property->name }} - {{ $rental->tenant->first_name }} {{ $rental->tenant->last_name }}
                            ({{ number_format($rental->rent_amount, 2, ',', ' ') }} €/mois)
                        </option>
                    @endforeach
                </select>
                @error('rental_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Informations affichées après sélection -->
            <div id="rental-info" class="hidden bg-blue-50 rounded-lg p-4 border border-blue-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-blue-600 font-medium">Locataire</p>
                        <p id="tenant-name" class="text-gray-900">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-blue-600 font-medium">Loyer mensuel</p>
                        <p id="rent-amount" class="text-gray-900">-</p>
                    </div>
                </div>
            </div>

            <!-- Nom du payeur -->
            <div>
                <label for="payer_name" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-user mr-1 text-gray-400"></i>
                    Nom de celui qui paye <span class="text-red-500">*</span>
                </label>
                <input type="text" name="payer_name" id="payer_name" value="{{ old('payer_name') }}" required
                       placeholder="Ex: Jean Dupont"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('payer_name') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Peut être différent du locataire (ex: parent, garant, etc.)</p>
                @error('payer_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contact du payeur -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="payer_phone" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-phone mr-1 text-gray-400"></i>
                        Téléphone du payeur
                    </label>
                    <input type="tel" name="payer_phone" id="payer_phone" value="{{ old('payer_phone') }}"
                           placeholder="Ex: 06 12 34 56 78"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('payer_phone') border-red-500 @enderror">
                    @error('payer_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="payer_email" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-envelope mr-1 text-gray-400"></i>
                        Email du payeur
                    </label>
                    <input type="email" name="payer_email" id="payer_email" value="{{ old('payer_email') }}"
                           placeholder="Ex: jean@email.com"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('payer_email') border-red-500 @enderror">
                    @error('payer_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Montant et Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-euro-sign mr-1 text-gray-400"></i>
                        Montant payé <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required
                               step="0.01" min="0.01" placeholder="0.00"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 pr-12 @error('amount') border-red-500 @enderror">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500">€</span>
                        </div>
                    </div>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                        Date du paiement <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="payment_date" id="payment_date" 
                           value="{{ old('payment_date', date('Y-m-d')) }}" required
                           max="{{ date('Y-m-d') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('payment_date') border-red-500 @enderror">
                    @error('payment_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Méthode de paiement -->
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-credit-card mr-1 text-gray-400"></i>
                    Méthode de paiement
                </label>
                <select name="payment_method" id="payment_method"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="">-- Sélectionnez une méthode --</option>
                    @foreach($paymentMethods as $value => $label)
                        <option value="{{ $value }}" {{ old('payment_method') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-sticky-note mr-1 text-gray-400"></i>
                    Notes / Commentaires
                </label>
                <textarea name="notes" id="notes" rows="3"
                          placeholder="Informations complémentaires..."
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Boutons -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
            <a href="{{ route('payments.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-md transition-colors">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                <i class="fas fa-save mr-2"></i>
                Enregistrer le paiement
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rentalSelect = document.getElementById('rental_id');
    const rentalInfo = document.getElementById('rental-info');
    const tenantName = document.getElementById('tenant-name');
    const rentAmount = document.getElementById('rent-amount');
    const payerNameInput = document.getElementById('payer_name');
    const amountInput = document.getElementById('amount');

    function updateRentalInfo() {
        const selectedOption = rentalSelect.options[rentalSelect.selectedIndex];
        
        if (selectedOption.value) {
            const tenant = selectedOption.dataset.tenant;
            const rent = selectedOption.dataset.rent;
            
            tenantName.textContent = tenant;
            rentAmount.textContent = parseFloat(rent).toLocaleString('fr-FR', { minimumFractionDigits: 2 }) + ' €';
            rentalInfo.classList.remove('hidden');
            
            // Pré-remplir le nom du payeur avec le nom du locataire si vide
            if (!payerNameInput.value) {
                payerNameInput.value = tenant;
            }
            
            // Pré-remplir le montant avec le loyer si vide
            if (!amountInput.value) {
                amountInput.value = rent;
            }
        } else {
            rentalInfo.classList.add('hidden');
        }
    }

    rentalSelect.addEventListener('change', updateRentalInfo);
    
    // Initialiser si une valeur est déjà sélectionnée
    if (rentalSelect.value) {
        updateRentalInfo();
    }
});
</script>
@endpush
@endsection