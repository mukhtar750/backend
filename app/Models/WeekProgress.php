<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeekProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'entrepreneur_id',
        'week_id',
        'completion_percentage',
        'time_spent',
        'status',
        'notes',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'completion_percentage' => 'integer',
        'time_spent' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function module(): BelongsTo
    {
        return $this->belongsTo(TrainingModule::class, 'module_id');
    }

    public function entrepreneur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'entrepreneur_id');
    }

    public function week(): BelongsTo
    {
        return $this->belongsTo(ModuleWeek::class, 'week_id');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeNotStarted($query)
    {
        return $query->where('status', 'not_started');
    }

    // Helper methods
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isNotStarted(): bool
    {
        return $this->status === 'not_started';
    }

    public function markAsStarted()
    {
        if (!$this->started_at) {
            $this->started_at = now();
        }
        $this->status = 'in_progress';
        $this->save();
    }

    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->completion_percentage = 100;
        $this->completed_at = now();
        $this->save();
    }

    public function updateProgress($percentage, $timeSpent = null)
    {
        $this->completion_percentage = max(0, min(100, $percentage));
        
        if ($timeSpent !== null) {
            $this->time_spent = $timeSpent;
        }
        
        if ($this->completion_percentage >= 100) {
            $this->markAsCompleted();
        } elseif ($this->completion_percentage > 0) {
            $this->markAsStarted();
        }
        
        $this->save();
    }
}
