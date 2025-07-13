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

    // Role-based messaging permissions
    public function canMessage($targetUser)
    {
        // Admin can message anyone
        if ($this->role === 'admin') {
            return true;
        }

        // Target user must be approved
        if (!$targetUser->is_approved) {
            return false;
        }

        // Role-based permissions
        switch ($this->role) {
            case 'investor':
                // Investors can only message admin
                return $targetUser->role === 'admin';
            
            case 'bdsp':
                // BDSP can message entrepreneurs and admin
                return in_array($targetUser->role, ['entrepreneur', 'admin']);
            
            case 'mentor':
                // Mentors can message mentees and admin
                return in_array($targetUser->role, ['mentee', 'admin']);
            
            case 'mentee':
                // Mentees can message mentors and admin
                return in_array($targetUser->role, ['mentor', 'admin']);
            
            case 'entrepreneur':
                // Entrepreneurs can message BDSP and admin
                return in_array($targetUser->role, ['bdsp', 'admin']);
            
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
