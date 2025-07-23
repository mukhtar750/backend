<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class PracticePitch extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'file_path',
        'file_type',
        'feedback_requested',
        'status',
        'admin_feedback',
        'approved_by',
        'feedback',
        'reviewed_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
