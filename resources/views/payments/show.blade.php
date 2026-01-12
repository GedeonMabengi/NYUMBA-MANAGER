{{-- resources/views/payments/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Paiement ' . $payment->reference)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- En-tête -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <a href="{{ route('payments.index') }}" class="text-gray-600 hover:text-gray-900 mb-2 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux paiements
            </a>
            <h1 class="text-2xl font-bold text-gray-900">
                <i class="fas fa-receipt mr-2 text-green-600"></i>
                Paiement {{ $payment->reference }}
            </h1>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('payments.print', $payment) }}" target="_blank" 
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-print mr-2"></i>
                Imprimer reçu
            </a>
            <a href="{{ route('payments.receipt', $payment) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-file-pdf mr-2"></i>
                Télécharger PDF
            </a>
            <a href="{{ route('payments.edit', $payment) }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-edit mr-2"></i>
                Modifier
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Statut -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <span class="text-sm text-gray-500">Statut du paiement</span>
            @switch($payment->status)
                @case('confirmed')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-2"></i> Confirmé
                    </span>
                    @break
                @case('pending')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-2"></i> En attente
                    </span>
                    @break
                @case('cancelled')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <i class="fas fa-times-circle mr-2"></i> Annulé
                    </span>
                    @break
            @endswitch
        </div>

        <!-- Montant principal -->
        <div class="px-6 py-8 bg-gradient-to-r from-green-500 to-green-600 text-white text-center">
            <p class="text-sm opacity-90">Montant payé</p>
            <p class="text-4xl font-bold">{{ $payment->formatted_amount }}</p>
            <p class="text-sm opacity-90 mt-2">
                <i class="fas fa-calendar-alt mr-1"></i>
                {{ $payment->payment_date->format('d F Y') }}
            </p>
        </div>

        <!-- Informations détaillées -->
        <div class="p-6 space-y-6">
            <!-- Bailleur -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-500 mb-2">
                    <i class="fas fa-user-tie mr-2"></i>Bailleur
                </h3>
                <p class="text-lg font-semibold text-gray-900">{{ $payment->user->name }}</p>
                <p class="text-sm text-gray-600">{{ $payment->user->email }}</p>
            </div>

            <!-- Bien et Locataire -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-50 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-blue-600 mb-2">
                        <i class="fas fa-home mr-2"></i>Bien concerné
                    </h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $payment->rental->property->name }}</p>
                    <p class="text-sm text-gray-600">
                        {{ $payment->rental->property->address }}<br>
                        {{ $payment->rental->property->postal_code }} {{ $payment->rental->property->city }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-tag mr-1"></i>{{ $payment->rental->property->propertyType->name ?? 'N/A' }}
                    </p>
                </div>

                <div class="bg-purple-50 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-purple-600 mb-2">
                        <i class="fas fa-user mr-2"></i>Locataire
                    </h3>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $payment->rental->tenant->first_name }} {{ $payment->rental->tenant->last_name }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-phone mr-1"></i>{{ $payment->rental->tenant->phone ?? 'N/A' }}<br>
                        <i class="fas fa-envelope mr-1"></i>{{ $payment->rental->tenant->email ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Payeur -->
            <div class="bg-orange-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-orange-600 mb-2">
                    <i class="fas fa-hand-holding-usd mr-2"></i>Payeur
                </h3>
                <p class="text-lg font-semibold text-gray-900">{{ $payment->payer_name }}</p>
                <div class="text-sm text-gray-600 mt-1">
                    @if($payment->payer_phone)
                        <p><i class="fas fa-phone mr-1"></i>{{ $payment->payer_phone }}</p>
                    @endif
                    @if($payment->payer_email)
                        <p><i class="fas fa-envelope mr-1"></i>{{ $payment->payer_email }}</p>
                    @endif
                </div>
                @if($payment->payer_name !== ($payment->rental->tenant->first_name . ' ' . $payment->rental->tenant->last_name))
                    <p class="text-xs text-orange-600 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Le payeur est différent du locataire
                    </p>
                @endif
            </div>

            <!-- Détails du paiement -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Détails du paiement</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Référence</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $payment->reference }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date de paiement</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $payment->payment_date->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Méthode de paiement</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @php
                                $methods = [
                                    'cash' => 'Espèces',
                                    'bank_transfer' => 'Virement bancaire',
                                    'check' => 'Chèque',
                                    'card' => 'Carte bancaire',
                                    'mobile_money' => 'Mobile Money',
                                    'other' => 'Autre',
                                ];
                            @endphp
                            {{ $methods[$payment->payment_method] ?? $payment->payment_method ?? 'Non spécifié' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Enregistré le</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $payment->created_at->format('d/m/Y à H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Notes -->
            @if($payment->notes)
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Notes</h3>
                    <p class="text-gray-600 bg-gray-50 rounded-lg p-4">{{ $payment->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Actions en bas -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
            <form action="{{ route('payments.destroy', $payment) }}" method="POST" 
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                    <i class="fas fa-trash mr-1"></i>
                    Supprimer ce paiement
                </button>
            </form>
            <a href="{{ route('payments.edit', $payment) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-edit mr-1"></i>
                Modifier
            </a>
        </div>
    </div>
</div>
@endsection