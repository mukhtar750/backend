<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PitchEventParticipant extends Model
{
    protected $fillable = [
        'user_id',
        'pitch_event_id',
        'status',
        'registered_at',
    ];

    public function event()
    {
        return $this->belongsTo(PitchEvent::class, 'pitch_event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
