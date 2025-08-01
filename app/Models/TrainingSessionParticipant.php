<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSessionParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_session_id',
        'user_id',
        'registered_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    public function trainingSession()
    {
        return $this->belongsTo(TrainingSession::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}