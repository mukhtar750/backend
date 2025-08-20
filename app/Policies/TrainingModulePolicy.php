<?php

namespace App\Policies;

use App\Models\TrainingModule;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class TrainingModulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $role = strtolower($user->role ?? '');
        return in_array($role, ['bdsp', 'entrepreneur', 'admin', 'staff']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TrainingModule $trainingModule): bool
    {
        $role = strtolower($user->role ?? '');
        
        // Enhanced debugging for production issue
        Log::info('Policy:view DEBUG - Entry', [
            'user_id' => $user->id,
            'user_role_raw' => $user->role,
            'user_role_processed' => $role,
            'user_status' => $user->status ?? 'null',
            'user_is_approved' => $user->is_approved ?? 'null',
            'module_id' => $trainingModule->id,
            'module_bdsp_id' => $trainingModule->bdsp_id,
            'module_status' => $trainingModule->status,
            'ownership_match' => ($trainingModule->bdsp_id === $user->id),
            'role_match' => ($role === 'bdsp'),
            'both_conditions' => ($role === 'bdsp' && $trainingModule->bdsp_id === $user->id),
        ]);

        // BDSPs can view their own modules
        if ($role === 'bdsp' && $trainingModule->bdsp_id === $user->id) {
            Log::info('Policy:view allow (owner bdsp)', [
                'user_id' => $user->id,
                'role' => $role,
                'module_id' => $trainingModule->id,
                'module_bdsp_id' => $trainingModule->bdsp_id,
            ]);
            return true;
        }

        // Entrepreneurs can view modules from their paired BDSPs
        if ($role === 'entrepreneur') {
            $pairedBdspIds = $user->getPairedProfessionalIds();
            if (in_array($trainingModule->bdsp_id, $pairedBdspIds)) {
                Log::info('Policy:view allow (entrepreneur paired & published)', [
                    'user_id' => $user->id,
                    'role' => $role,
                    'module_id' => $trainingModule->id,
                    'module_bdsp_id' => $trainingModule->bdsp_id,
                    'status' => $trainingModule->status,
                ]);
                return $trainingModule->status === 'published';
            }
        }

        // Admins and staff can view all modules
        if (in_array($role, ['admin', 'staff'])) {
            Log::info('Policy:view allow (admin/staff)', [
                'user_id' => $user->id,
                'role' => $role,
                'module_id' => $trainingModule->id,
                'module_bdsp_id' => $trainingModule->bdsp_id,
            ]);
            return true;
        }

        Log::warning('Policy:view deny', [
            'user_id' => $user->id,
            'role' => $role,
            'module_id' => $trainingModule->id,
            'module_bdsp_id' => $trainingModule->bdsp_id,
            'status' => $trainingModule->status,
        ]);
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
        $role = strtolower($user->role ?? '');

        // BDSPs can update their own modules
        if ($role === 'bdsp' && $trainingModule->bdsp_id === $user->id) {
            Log::info('Policy:update allow (owner bdsp)', [
                'user_id' => $user->id,
                'role' => $role,
                'module_id' => $trainingModule->id,
                'module_bdsp_id' => $trainingModule->bdsp_id,
            ]);
            return true;
        }

        // Admins and staff can update any module
        if (in_array($role, ['admin', 'staff'])) {
            Log::info('Policy:update allow (admin/staff)', [
                'user_id' => $user->id,
                'role' => $role,
                'module_id' => $trainingModule->id,
                'module_bdsp_id' => $trainingModule->bdsp_id,
            ]);
            return true;
        }

        Log::warning('Policy:update deny', [
            'user_id' => $user->id,
            'role' => $role,
            'module_id' => $trainingModule->id,
            'module_bdsp_id' => $trainingModule->bdsp_id,
        ]);
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TrainingModule $trainingModule): bool
    {
        $role = strtolower($user->role ?? '');

        // BDSPs can delete their own modules (only if no progress exists)
        if ($role === 'bdsp' && $trainingModule->bdsp_id === $user->id) {
            $allowed = $trainingModule->progress()->count() === 0;
            Log::log($allowed ? 'info' : 'warning', 'Policy:delete ' . ($allowed ? 'allow' : 'deny') . ' (owner bdsp)', [
                'user_id' => $user->id,
                'role' => $role,
                'module_id' => $trainingModule->id,
                'module_bdsp_id' => $trainingModule->bdsp_id,
                'progress_count' => $trainingModule->progress()->count(),
            ]);
            return $allowed;
        }

        // Admins and staff can delete any module
        if (in_array($role, ['admin', 'staff'])) {
            Log::info('Policy:delete allow (admin/staff)', [
                'user_id' => $user->id,
                'role' => $role,
                'module_id' => $trainingModule->id,
                'module_bdsp_id' => $trainingModule->bdsp_id,
            ]);
            return true;
        }

        Log::warning('Policy:delete deny', [
            'user_id' => $user->id,
            'role' => $role,
            'module_id' => $trainingModule->id,
            'module_bdsp_id' => $trainingModule->bdsp_id,
        ]);
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TrainingModule $trainingModule): bool
    {
        $role = strtolower($user->role ?? '');
        return in_array($role, ['admin', 'staff']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TrainingModule $trainingModule): bool
    {
        $role = strtolower($user->role ?? '');
        return in_array($role, ['admin', 'staff']);
    }
}
