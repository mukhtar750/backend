<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'sender_id',
        'content',
        'message_type',
        'file_path',
        'file_name',
        'file_size',
        'is_read',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}