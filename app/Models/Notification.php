<?php
// app/Models/Notification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
        'emailed_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'emailed_at' => 'datetime',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }
}