<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rental_id',
        'user_id',
        'payer_name',
        'payer_phone',
        'payer_email',
        'amount',
        'payment_date',
        'payment_method',
        'reference',
        'notes',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * Génère une référence unique pour le paiement
     */
    public static function generateReference(): string
    {
        $prefix = 'PAY';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        return "{$prefix}-{$date}-{$random}";
    }

    /**
     * La location associée au paiement
     */
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    /**
     * Le bailleur qui a enregistré le paiement
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alias pour le bailleur
     */
    public function bailleur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accès direct au locataire via la location
     */
    public function getTenantAttribute()
    {
        return $this->rental?->tenant;
    }

    /**
     * Accès direct au bien via la location
     */
    public function getPropertyAttribute()
    {
        return $this->rental?->property;
    }

    /**
     * Formatte le montant avec la devise
     */
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2, ',', ' ') . ' €';
    }

    /**
     * Scope pour les paiements d'un bailleur
     */
    public function scopeForBailleur($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope pour les paiements confirmés
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope pour les paiements d'une période
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }
}