<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function getMessageableUsers()
    {
        $users = User::where('is_approved', true)
            ->where('id', '!=', $this->id)
            ->get();

        return $users->filter(function ($user) {
            return $this->canMessage($user);
        });
    }
}
