<?php
// app/Http/Requests/StorePaymentRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'bailleur';
    }

    public function rules(): array
    {
        return [
            'rental_id' => [
                'required',
                'exists:rentals,id',
                function ($attribute, $value, $fail) {
                    $rental = \App\Models\Rental::with('property')->find($value);
                    if (!$rental || $rental->property->user_id !== auth()->id()) {
                        $fail('Cette location ne vous appartient pas.');
                    }
                },
            ],
            'payer_name' => 'required|string|max:255',
            'payer_phone' => 'nullable|string|max:20',
            'payer_email' => 'nullable|email|max:255',
            'amount' => 'required|numeric|min:0.01|max:9999999999.99',
            'payment_date' => 'required|date|before_or_equal:today',
            'payment_method' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'rental_id.required' => 'Veuillez sélectionner une location.',
            'rental_id.exists' => 'La location sélectionnée n\'existe pas.',
            'payer_name.required' => 'Le nom de celui qui paye est obligatoire.',
            'payer_name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'payer_email.email' => 'L\'adresse email n\'est pas valide.',
            'amount.required' => 'Le montant est obligatoire.',
            'amount.numeric' => 'Le montant doit être un nombre.',
            'amount.min' => 'Le montant doit être supérieur à 0.',
            'payment_date.required' => 'La date de paiement est obligatoire.',
            'payment_date.date' => 'La date de paiement n\'est pas valide.',
            'payment_date.before_or_equal' => 'La date de paiement ne peut pas être dans le futur.',
        ];
    }
}