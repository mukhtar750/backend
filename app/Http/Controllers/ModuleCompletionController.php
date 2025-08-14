<?php

namespace App\Http\Controllers;

use App\Models\ModuleCompletion;
use App\Models\TrainingModule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pairing;

class ModuleCompletionController extends Controller
{
    /**
     * Show module management dashboard for BDSP
     */
    public function moduleManagement(TrainingModule $module)
    {
        $this->authorize('update', $module);

        // Get all paired entrepreneurs for this BDSP
        $pairedEntrepreneurs = User::where('role', 'entrepreneur')
            ->where(function($query) {
                $query->whereHas('pairingsAsOne', function($q) {
                    $q->where('user_two_id', Auth::id());
                })->orWhereHas('pairingsAsTwo', function($q) {
                    $q->where('user_one_id', Auth::id());
                });
            })
            ->with(['moduleCompletions' => function($query) use ($module) {
                $query->where('module_id', $module->id);
            }])
            ->get();

        // Get or create completion records for each entrepreneur
        $entrepreneurProgress = [];
        foreach ($pairedEntrepreneurs as $entrepreneur) {
            $completion = $entrepreneur->moduleCompletions->first();
            
            if (!$completion) {
                // Create initial completion record
                $completion = ModuleCompletion::create([
                    'module_id' => $module->id,
                    'entrepreneur_id' => $entrepreneur->id,
                    'bdsp_id' => Auth::id(),
                    'status' => 'not_started',
                    'current_week' => 1,
                    'progress_percentage' => 0,
                ]);
            }
            
            $entrepreneurProgress[] = [
                'entrepreneur' => $entrepreneur,
                'completion' => $completion,
                'lastActivity' => $completion->updated_at,
            ];
        }

        // Get module statistics
        $stats = $module->getCompletionStats();

        return view('bdsp.module-management', compact('module', 'entrepreneurProgress', 'stats'));
    }

    /**
     * Mark entrepreneur as completed for a module
     */
    public function markCompleted(Request $request, TrainingModule $module, User $entrepreneur)
    {
        $this->authorize('update', $module);

        // Verify entrepreneur is paired with this BDSP
        $isPaired = Pairing::isPaired($entrepreneur->id, Auth::id(), 'bdsp_entrepreneur');

        if (!$isPaired) {
            return response()->json(['error' => 'Entrepreneur is not paired with you.'], 403);
        }

        $completion = ModuleCompletion::where('module_id', $module->id)
            ->where('entrepreneur_id', $entrepreneur->id)
            ->first();

        if (!$completion) {
            return response()->json(['error' => 'Completion record not found.'], 404);
        }

        $completion->markAsCompleted($request->notes);

        return response()->json([
            'success' => true,
            'message' => 'Module marked as completed for ' . $entrepreneur->name,
            'completion' => $completion->fresh()
        ]);
    }

    /**
     * Update entrepreneur progress
     */
    public function updateProgress(Request $request, TrainingModule $module, User $entrepreneur)
    {
        $this->authorize('update', $module);

        $request->validate([
            'current_week' => 'required|integer|min:1|max:' . $module->duration_weeks,
            'progress_percentage' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        // Verify entrepreneur is paired with this BDSP
        $isPaired = Pairing::isPaired($entrepreneur->id, Auth::id(), 'bdsp_entrepreneur');

        if (!$isPaired) {
            return response()->json(['error' => 'Entrepreneur is not paired with you.'], 403);
        }

        $completion = ModuleCompletion::where('module_id', $module->id)
            ->where('entrepreneur_id', $entrepreneur->id)
            ->first();

        if (!$completion) {
            return response()->json(['error' => 'Completion record not found.'], 404);
        }

        $completion->updateProgress(
            $request->current_week,
            $request->progress_percentage
        );

        if ($request->notes) {
            $completion->update(['completion_notes' => $request->notes]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Progress updated for ' . $entrepreneur->name,
            'completion' => $completion->fresh()
        ]);
    }

    /**
     * Reopen module for entrepreneur
     */
    public function reopenModule(TrainingModule $module, User $entrepreneur)
    {
        $this->authorize('update', $module);

        // Verify entrepreneur is paired with this BDSP
        $isPaired = Pairing::isPaired($entrepreneur->id, Auth::id(), 'bdsp_entrepreneur');

        if (!$isPaired) {
            return response()->json(['error' => 'Entrepreneur is not paired with you.'], 403);
        }

        $completion = ModuleCompletion::where('module_id', $module->id)
            ->where('entrepreneur_id', $entrepreneur->id)
            ->first();

        if (!$completion) {
            return response()->json(['error' => 'Completion record not found.'], 404);
        }

        $completion->reopenModule();

        return response()->json([
            'success' => true,
            'message' => 'Module reopened for ' . $entrepreneur->name,
            'completion' => $completion->fresh()
        ]);
    }

    /**
     * Get entrepreneur progress details
     */
    public function getEntrepreneurProgress(TrainingModule $module, User $entrepreneur)
    {
        $this->authorize('update', $module);

        $completion = ModuleCompletion::where('module_id', $module->id)
            ->where('entrepreneur_id', $entrepreneur->id)
            ->first();

        if (!$completion) {
            return response()->json(['error' => 'Progress not found.'], 404);
        }

        return response()->json([
            'completion' => $completion->load('entrepreneur'),
            'module' => $module->load('weeks'),
        ]);
    }
}
