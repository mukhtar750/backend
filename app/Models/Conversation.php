<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'conversation_type',
        'title',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    // Relationships
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    // Helper methods
    public function getOtherUser($currentUserId)
    {
        return $this->user_one_id == $currentUserId ? $this->userTwo : $this->userOne;
    }

    public function isParticipant($userId)
    {
        return $this->user_one_id == $userId || $this->user_two_id == $userId;
    }

    public function getUnreadCount($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }

    public function markAsRead($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
    }

    // Scope for user conversations
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_one_id', $userId)
                    ->orWhere('user_two_id', $userId);
    }

    // Find or create conversation between two users
    public static function findOrCreateBetween($userOneId, $userTwoId)
    {
        $conversation = self::where(function ($query) use ($userOneId, $userTwoId) {
            $query->where('user_one_id', $userOneId)
                  ->where('user_two_id', $userTwoId);
        })->orWhere(function ($query) use ($userOneId, $userTwoId) {
            $query->where('user_one_id', $userTwoId)
                  ->where('user_two_id', $userOneId);
        })->first();

        if (!$conversation) {
            $conversation = self::create([
                'user_one_id' => $userOneId,
                'user_two_id' => $userTwoId,
                'conversation_type' => 'direct',
            ]);
        }

        return $conversation;
    }
}
