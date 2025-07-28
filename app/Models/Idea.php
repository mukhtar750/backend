<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idea extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 
        'description',
        'problem_statement',
        'proposed_solution',
        'sector',
        'target_beneficiaries',
        'urgency_level',
        'related_sdgs',
        'tags',
        'user_id', 
        'status', 
        'upvotes', 
        'downvotes',
        'interest_count',
        'assigned_stakeholders',
        'admin_notes'
    ];

    protected $casts = [
        'related_sdgs' => 'array',
        'assigned_stakeholders' => 'array',
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

    public function interests()
    {
        return $this->hasMany(IdeaInterest::class);
    }

    // Helper methods for status
    public function isUnderReview() { return $this->status === 'under_review'; }
    public function isSelectedForIncubation() { return $this->status === 'selected_for_incubation'; }
    public function isInDevelopment() { return $this->status === 'in_development'; }
    public function isPiloted() { return $this->status === 'piloted'; }
    public function isArchived() { return $this->status === 'archived'; }
}
