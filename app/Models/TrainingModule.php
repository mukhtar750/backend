<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'bdsp_id',
        'title',
        'description',
        'duration_weeks',
        'total_hours',
        'status',
        'target_audience',
        'prerequisites',
        'learning_objectives',
        'admin_reviewed',
        'admin_reviewed_at',
        'admin_reviewed_by',
        'admin_notes',
    ];

    protected $casts = [
        'admin_reviewed' => 'boolean',
        'admin_reviewed_at' => 'datetime',
        'duration_weeks' => 'integer',
        'total_hours' => 'integer',
    ];

    // Relationships
    public function bdsp(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bdsp_id');
    }

    public function adminReviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_reviewed_by');
    }

    public function weeks(): HasMany
    {
        return $this->hasMany(ModuleWeek::class, 'module_id')->orderBy('week_number');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(WeekProgress::class, 'module_id');
    }

    // Training Module relationships
    public function createdModules()
    {
        return $this->hasMany(TrainingModule::class, 'bdsp_id');
    }

    public function moduleProgress()
    {
        return $this->hasMany(WeekProgress::class, 'entrepreneur_id');
    }

    public function getAccessibleModules()
    {
        if ($this->role === 'entrepreneur') {
            // Get modules from paired BDSPs
            $pairedBdspIds = $this->getPairedProfessionalIds();
            return TrainingModule::whereIn('bdsp_id', $pairedBdspIds)
                ->where('status', 'published')
                ->with(['weeks', 'bdsp'])
                ->get();
        }
        return collect();
    }

    public function getModuleProgress($moduleId)
    {
        if ($this->role === 'entrepreneur') {
            return $this->moduleProgress()
                ->where('module_id', $moduleId)
                ->with(['week', 'module'])
                ->get();
        }
        return collect();
    }

    // Module completion relationships
    public function completions()
    {
        return $this->hasMany(ModuleCompletion::class, 'module_id');
    }

    public function getCompletionForEntrepreneur($entrepreneurId)
    {
        return $this->completions()
            ->where('entrepreneur_id', $entrepreneurId)
            ->first();
    }

    public function getEnrolledEntrepreneurs()
    {
        return $this->completions()
            ->with('entrepreneur')
            ->get()
            ->pluck('entrepreneur');
    }

    public function getCompletionStats()
    {
        $total = $this->completions()->count();
        $completed = $this->completions()->completed()->count();
        $inProgress = $this->completions()->inProgress()->count();
        $notStarted = $this->completions()->notStarted()->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'in_progress' => $inProgress,
            'not_started' => $notStarted,
            'completion_rate' => $total > 0 ? round(($completed / $total) * 100, 1) : 0,
        ];
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByBdsp($query, $bdspId)
    {
        return $query->where('bdsp_id', $bdspId);
    }

    public function scopeAdminReviewed($query)
    {
        return $query->where('admin_reviewed', true);
    }

    // Helper methods
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }

    public function getProgressForEntrepreneur($entrepreneurId)
    {
        return $this->completions()
            ->where('entrepreneur_id', $entrepreneurId)
            ->first();
    }

    public function getOverallProgressForEntrepreneur($entrepreneurId)
    {
        $completion = $this->getProgressForEntrepreneur($entrepreneurId);
        if (!$completion) {
            return 0;
        }
        
        return $completion->progress_percentage;
    }
}
