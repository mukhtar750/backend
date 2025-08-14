<?php

namespace App\Http\Controllers;

use App\Models\ModuleCompletion;
use App\Models\TrainingModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Added this import for User model

class EntrepreneurProgressController extends Controller
{
    /**
     * Show entrepreneur's progress dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get all modules the entrepreneur is enrolled in
        $enrolledModules = $user->moduleCompletions()
            ->with(['module.bdsp', 'module.weeks'])
            ->get()
            ->pluck('module')
            ->unique('id');

        // Get progress for each module
        $moduleProgress = [];
        foreach ($enrolledModules as $module) {
            $completion = $user->moduleCompletions()
                ->where('module_id', $module->id)
                ->first();
            
            if ($completion) {
                $moduleProgress[] = [
                    'module' => $module,
                    'completion' => $completion,
                    'bdsp' => $module->bdsp,
                    'progressPercentage' => $completion->progress_percentage,
                    'currentWeek' => $completion->current_week,
                    'status' => $completion->status,
                    'startedAt' => $completion->started_at,
                    'completedAt' => $completion->completed_at,
                ];
            }
        }

        // Calculate overall statistics
        $totalModules = count($moduleProgress);
        $completedModules = collect($moduleProgress)->where('status', 'completed')->count();
        $inProgressModules = collect($moduleProgress)->where('status', 'in_progress')->count();
        $notStartedModules = collect($moduleProgress)->where('status', 'not_started')->count();
        
        $overallProgress = $totalModules > 0 ? round(($completedModules / $totalModules) * 100, 1) : 0;

        $stats = [
            'total' => $totalModules,
            'completed' => $completedModules,
            'in_progress' => $inProgressModules,
            'not_started' => $notStartedModules,
            'overall_progress' => $overallProgress,
        ];

        return view('entrepreneur.progress-dashboard', compact('moduleProgress', 'stats'));
    }

    /**
     * Show detailed progress for a specific module
     */
    public function showModuleProgress(TrainingModule $module)
    {
        $user = Auth::user();
        
        // Check if entrepreneur is enrolled in this module
        $completion = $user->moduleCompletions()
            ->where('module_id', $module->id)
            ->first();

        // Load module with weeks and BDSP
        $module->load(['weeks', 'bdsp']);

        // Set progress and overallProgress variables
        $progress = $completion;
        $overallProgress = $completion ? ($completion->progress_percentage ?? 0) : 0;

        // Get weekly progress breakdown if enrolled
        $weeklyProgress = [];
        if ($completion && $module->weeks) {
            foreach ($module->weeks as $week) {
                $weeklyProgress[] = [
                    'week' => $week,
                    'isCompleted' => $completion->current_week > $week->week_number,
                    'isCurrent' => $completion->current_week == $week->week_number,
                    'isUpcoming' => $completion->current_week < $week->week_number,
                ];
            }
        }

        // Pass variables that the view expects
        return view('entrepreneur.module-progress', compact('module', 'progress', 'overallProgress'));
    }

    /**
     * Start a module (mark as in progress)
     */
    public function startModule(TrainingModule $module)
    {
        $user = Auth::user();
        
        // Debug: Log the user role and ID
        \Log::info('StartModule called by user', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_name' => $user->name,
            'module_id' => $module->id,
            'module_title' => $module->title
        ]);
        
        // Check if entrepreneur is paired with the BDSP who created this module
        $bdsp = User::find($module->bdsp_id);
        $isPaired = $bdsp && $user->isPairedWith($bdsp, 'bdsp_entrepreneur');

        if (!$isPaired) {
            \Log::warning('User not paired with BDSP', [
                'user_id' => $user->id,
                'bdsp_id' => $module->bdsp_id
            ]);
            return response()->json(['error' => 'You are not paired with the BDSP who created this module.'], 403);
        }

        // Get or create completion record
        $completion = $user->moduleCompletions()
            ->where('module_id', $module->id)
            ->first();

        if (!$completion) {
            $completion = ModuleCompletion::create([
                'module_id' => $module->id,
                'entrepreneur_id' => $user->id,
                'bdsp_id' => $module->bdsp_id,
                'status' => 'not_started',
                'current_week' => 1,
                'progress_percentage' => 0,
            ]);
        }

        // Mark as started
        $completion->markAsStarted();

        \Log::info('Module started successfully', [
            'completion_id' => $completion->id,
            'status' => $completion->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Module started successfully!',
            'completion' => $completion->fresh()
        ]);
    }

    /**
     * Update personal progress (entrepreneur can mark their own progress)
     */
    public function updatePersonalProgress(Request $request, TrainingModule $module)
    {
        $user = Auth::user();
        
        $request->validate([
            'current_week' => 'required|integer|min:1|max:' . $module->duration_weeks,
            'progress_percentage' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        // Check if entrepreneur is enrolled in this module
        $completion = $user->moduleCompletions()
            ->where('module_id', $module->id)
            ->first();

        if (!$completion) {
            return response()->json(['error' => 'You are not enrolled in this module.'], 404);
        }

        // Update progress
        $completion->updateProgress(
            $request->current_week,
            $request->progress_percentage
        );

        if ($request->notes) {
            $completion->update(['completion_notes' => $request->notes]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully!',
            'completion' => $completion->fresh()
        ]);
    }

    /**
     * Get entrepreneur's progress summary for dashboard widgets
     */
    public function getProgressSummary()
    {
        $user = Auth::user();
        
        $recentModules = $user->moduleCompletions()
            ->with(['module.bdsp'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        $completionStats = [
            'total_enrolled' => $user->moduleCompletions()->count(),
            'completed' => $user->moduleCompletions()->completed()->count(),
            'in_progress' => $user->moduleCompletions()->inProgress()->count(),
            'not_started' => $user->moduleCompletions()->notStarted()->count(),
        ];

        return response()->json([
            'recent_modules' => $recentModules,
            'stats' => $completionStats,
        ]);
    }
}
