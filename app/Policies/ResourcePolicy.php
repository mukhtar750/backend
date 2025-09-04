<?php

namespace App\Policies;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResourcePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Resource $resource): bool
    {
        // Users can view approved resources
        if ($resource->is_approved) {
            return true;
        }
        
        // Users can view their own resources
        if ((int) $resource->bdsp_id === (int) $user->id || 
            (isset($resource->mentor_id) && (int) $resource->mentor_id === (int) $user->id) || 
            (isset($resource->mentee_id) && (int) $resource->mentee_id === (int) $user->id)) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // BDSPs, mentors, and mentees can create resources
        return in_array($user->role, ['bdsp', 'mentor', 'mentee']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Resource $resource): bool
    {
        // BDSPs can update their own resources
        if ($user->role === 'bdsp' && (int) $resource->bdsp_id === (int) $user->id) {
            return true;
        }
        
        // Mentors can update their own resources
        if ($user->role === 'mentor' && isset($resource->mentor_id) && (int) $resource->mentor_id === (int) $user->id) {
            return true;
        }
        
        // Mentees can update their own resources
        if ($user->role === 'mentee' && isset($resource->mentee_id) && (int) $resource->mentee_id === (int) $user->id) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Resource $resource): bool
    {
        // BDSPs can delete their own resources
        if ($user->role === 'bdsp' && (int) $resource->bdsp_id === (int) $user->id) {
            return true;
        }
        
        // Mentors can delete their own resources
        if ($user->role === 'mentor' && isset($resource->mentor_id) && (int) $resource->mentor_id === (int) $user->id) {
            return true;
        }
        
        // Mentees can delete their own resources
        if ($user->role === 'mentee' && isset($resource->mentee_id) && (int) $resource->mentee_id === (int) $user->id) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Resource $resource): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Resource $resource): bool
    {
        return false;
    }
}
