<?php
// app/Models/PropertyType.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PropertyType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'requires_address',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'requires_address' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($propertyType) {
            if (empty($propertyType->slug)) {
                $propertyType->slug = Str::slug($propertyType->name);
            }
        });

        static::updating(function ($propertyType) {
            if ($propertyType->isDirty('name')) {
                $propertyType->slug = Str::slug($propertyType->name);
            }
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRequiresAddress($query)
    {
        return $query->where('requires_address', true);
    }

    // Relations
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    // Helpers
    public function isImmobilier(): bool
    {
        return $this->requires_address;
    }

    public function isMobilier(): bool
    {
        return !$this->requires_address;
    }
}