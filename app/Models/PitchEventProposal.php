<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PitchEventProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'investor_id',
        'title',
        'description',
        'event_type',
        'target_sector',
        'target_stage',
        'target_criteria',
        'max_participants',
        'min_funding_needed',
        'max_funding_needed',
        'expected_outcomes',
        'success_metrics',
        'proposed_format',
        'supporting_rationale',
        'proposed_date',
        'proposed_time',
        'proposed_duration',
        'proposed_location',
        'is_virtual',
        'virtual_platform',
        'additional_requirements',
        'status',
        'admin_feedback',
        'reviewed_by',
        'reviewed_at',
        'approved_event_id',
    ];

    protected $casts = [
        'proposed_date' => 'date',
        'proposed_time' => 'datetime',
        'is_virtual' => 'boolean',
        'reviewed_at' => 'datetime',
        'min_funding_needed' => 'decimal:2',
        'max_funding_needed' => 'decimal:2',
    ];

    // Relationships
    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'investor_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approvedEvent(): BelongsTo
    {
        return $this->belongsTo(PitchEvent::class, 'approved_event_id');
    }

    // Helper methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isRequestedChanges(): bool
    {
        return $this->status === 'requested_changes';
    }

    public function canBeReviewed(): bool
    {
        return $this->isPending() || $this->isRequestedChanges();
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'requested_changes' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getEventTypeLabel(): string
    {
        return match($this->event_type) {
            'pitch_competition' => 'Pitch Competition',
            'networking' => 'Networking Event',
            'demo_day' => 'Demo Day',
            'workshop' => 'Workshop',
            default => ucfirst(str_replace('_', ' ', $this->event_type)),
        };
    }

    public function getTargetStageLabel(): string
    {
        return match($this->target_stage) {
            'seed' => 'Seed Stage',
            'series_a' => 'Series A',
            'series_b' => 'Series B',
            'series_c' => 'Series C',
            'growth' => 'Growth Stage',
            default => ucfirst(str_replace('_', ' ', $this->target_stage ?? '')),
        };
    }

    public function getFormattedProposedDateTime(): string
    {
        if (!$this->proposed_date) {
            return 'TBD';
        }

        $date = $this->proposed_date->format('M d, Y');
        $time = $this->proposed_time ? $this->proposed_time->format('g:i A') : 'TBD';
        
        return "$date at $time";
    }

    public function getFormattedDuration(): string
    {
        if (!$this->proposed_duration) {
            return 'TBD';
        }

        $hours = floor($this->proposed_duration / 60);
        $minutes = $this->proposed_duration % 60;

        if ($hours > 0) {
            return $minutes > 0 ? "$hours hr $minutes min" : "$hours hr";
        }

        return "$minutes min";
    }

    public function getFundingRange(): string
    {
        if (!$this->min_funding_needed && !$this->max_funding_needed) {
            return 'Any';
        }

        if ($this->min_funding_needed && $this->max_funding_needed) {
            return '$' . number_format($this->min_funding_needed) . ' - $' . number_format($this->max_funding_needed);
        }

        if ($this->min_funding_needed) {
            return '$' . number_format($this->min_funding_needed) . '+';
        }

        return 'Up to $' . number_format($this->max_funding_needed);
    }
}
