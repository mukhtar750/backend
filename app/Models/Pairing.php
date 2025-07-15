<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pairing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'pairing_type',
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

    // Helper: Check if two users are paired for a given type
    public static function isPaired($userOneId, $userTwoId, $type)
    {
        return self::where(function ($q) use ($userOneId, $userTwoId) {
            $q->where('user_one_id', $userOneId)->where('user_two_id', $userTwoId);
        })->orWhere(function ($q) use ($userOneId, $userTwoId) {
            $q->where('user_one_id', $userTwoId)->where('user_two_id', $userOneId);
        })->where('pairing_type', $type)->exists();
    }
}
