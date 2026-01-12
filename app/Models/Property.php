<?php
// app/Models/Property.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'property_type_id',
        'user_id',
        'address',
        'city',
        'postal_code',
        'country',
        'is_for_rent',
        'status',
        'surface',
        'rooms',
    ];

    protected function casts(): array
    {
        return [
            'is_for_rent' => 'boolean',
            'surface' => 'decimal:2',
        ];
    }

    // Scopes
    public function scopeForRent($query)
    {
        return $query->where('is_for_rent', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeRented($query)
    {
        return $query->where('status', 'rented');
    }

    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Relations
    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function activeRental(): HasOne
    {
        return $this->hasOne(Rental::class)->where('status', 'active');
    }

    public function currentTenant()
    {
        $activeRental = $this->activeRental;
        return $activeRental ? $activeRental->tenant : null;
    }

    // Helpers
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->postal_code,
            $this->city,
            $this->country,
        ]);

        return implode(', ', $parts);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isRented(): bool
    {
        return $this->status === 'rented';
    }

    public function markAsRented(): void
    {
        $this->update(['status' => 'rented']);
    }

    public function markAsAvailable(): void
    {
        $this->update(['status' => 'available']);
    }
}