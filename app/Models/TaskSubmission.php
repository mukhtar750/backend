<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    protected $fillable = [
        'task_id', 'user_id', 'file_path', 'notes', 'submitted_at', 'status', 'grade', 'feedback', 'reviewed_by', 'reviewed_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
