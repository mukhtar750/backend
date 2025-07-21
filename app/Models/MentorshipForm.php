<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MentorshipForm extends Model
{
    protected $fillable = [
        'form_type',
        'title',
        'description',
        'order',
        'phase',
        'completion_by',
        'requires_signature',
        'active',
    ];

    /**
     * Get the fields for this form.
     */
    public function fields(): HasMany
    {
        return $this->hasMany(MentorshipFormField::class)->orderBy('order');
    }

    /**
     * Get the submissions for this form.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(MentorshipFormSubmission::class);
    }

    /**
     * Get forms by phase.
     *
     * @param string $phase
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByPhase(string $phase)
    {
        return self::where('phase', $phase)
            ->where('active', true)
            ->orderBy('order')
            ->with('fields')
            ->get();
    }

    /**
     * Get all active forms ordered by phase and order.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllActive()
    {
        return self::where('active', true)
            ->orderBy('phase')
            ->orderBy('order')
            ->with('fields')
            ->get();
    }
}