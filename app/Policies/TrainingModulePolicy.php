<?php

namespace App\Policies;

use App\Models\TrainingModule;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TrainingModulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['bdsp', 'entrepreneur', 'admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TrainingModule $trainingModule): bool
    {
        // BDSPs can view their own modules
        if ($user->role === 'bdsp' && $trainingModule->bdsp_id === $user->id) {
            return true;
        }

        // Entrepreneurs can view modules from their paired BDSPs
        if ($user->role === 'entrepreneur') {
            $pairedBdspIds = $user->getPairedProfessionalIds();
            if (in_array($trainingModule->bdsp_id, $pairedBdspIds)) {
                return $trainingModule->status === 'published';
            }
        }

        // Admins can view all modules
        if ($user->role === 'admin') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'bdsp';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TrainingModule $trainingModule): bool
    {
        // BDSPs can update their own modules
        if ($user->role === 'bdsp' && $trainingModule->bdsp_id === $user->id) {
            return true;
        }

        // Admins can update any module
        if ($user->role === 'admin') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TrainingModule $trainingModule): bool
    {
        // BDSPs can delete their own modules (only if no progress exists)
        if ($user->role === 'bdsp' && $trainingModule->bdsp_id === $user->id) {
            return $trainingModule->progress()->count() === 0;
        }

        // Admins can delete any module
        if ($user->role === 'admin') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TrainingModule $trainingModule): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TrainingModule $trainingModule): bool
    {
        return $user->role === 'admin';
    }
}
