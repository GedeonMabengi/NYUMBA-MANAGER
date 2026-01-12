<?php
// app/Http/Requests/UpdatePaymentRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $payment = $this->route('payment');
        return auth()->check() && 
               auth()->user()->role === 'bailleur' && 
               $payment->user_id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'payer_name' => 'required|string|max:255',
            'payer_phone' => 'nullable|string|max:20',
            'payer_email' => 'nullable|email|max:255',
            'amount' => 'required|numeric|min:0.01|max:9999999999.99',
            'payment_date' => 'required|date|before_or_equal:today',
            'payment_method' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'status' => 'nullable|in:pending,confirmed,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'payer_name.required' => 'Le nom de celui qui paye est obligatoire.',
            'amount.required' => 'Le montant est obligatoire.',
            'amount.numeric' => 'Le montant doit être un nombre.',
            'payment_date.required' => 'La date de paiement est obligatoire.',
            'payment_date.before_or_equal' => 'La date de paiement ne peut pas être dans le futur.',
        ];
    }
}