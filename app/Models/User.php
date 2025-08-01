<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\TrainingSessionParticipant;
use App\Models\GroupParticipant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved',
        // Investor
        'phone', 'type_of_investor', 'interest_areas', 'company', 'investor_linkedin',
        // BDSP
        'services_provided', 'years_of_experience', 'organization', 'certifications', 'bdsp_linkedin',
        // Entrepreneur
        'business_name', 'sector', 'cac_number', 'funding_stage', 'website', 'entrepreneur_phone', 'entrepreneur_linkedin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    // Messaging relationships
    public function conversationsAsUserOne()
    {
        return $this->hasMany(Conversation::class, 'user_one_id');
    }

    public function conversationsAsUserTwo()
    {
        return $this->hasMany(Conversation::class, 'user_two_id');
    }

    public function conversations()
    {
        return $this->conversationsAsUserOne()->union($this->conversationsAsUserTwo());
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Helper methods for messaging
    public function getConversations()
    {
        return Conversation::forUser($this->id)
            ->with(['userOne', 'userTwo', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();
    }

    public function getUnreadMessageCount()
    {
        return Message::whereHas('conversation', function ($query) {
            $query->forUser($this->id);
        })->where('sender_id', '!=', $this->id)
        ->where('is_read', false)
        ->count();
    }

    // Pairings relationships
    public function pairingsAsOne()
    {
        return $this->hasMany(Pairing::class, 'user_one_id');
    }
    public function pairingsAsTwo()
    {
        return $this->hasMany(Pairing::class, 'user_two_id');
    }
    public function allPairings()
    {
        return Pairing::where('user_one_id', $this->id)->orWhere('user_two_id', $this->id);
    }

    // Helper: Check if paired with another user for a type
    public function isPairedWith($otherUser, $type)
    {
        return Pairing::isPaired($this->id, $otherUser->id, $type);
    }

    // Role-based messaging permissions (with pairing logic)
    public function canMessage($targetUser)
    {
        // Admin can message anyone
        if ($this->role === 'admin' || $targetUser->role === 'admin') {
            return true;
        }

        // Target user must be approved
        if (!$targetUser->is_approved) {
            return false;
        }

        // Any user can message admin
        if ($targetUser->role === 'admin') {
            return true;
        }

        // Role-based permissions with pairing
        switch ($this->role) {
            case 'investor':
                return $targetUser->role === 'entrepreneur' && $this->isPairedWith($targetUser, 'investor_entrepreneur');
            case 'bdsp':
                return $targetUser->role === 'entrepreneur' && $this->isPairedWith($targetUser, 'bdsp_entrepreneur');
            case 'mentor':
                // A mentor can message a paired mentee or a paired entrepreneur
                if ($targetUser->role === 'mentee') {
                    return $this->isPairedWith($targetUser, 'mentor_mentee');
                }
                if ($targetUser->role === 'entrepreneur') {
                    return $this->isPairedWith($targetUser, 'mentor_entrepreneur');
                }
                return false;
            case 'mentee':
                return $targetUser->role === 'mentor' && $this->isPairedWith($targetUser, 'mentor_mentee');
            case 'entrepreneur':
                // Entrepreneurs can message paired BDSPs, investors, and mentors
                if ($targetUser->role === 'bdsp') {
                    return $this->isPairedWith($targetUser, 'bdsp_entrepreneur');
                }
                if ($targetUser->role === 'investor') {
                    return $this->isPairedWith($targetUser, 'investor_entrepreneur');
                }
                if ($targetUser->role === 'mentor') {
                    return $this->isPairedWith($targetUser, 'mentor_entrepreneur');
                }
                return false;
            default:
                return false;
        }
    }

    // Explicit role helpers
    public function isAdmin() { return $this->role === 'admin'; }
    public function isMentor() { return $this->role === 'mentor'; }
    public function isMentee() { return $this->role === 'mentee'; }
    public function isEntrepreneur() { return $this->role === 'entrepreneur'; }
    public function isBDSP() { return $this->role === 'bdsp'; }
    public function isInvestor() { return $this->role === 'investor'; }

    public function getMessageableUsers()
    {
        $users = User::where('is_approved', true)
            ->where('id', '!=', $this->id)
            ->get();

        return $users->filter(function ($user) {
            return $this->canMessage($user);
        });
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function pitches()
    {
        return $this->hasMany(Pitch::class);
    }

    public function startup()
    {
        return $this->hasOne(Startup::class, 'entrepreneur_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function practicePitches()
    {
        return $this->hasMany(PracticePitch::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            DB::transaction(function () use ($user) {
                Log::info("Attempting to delete user and related data: {$user->id}");

                // Delete conversations and messages
                $user->conversationsAsUserOne->each(function ($conversation) {
                    $conversation->messages()->delete();
                    $conversation->delete();
                });
                $user->conversationsAsUserTwo->each(function ($conversation) {
                    $conversation->messages()->delete();
                    $conversation->delete();
                });
                $user->sentMessages()->delete();

                // Delete pairings
                $user->pairingsAsOne()->delete();
                $user->pairingsAsTwo()->delete();

                // Delete mentorship sessions where user is scheduled_by or scheduled_for
                $deletedMentorshipSessionsCount = \App\Models\MentorshipSession::where('scheduled_by', $user->id)
                    ->orWhere('scheduled_for', $user->id)
                    ->delete();
                Log::info("Deleted {$deletedMentorshipSessionsCount} mentorship sessions for user: {$user->id}");

                // Delete training session participants
                \App\Models\TrainingSessionParticipant::where('user_id', $user->id)->delete();

                // Delete tasks and task submissions
                $user->tasks()->delete();
                \App\Models\TaskSubmission::where('user_id', $user->id)->delete();

                // Delete startups and related requests if the user is an entrepreneur
                if ($user->isEntrepreneur()) {
                    $user->startup->each(function ($startup) {
                        $startup->accessRequests()->delete();
                        $startup->infoRequests()->delete();
                        $startup->delete();
                    });
                }

                // Delete ideas, comments, pitches, votes, practice pitches, feedback, resources
                $user->ideas()->delete();
                $user->comments()->delete();
                $user->pitches()->delete();
                $user->votes()->delete();
                $user->practicePitches()->delete();
                $user->feedback()->delete();
                $user->resources()->delete();

                // Delete group messages and participants
                \App\Models\GroupMessage::where('sender_id', $user->id)->delete();
                \App\Models\GroupParticipant::where('user_id', $user->id)->delete();

                // Delete pitch event related data
                \App\Models\PitchEventParticipant::where('user_id', $user->id)->delete();
                \App\Models\PitchEventInvestor::where('user_id', $user->id)->delete();
                // Delete pitch event startups through user's startup
                if ($user->startup) {
                    \App\Models\PitchEventStartup::where('startup_id', $user->startup->id)->delete();
                }
                \App\Models\PitchEventProposal::where('investor_id', $user->id)->delete();

                // Delete idea interests
                \App\Models\IdeaInterest::where('user_id', $user->id)->delete();

                Log::info("Successfully deleted user and related data: {$user->id}");
            });
        });
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function ideaInterests()
    {
        return $this->hasMany(IdeaInterest::class);
    }

    public function taskSubmissions()
    {
        return $this->hasMany(TaskSubmission::class, 'user_id');
    }
    public function reviewedTaskSubmissions()
    {
        return $this->hasMany(TaskSubmission::class, 'reviewed_by');
    }

    /**
     * Get all startup info requests made by this investor
     */
    public function startupInfoRequests()
    {
        return $this->hasMany(StartupInfoRequest::class, 'investor_id');
    }

    /**
     * Get approved startup info requests made by this investor
     */
    public function approvedStartupInfoRequests()
    {
        return $this->hasMany(StartupInfoRequest::class, 'investor_id')->where('status', 'approved');
    }

    // Pitch Event Proposals relationships
    public function pitchEventProposals()
    {
        return $this->hasMany(PitchEventProposal::class, 'investor_id');
    }

    public function reviewedProposals()
    {
        return $this->hasMany(PitchEventProposal::class, 'reviewed_by');
    }
}
