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
}
