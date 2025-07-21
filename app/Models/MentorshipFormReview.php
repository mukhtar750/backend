<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MentorshipFormReview extends Model
{
    protected $fillable = [
        'mentorship_form_submission_id',
        'reviewed_by',
        'comments',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Get the submission that this review belongs to.
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(MentorshipFormSubmission::class, 'mentorship_form_submission_id');
    }

    /**
     * Get the user who reviewed this submission.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get reviews by the given user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByReviewer(int $userId)
    {
        return self::where('reviewed_by', $userId)
            ->with(['submission.form', 'submission.submitter'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}