<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdeaInterest extends Model
{
    protected $fillable = [
        'idea_id',
        'user_id',
        'message',
        'status'
    ];

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
