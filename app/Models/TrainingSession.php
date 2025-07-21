<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date_time',
        'duration',
        'trainer',
        'target_roles',
        'meeting_link',
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];
}
