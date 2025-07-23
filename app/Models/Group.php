<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'is_global'];

    public function messages()
    {
        return $this->hasMany(GroupMessage::class);
    }

    // Method to check if user can access (for global, always true)
    public function canAccess($user)
    {
        return $this->is_global || $this->participants()->where('user_id', $user->id)->exists();
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'group_participants');
    }
}