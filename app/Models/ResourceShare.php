<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceShare extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'shared_by',
        'shared_with',
        'message',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the resource that was shared
     */
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Get the BDSP who shared the resource
     */
    public function sharedBy()
    {
        return $this->belongsTo(User::class, 'shared_by');
    }

    /**
     * Get the entrepreneur who received the resource
     */
    public function sharedWith()
    {
        return $this->belongsTo(User::class, 'shared_with');
    }

    /**
     * Mark the share as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Scope to get unread shares for a user
     */
    public function scopeUnread($query, $userId)
    {
        return $query->where('shared_with', $userId)->where('is_read', false);
    }

    /**
     * Scope to get shares by a specific BDSP
     */
    public function scopeByBdsp($query, $bdspId)
    {
        return $query->where('shared_by', $bdspId);
    }

    /**
     * Scope to get shares for a specific entrepreneur
     */
    public function scopeForEntrepreneur($query, $entrepreneurId)
    {
        return $query->where('shared_with', $entrepreneurId);
    }
}
