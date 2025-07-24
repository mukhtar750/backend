<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idea extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'user_id', 'status', 'upvotes', 'downvotes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function pitches()
    {
        return $this->hasMany(Pitch::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
