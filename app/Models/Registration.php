<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'participant_id',
        'tickets_count',
        'registration_date',
        'additional_workshop',
        'food_preference',
        'subtotal',
        'discount_percentage',
        'discount_amount',
        'final_amount',
        'payment_status',
        'ticket_code',
    ];

    protected $casts = [
        'registration_date' => 'datetime',
        'additional_workshop' => 'boolean',
        'subtotal' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }
}