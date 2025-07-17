<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PitchEvent extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'event_type',
        'capacity',
        'registration_deadline',
        'status',
        'featured_startups',
        'contact_email',
        'contact_phone',
        'image_path',
        'agenda',
        'requirements',
        'prizes',
        'tags',
        'event_link',
        'created_by',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'registration_deadline' => 'datetime',
        'featured_startups' => 'array',
        'agenda' => 'array',
        'requirements' => 'array',
        'prizes' => 'array',
        'tags' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->hasMany(PitchEventParticipant::class);
    }

    public function confirmedParticipants()
    {
        return $this->participants()->where('status', 'confirmed');
    }

    public function investors()
    {
        return $this->hasMany(PitchEventInvestor::class);
    }

    public function confirmedInvestors()
    {
        return $this->investors()->where('status', 'confirmed');
    }

    public function startups()
    {
        return $this->hasMany(PitchEventStartup::class);
    }

    public function confirmedStartups()
    {
        return $this->startups()->where('status', 'confirmed');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now());
    }
}
