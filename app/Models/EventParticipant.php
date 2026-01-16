<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_event',
        'id_skema',
        'email',
        'invitation_status',
        'invitation_sent_at',
        'registered_at',
    ];

    protected $casts = [
        'invitation_sent_at' => 'datetime',
        'registered_at' => 'datetime',
    ];

    /**
     * Get the event that this participant belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    /**
     * Get the skema assigned to this participant.
     */
    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    /**
     * Get the user associated with this participant.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Scope a query to only include participants for a specific event.
     */
    public function scopeForEvent($query, string $eventId)
    {
        return $query->where('id_event', $eventId);
    }

    /**
     * Scope a query to only include participants for a specific skema.
     */
    public function scopeForSkema($query, string $skemaId)
    {
        return $query->where('id_skema', $skemaId);
    }

    /**
     * Scope a query to only include registered participants.
     */
    public function scopeRegistered($query)
    {
        return $query->where('invitation_status', 'registered');
    }

    /**
     * Scope a query to only include pending participants (pending or sent).
     */
    public function scopePending($query)
    {
        return $query->whereIn('invitation_status', ['pending', 'sent']);
    }
}
