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
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_user')
            ->withPivot('status', 'completed_at')
            ->withTimestamps();
    }
    
    /**
     * Get the primary assignee (for backward compatibility).
     * This will return the first assignee if any exist.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigner_id');
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
     * Get the user who assigned this task.
     */
    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigner_id');
    }
    
    /**
     * Check if the task is overdue.
     *
     * @return bool
     */
    public function isOverdue()
    {
        return $this->status !== 'completed' && $this->due_date < now();
    }
    
    /**
     * Get the status label for display.
     *
     * @return string
     */
    public function getStatusLabel()
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
    public function getPriorityLabel()
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
    public function getPriorityClass()
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
    public function getStatusClass()
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