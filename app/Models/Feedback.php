<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'user_id',
        'target_type',
        'target_id',
        'category',
        'rating',
        'comments',
        'status',
    ];

    // The user who gave the feedback
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // The target of the feedback (platform, bdsp, mentor, training, etc.)
    public function target()
    {
        return $this->morphTo(null, 'target_type', 'target_id');
    }
}
