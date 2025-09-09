<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'assigner_id',
        'due_date',
        'priority',
        'status',
        'completed_at',
    ];
    
    /**
     * The users assigned to this task.
     */
    /**
     * The users assigned to this task (many-to-many)
     */
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id')
            ->withPivot('status', 'completed_at')
            ->withTimestamps()
            ->using('App\Models\Pivots\TaskUser');
    }
    
    /**
     * The user who created/assigned the task
     */
    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigner_id');
    }
    
    /**
     * For backward compatibility - gets the first assignee
     */
    public function getAssigneeAttribute()
    {
        return $this->assignees->first();
    }
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
    ];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['assigner', 'assignees'];
    
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_overdue', 'status_label', 'priority_label', 'priority_class', 'status_class'];
    
    /**
     * Check if the task is overdue.
     *
     * @return bool
     */
    public function getIsOverdueAttribute()
    {
        return $this->status !== 'completed' && $this->due_date && $this->due_date->isPast();
    }
    
    /**
     * Get the status label for display.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }
    
    /**
     * Get the priority label for display.
     *
     * @return string
     */
    public function getPriorityLabelAttribute()
    {
        return match($this->priority) {
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            default => ucfirst($this->priority),
        };
    }
    
    /**
     * Get the CSS class for the priority badge.
     *
     * @return string
     */
    public function getPriorityClassAttribute()
    {
        return match($this->priority) {
            'low' => 'bg-blue-100 text-blue-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'high' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
    
    /**
     * Get the CSS class for the status badge.
     *
     * @return string
     */
    public function getStatusClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-gray-100 text-gray-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }
}