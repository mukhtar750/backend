<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingModule;
use App\Models\ModuleCompletion;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Added for DB facade

class AdminTrainingModuleController extends Controller
{
    /**
     * Display a listing of all training modules
     */
    public function index(Request $request)
    {
        $query = TrainingModule::with(['bdsp', 'weeks']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('bdsp')) {
            $query->where('bdsp_id', $request->bdsp);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('target_audience', 'like', '%' . $request->search . '%');
            });
        }

        $modules = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total_modules' => TrainingModule::count(),
            'published_modules' => TrainingModule::where('status', 'published')->count(),
            'draft_modules' => TrainingModule::where('status', 'draft')->count(),
            'total_enrollments' => ModuleCompletion::count(),
            'active_learners' => ModuleCompletion::distinct('entrepreneur_id')->count(),
        ];

        // Get BDSPs for filter
        $bdspUsers = User::where('role', 'bdsp')->get();

        return view('admin.training-modules.index', compact('modules', 'stats', 'bdspUsers'));
    }

    /**
     * Show the specified training module
     */
    public function show(TrainingModule $module)
    {
        $module->load(['bdsp', 'weeks', 'completions.entrepreneur']);

        // Get enrollment statistics
        $enrollmentStats = [
            'total_enrolled' => $module->completions()->count(),
            'completed' => $module->completions()->where('status', 'completed')->count(),
            'in_progress' => $module->completions()->whereIn('status', ['not_started', 'in_progress'])->count(),
            'avg_progress' => $module->completions()->avg('progress_percentage') ?? 0,
        ];

        // Get recent enrollments
        $recentEnrollments = $module->completions()
            ->with('entrepreneur')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.training-modules.show', compact('module', 'enrollmentStats', 'recentEnrollments'));
    }

    /**
     * Approve a training module for publication
     */
    public function approve(TrainingModule $module)
    {
        $module->update([
            'status' => 'published',
            'admin_reviewed' => true,
            'admin_reviewed_at' => now(),
            'admin_reviewed_by' => Auth::id(),
        ]);

        Log::info('Training module approved by admin', [
            'module_id' => $module->id,
            'admin_id' => Auth::id(),
            'title' => $module->title,
        ]);

        return redirect()->back()->with('success', 'Module approved and published successfully.');
    }

    /**
     * Reject a training module
     */
    public function reject(Request $request, TrainingModule $module)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        $module->update([
            'status' => 'rejected',
            'admin_reviewed' => true,
            'admin_reviewed_at' => now(),
            'admin_reviewed_by' => Auth::id(),
            'admin_notes' => $request->admin_notes,
        ]);

        Log::info('Training module rejected by admin', [
            'module_id' => $module->id,
            'admin_id' => Auth::id(),
            'title' => $module->title,
            'notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Module rejected successfully.');
    }

    /**
     * Archive a training module
     */
    public function archive(TrainingModule $module)
    {
        $module->update(['status' => 'archived']);

        Log::info('Training module archived by admin', [
            'module_id' => $module->id,
            'admin_id' => Auth::id(),
            'title' => $module->title,
        ]);

        return redirect()->back()->with('success', 'Module archived successfully.');
    }

    /**
     * Unarchive a training module
     */
    public function unarchive(TrainingModule $module)
    {
        $module->update(['status' => 'draft']);

        Log::info('Training module unarchived by admin', [
            'module_id' => $module->id,
            'admin_id' => Auth::id(),
            'title' => $module->title,
        ]);

        return redirect()->back()->with('success', 'Module unarchived successfully.');
    }

    /**
     * Delete a training module (Admin can delete any module)
     */
    public function destroy(TrainingModule $trainingModule)
    {
        try {
            // Admin can delete any module, including orphaned ones
            $trainingModule->delete();
            
            return redirect()->route('admin.training-modules.index')
                ->with('success', 'Training module deleted successfully!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete training module. Please try again.');
        }
    }

    /**
     * Clean up orphaned modules (Admin only)
     */
    public function cleanupOrphaned()
    {
        try {
            // Find orphaned modules
            $orphanedModules = DB::table('training_modules as tm')
                ->leftJoin('users as u', 'tm.bdsp_id', '=', 'u.id')
                ->whereNull('u.id')
                ->orWhere('u.role', '!=', 'bdsp')
                ->select('tm.id', 'tm.title')
                ->get();

            if ($orphanedModules->isNotEmpty()) {
                foreach ($orphanedModules as $module) {
                    DB::table('training_modules')->where('id', $module->id)->delete();
                }
                
                return back()->with('success', "Cleaned up {$orphanedModules->count()} orphaned modules.");
            }
            
            return back()->with('info', 'No orphaned modules found.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cleanup orphaned modules: ' . $e->getMessage());
        }
    }

    /**
     * Get training module analytics
     */
    public function analytics()
    {
        // Overall statistics
        $overallStats = [
            'total_modules' => TrainingModule::count(),
            'published_modules' => TrainingModule::where('status', 'published')->count(),
            'total_enrollments' => ModuleCompletion::count(),
            'active_learners' => ModuleCompletion::distinct('entrepreneur_id')->count(),
            'completion_rate' => ModuleCompletion::where('status', 'completed')->count() / max(ModuleCompletion::count(), 1) * 100,
        ];

        // BDSP performance
        $bdspPerformance = TrainingModule::with('bdsp')
            ->selectRaw('bdsp_id, COUNT(*) as module_count, AVG(duration_weeks) as avg_duration')
            ->groupBy('bdsp_id')
            ->orderByDesc('module_count')
            ->take(10)
            ->get();

        // Module popularity
        $popularModules = TrainingModule::with('bdsp')
            ->withCount('completions')
            ->orderByDesc('completions_count')
            ->take(10)
            ->get();

        // Monthly trends
        $monthlyTrends = TrainingModule::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.training-modules.analytics', compact(
            'overallStats',
            'bdspPerformance',
            'popularModules',
            'monthlyTrends'
        ));
    }

    /**
     * Export training modules data
     */
    public function export(Request $request)
    {
        $modules = TrainingModule::with(['bdsp', 'weeks'])
            ->when($request->filled('status'), function($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->get();

        // For now, return JSON. In production, you'd want CSV/Excel export
        return response()->json([
            'modules' => $modules,
            'exported_at' => now()->toISOString(),
        ]);
    }
}
