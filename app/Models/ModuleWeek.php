<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModuleWeek extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'week_number',
        'title',
        'topics',
        'hours_required',
        'learning_materials',
        'week_objectives',
        'order',
    ];

    protected $casts = [
        'week_number' => 'integer',
        'hours_required' => 'integer',
        'order' => 'integer',
    ];

    // Relationships
    public function module(): BelongsTo
    {
        return $this->belongsTo(TrainingModule::class, 'module_id');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(WeekProgress::class, 'week_id');
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('week_number');
    }

    // Helper methods
    public function isCompletedByEntrepreneur($entrepreneurId): bool
    {
        return $this->progress()
            ->where('entrepreneur_id', $entrepreneurId)
            ->where('status', 'completed')
            ->exists();
    }

    public function getProgressForEntrepreneur($entrepreneurId)
    {
        return $this->progress()
            ->where('entrepreneur_id', $entrepreneurId)
            ->first();
    }

    public function getCompletionPercentageForEntrepreneur($entrepreneurId): int
    {
        $progress = $this->getProgressForEntrepreneur($entrepreneurId);
        return $progress ? $progress->completion_percentage : 0;
    }

    public function getTimeSpentByEntrepreneur($entrepreneurId): int
    {
        $progress = $this->getProgressForEntrepreneur($entrepreneurId);
        return $progress ? $progress->time_spent : 0;
    }
}
