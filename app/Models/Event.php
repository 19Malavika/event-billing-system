<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'registration_start_date',
        'registration_end_date',
        'total_seats',
        'available_seats',
        'registration_fee',
        'workshop_fee',
        'food_fee',
        'status',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'registration_start_date' => 'datetime',
        'registration_end_date' => 'datetime',
        'registration_fee' => 'decimal:2',
        'workshop_fee' => 'decimal:2',
        'food_fee' => 'decimal:2',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}