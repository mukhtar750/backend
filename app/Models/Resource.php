<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'bdsp_id',
        'name',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'is_approved',
    ];

    public function bdsp()
    {
        return $this->belongsTo(User::class, 'bdsp_id');
    }

    /**
     * Get all shares of this resource
     */
    public function shares()
    {
        return $this->hasMany(ResourceShare::class);
    }

    /**
     * Get entrepreneurs who have access to this resource through sharing
     */
    public function sharedWithEntrepreneurs()
    {
        return $this->belongsToMany(User::class, 'resource_shares', 'resource_id', 'shared_with')
                    ->withPivot(['message', 'is_read', 'read_at', 'created_at'])
                    ->withTimestamps();
    }

    /**
     * Check if a resource is shared with a specific entrepreneur
     */
    public function isSharedWith($entrepreneurId)
    {
        return $this->shares()->where('shared_with', $entrepreneurId)->exists();
    }

    /**
     * Get the share details for a specific entrepreneur
     */
    public function getShareFor($entrepreneurId)
    {
        return $this->shares()->where('shared_with', $entrepreneurId)->first();
    }
}