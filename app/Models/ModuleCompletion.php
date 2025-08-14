<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'entrepreneur_id',
        'bdsp_id',
        'status',
        'current_week',
        'progress_percentage',
        'completion_notes',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'current_week' => 'integer',
        'progress_percentage' => 'integer',
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

    public function bdsp(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bdsp_id');
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

    public function markAsStarted(): void
    {
        $this->update([
            'status' => 'in_progress',
            'started_at' => now(),
            'current_week' => 1,
            'progress_percentage' => 0,
        ]);
    }

    public function markAsCompleted(string $notes = null): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress_percentage' => 100,
            'completion_notes' => $notes,
        ]);
    }

    public function updateProgress(int $week, int $percentage): void
    {
        $this->update([
            'current_week' => $week,
            'progress_percentage' => $percentage,
            'status' => $percentage >= 100 ? 'completed' : 'in_progress',
        ]);

        if ($percentage >= 100 && !$this->completed_at) {
            $this->update(['completed_at' => now()]);
        }
    }

    public function reopenModule(): void
    {
        $this->update([
            'status' => 'in_progress',
            'completed_at' => null,
            'progress_percentage' => 0,
        ]);
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

    public function scopeByBdsp($query, $bdspId)
    {
        return $query->where('bdsp_id', $bdspId);
    }

    public function scopeByEntrepreneur($query, $entrepreneurId)
    {
        return $query->where('entrepreneur_id', $entrepreneurId);
    }
}
