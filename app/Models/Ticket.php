<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'agent_id',
        'title',
        'category',
        'priority',
        'status',
        'first_response_at',
        'sla_breached',
    ];

    protected $casts = [
        'first_response_at' => 'datetime',
        'sla_breached' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }

    // SLA kontrolü için yardımcı fonksiyon
    public function isSlaBreached(): bool
    {
        if ($this->priority !== 'high' || $this->first_response_at) {
            return false;
        }

        return $this->created_at->diffInHours(now()) >= 2;
    }
}