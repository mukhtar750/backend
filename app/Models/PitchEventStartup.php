<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PitchEventStartup extends Model
{
    public function event()
    {
        return $this->belongsTo(PitchEvent::class, 'pitch_event_id');
    }

    public function startup()
    {
        return $this->belongsTo(Startup::class, 'startup_id');
    }
}
