<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MentorshipFormSubmission extends Model
{
    protected $fillable = [
        'pairing_id',
        'mentorship_form_id',
        'submitted_by',
        'mentorship_session_id',
        'form_data',
        'is_draft',
        'is_signed',
        'signed_at',
        'status',
    ];

    protected $casts = [
        'form_data' => 'array',
        'is_draft' => 'boolean',
        'is_signed' => 'boolean',
        'signed_at' => 'datetime',
    ];

    /**
     * Get the form that this submission belongs to.
     */
    public function form(): BelongsTo
    {
        return $this->belongsTo(MentorshipForm::class, 'mentorship_form_id');
    }

    /**
     * Get the pairing that this submission belongs to.
     */
    public function pairing(): BelongsTo
    {
        return $this->belongsTo(Pairing::class);
    }

    /**
     * Get the user who submitted this form.
     */
    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    /**
     * Get the mentorship session associated with this submission.
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(MentorshipSession::class, 'mentorship_session_id');
    }

    /**
     * Get the reviews for this submission.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(MentorshipFormReview::class);
    }

    /**
     * Get the latest review for this submission.
     *
     * @return \App\Models\MentorshipFormReview|null
     */
    public function getLatestReview()
    {
        return $this->reviews()->latest()->first();
    }

    /**
     * Check if this submission can be edited by the given user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function canBeEditedBy(User $user): bool
    {
        // If it's a draft, only the submitter can edit it
        if ($this->is_draft) {
            return $this->submitted_by === $user->id;
        }

        // If it's submitted but not yet reviewed, the submitter can still edit it
        if ($this->status === 'submitted' && $this->submitted_by === $user->id) {
            return true;
        }

        // If it's a form that requires both parties to complete, check if the user is the other party
        if ($this->form->completion_by === 'both') {
            $pairing = $this->pairing;
            $otherUserId = ($pairing->user_one_id === $user->id) ? $pairing->user_two_id : $pairing->user_one_id;
            
            // If the user is the other party and they haven't reviewed it yet
            if ($otherUserId === $user->id && !$this->reviews()->where('reviewed_by', $user->id)->exists()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get submissions for a specific pairing.
     *
     * @param int $pairingId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByPairing(int $pairingId)
    {
        return self::where('pairing_id', $pairingId)
            ->with(['form', 'submitter', 'reviews'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}