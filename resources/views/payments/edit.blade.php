{{-- resources/views/payments/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Modifier le paiement ' . $payment->reference)

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- En-tête -->
    <div class="mb-6">
        <a href="{{ route('payments.show', $payment) }}" class="text-gray-600 hover:text-gray-900 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux détails
        </a>
        <h1 class="text-2xl font-bold text-gray-900">
            <i class="fas fa-edit mr-2 text-yellow-500"></i>
            Modifier le paiement
        </h1>
        <p class="text-gray-600 mt-1">Référence: <span class="font-mono">{{ $payment->reference }}</span></p>
    </div>

    <!-- Formulaire -->
    <form action="{{ route('payments.update', $payment) }}" method="POST" class="bg-white rounded-lg shadow-lg overflow-hidden">
        @csrf
        @method('PUT')

        <div class="p-6 space-y-6">
            <!-- Section Bailleur (lecture seule) -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user-tie mr-2"></i>Bailleur
                </h3>
                <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</p>
            </div>

            <!-- Location (lecture seule) -->
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                <h3 class="text-sm font-medium text-blue-600 mb-2">
                    <i class="fas fa-file-contract mr-2"></i>Location concernée
                </h3>
                <p class="text-lg font-semibold text-gray-900">
                    {{ $payment->rental->property->name }}
                </p>
                <p class="text-sm text-gray-600">
                    Locataire: {{ $payment->rental->tenant->first_name }} {{ $payment->rental->tenant->last_name }}
                </p>
                <p class="text-xs text-blue-600 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    La location ne peut pas être modifiée. Créez un nouveau paiement si nécessaire.
                </p>
            </div>

            <!-- Nom du payeur -->
            <div>
                <label for="payer_name" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-user mr-1 text-gray-400"></i>
                    Nom de celui qui paye <span class="text-red-500">*</span>
                </label>
                <input type="text" name="payer_name" id="payer_name" 
                       value="{{ old('payer_name', $payment->payer_name) }}" required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('payer_name') border-red-500 @enderror">
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
                    <input type="tel" name="payer_phone" id="payer_phone" 
                           value="{{ old('payer_phone', $payment->payer_phone) }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>
                <div>
                    <label for="payer_email" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-envelope mr-1 text-gray-400"></i>
                        Email du payeur
                    </label>
                    <input type="email" name="payer_email" id="payer_email" 
                           value="{{ old('payer_email', $payment->payer_email) }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
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
                        <input type="number" name="amount" id="amount" 
                               value="{{ old('amount', $payment->amount) }}" required
                               step="0.01" min="0.01"
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
                           value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" required
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
                        <option value="{{ $value }}" {{ old('payment_method', $payment->payment_method) == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Statut -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-check-circle mr-1 text-gray-400"></i>
                    Statut
                </label>
                <select name="status" id="status"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="confirmed" {{ old('status', $payment->status) == 'confirmed' ? 'selected' : '' }}>
                        Confirmé
                    </option>
                    <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>
                        En attente
                    </option>
                    <option value="cancelled" {{ old('status', $payment->status) == 'cancelled' ? 'selected' : '' }}>
                        Annulé
                    </option>
                </select>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-sticky-note mr-1 text-gray-400"></i>
                    Notes / Commentaires
                </label>
                <textarea name="notes" id="notes" rows="3"
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('notes', $payment->notes) }}</textarea>
            </div>
        </div>

        <!-- Boutons -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
            <a href="{{ route('payments.show', $payment) }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-md transition-colors">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                <i class="fas fa-save mr-2"></i>
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection