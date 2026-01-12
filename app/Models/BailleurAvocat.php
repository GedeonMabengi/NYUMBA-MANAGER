<?php
// app/Models/BailleurAvocat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BailleurAvocat extends Model
{
    use HasFactory;

    protected $table = 'bailleur_avocat';

    protected $fillable = [
        'bailleur_id',
        'avocat_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function bailleur()
    {
        return $this->belongsTo(User::class, 'bailleur_id');
    }

    public function avocat()
    {
        return $this->belongsTo(User::class, 'avocat_id');
    }
}