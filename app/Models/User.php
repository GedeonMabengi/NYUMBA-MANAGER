<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Scopes
    public function scopeBailleurs($query)
    {
        return $query->where('role', 'bailleur');
    }

    public function scopeAvocats($query)
    {
        return $query->where('role', 'avocat');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // Relations
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }

    // Relations pour bailleur
    public function avocats(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bailleur_avocat', 'bailleur_id', 'avocat_id')
                    ->withPivot('is_active')
                    ->withTimestamps();
    }

    // Relations pour avocat
    public function bailleurs(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bailleur_avocat', 'avocat_id', 'bailleur_id')
                    ->withPivot('is_active')
                    ->withTimestamps();
    }

    public function uploadedDocuments(): HasMany
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    // Helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBailleur(): bool
    {
        return $this->role === 'bailleur';
    }

    public function isAvocat(): bool
    {
        return $this->role === 'avocat';
    }

    public function getActiveAvocats()
    {
        return $this->avocats()->wherePivot('is_active', true)->get();
    }

    /**
        * Les paiements enregistrés par ce bailleur
    */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

}