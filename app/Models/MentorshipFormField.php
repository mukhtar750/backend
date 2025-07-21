<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MentorshipFormField extends Model
{
    protected $fillable = [
        'mentorship_form_id',
        'field_type',
        'label',
        'description',
        'options',
        'required',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
    ];

    /**
     * Get the form that owns the field.
     */
    public function form(): BelongsTo
    {
        return $this->belongsTo(MentorshipForm::class, 'mentorship_form_id');
    }

    /**
     * Get the field options as an array.
     *
     * @return array
     */
    public function getOptionsArray(): array
    {
        if (empty($this->options)) {
            return [];
        }

        return $this->options;
    }

    /**
     * Check if the field type is a select, checkbox, or radio that requires options.
     *
     * @return bool
     */
    public function requiresOptions(): bool
    {
        return in_array($this->field_type, ['select', 'checkbox', 'radio', 'multiselect']);
    }
}