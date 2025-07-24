<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorshipSession extends Model
{
    protected $fillable = [
        'pairing_id',
        'scheduled_by',
        'scheduled_for',
        'date_time',
        'duration',
        'topic',
        'status',
        'notes',
        'meeting_link',
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function pairing()
    {
        return $this->belongsTo(Pairing::class);
    }

    public function scheduledBy()
    {
        return $this->belongsTo(User::class, 'scheduled_by');
    }

    public function scheduledFor()
    {
        return $this->belongsTo(User::class, 'scheduled_for');
    }

    public function getMenteeAttribute()
    {
        // If the mentor is scheduled_by, mentee is scheduled_for, and vice versa
        // But we need to determine which is the mentee based on the pairing type
        if (!$this->relationLoaded('pairing')) {
            $this->load('pairing.userOne', 'pairing.userTwo');
        }
        // If pairing_type is mentor_mentee or mentor_entrepreneur, mentee is the non-mentor
        if ($this->pairing && in_array($this->pairing->pairing_type, ['mentor_mentee', 'mentor_entrepreneur'])) {
            // If scheduled_by is the mentor, scheduled_for is the mentee
            if ($this->pairing->userOne && $this->pairing->userTwo) {
                // Heuristic: mentor is the current user (from dashboard), so mentee is the other
                // But since we don't have the current user here, fallback to scheduled_for
                return $this->scheduledFor;
            }
        }
        // Fallback: return scheduled_for
        return $this->scheduledFor;
    }
}
