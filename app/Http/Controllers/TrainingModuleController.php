<?php

namespace App\Http\Controllers;

use App\Models\TrainingModule;
use App\Models\ModuleWeek;
use App\Models\WeekProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainingModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // BDSP Dashboard - List all their modules
    public function index()
    {
        $modules = TrainingModule::where('bdsp_id', Auth::id())
            ->with(['weeks', 'progress'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bdsp.training-modules.index', compact('modules'));
    }

    // Show module creation form
    public function create()
    {
        return view('bdsp.training-modules.create');
    }

    // Store new module
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'total_hours' => 'required|integer|min:1|max:1000',
            'target_audience' => 'nullable|string|max:255',
            'prerequisites' => 'nullable|string',
            'learning_objectives' => 'nullable|string',
            'weeks' => 'required|array|min:1',
            'weeks.*.title' => 'required|string|max:255',
            'weeks.*.topics' => 'required|string',
            'weeks.*.hours_required' => 'required|integer|min:1|max:168',
            'weeks.*.learning_materials' => 'nullable|string',
            'weeks.*.week_objectives' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Create the module
            $module = TrainingModule::create([
                'bdsp_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'duration_weeks' => $request->duration_weeks,
                'total_hours' => $request->total_hours,
                'target_audience' => $request->target_audience,
                'prerequisites' => $request->prerequisites,
                'learning_objectives' => $request->learning_objectives,
                'status' => 'draft',
            ]);

            // Create the weeks
            foreach ($request->weeks as $index => $weekData) {
                ModuleWeek::create([
                    'module_id' => $module->id,
                    'week_number' => $index + 1,
                    'title' => $weekData['title'],
                    'topics' => $weekData['topics'],
                    'hours_required' => $weekData['hours_required'],
                    'learning_materials' => $weekData['learning_materials'] ?? null,
                    'week_objectives' => $weekData['week_objectives'] ?? null,
                    'order' => $index,
                ]);
            }

            DB::commit();

            return redirect()->route('bdsp.training-modules.index')
                ->with('success', 'Training module created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create training module. Please try again.');
        }
    }

    // Show module details
    public function show(TrainingModule $module)
    {
        $this->authorize('view', $module);

        $module->load(['weeks', 'bdsp']);
        
        // Initialize progress variables
        $progress = null;
        $overallProgress = null;
        
        if (Auth::user()->role === 'entrepreneur') {
            $progress = $module->getProgressForEntrepreneur(Auth::id());
            $overallProgress = $module->getOverallProgressForEntrepreneur(Auth::id());
            
            // Return entrepreneur view
            return view('entrepreneur.training-modules.show', compact('module', 'progress', 'overallProgress'));
        }
        
        // Return BDSP view for BDSP users
        return view('bdsp.training-modules.show', compact('module', 'progress', 'overallProgress'));
    }

    /**
     * Show module for entrepreneurs (separate method for clarity)
     */
    public function entrepreneurShow(TrainingModule $module)
    {
        $this->authorize('view', $module);

        $module->load(['weeks', 'bdsp']);
        
        // Get progress for this entrepreneur
        $progress = $module->getProgressForEntrepreneur(Auth::id());
        $overallProgress = $module->getOverallProgressForEntrepreneur(Auth::id());
        
        // If no progress exists yet, create a default progress object for the view
        if (!$progress) {
            $progress = (object) [
                'progress_percentage' => 0,
                'current_week' => 1,
                'status' => 'not_started',
                'completion_notes' => null,
                'started_at' => null,
                'completed_at' => null,
            ];
        }
        
        return view('entrepreneur.training-modules.show', compact('module', 'progress', 'overallProgress'));
    }

    // Show edit form
    public function edit(TrainingModule $module)
    {
        $this->authorize('update', $module);

        $module->load('weeks');
        return view('bdsp.training-modules.edit', compact('module'));
    }

    // Update module
    public function update(Request $request, TrainingModule $module)
    {
        $this->authorize('update', $module);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'total_hours' => 'required|integer|min:1|max:1000',
            'target_audience' => 'nullable|string|max:255',
            'prerequisites' => 'nullable|string',
            'learning_objectives' => 'nullable|string',
            'weeks' => 'required|array|min:1',
            'weeks.*.title' => 'required|string|max:255',
            'weeks.*.topics' => 'required|string',
            'weeks.*.hours_required' => 'required|integer|min:1|max:168',
            'weeks.*.learning_materials' => 'nullable|string',
            'weeks.*.week_objectives' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Update the module
            $module->update([
                'title' => $request->title,
                'description' => $request->description,
                'duration_weeks' => $request->duration_weeks,
                'total_hours' => $request->total_hours,
                'target_audience' => $request->target_audience,
                'prerequisites' => $request->prerequisites,
                'learning_objectives' => $request->learning_objectives,
            ]);

            // Delete existing weeks and recreate
            $module->weeks()->delete();

            foreach ($request->weeks as $index => $weekData) {
                ModuleWeek::create([
                    'module_id' => $module->id,
                    'week_number' => $index + 1,
                    'title' => $weekData['title'],
                    'topics' => $weekData['topics'],
                    'hours_required' => $weekData['hours_required'],
                    'learning_materials' => $weekData['learning_materials'] ?? null,
                    'week_objectives' => $weekData['week_objectives'] ?? null,
                    'order' => $index,
                ]);
            }

            DB::commit();

            return redirect()->route('bdsp.training-modules.show', $module)
                ->with('success', 'Training module updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update training module. Please try again.');
        }
    }

    // Publish module
    public function publish(TrainingModule $module)
    {
        $this->authorize('update', $module);

        if ($module->weeks()->count() === 0) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Cannot publish module without any weeks.'], 400);
            }
            return back()->with('error', 'Cannot publish module without any weeks.');
        }

        $module->update(['status' => 'published']);

        if (request()->expectsJson()) {
            return response()->json(['success' => 'Module published successfully!']);
        }
        return back()->with('success', 'Module published successfully!');
    }

    // Archive module
    public function archive(TrainingModule $module)
    {
        $this->authorize('update', $module);

        $module->update(['status' => 'archived']);

        if (request()->expectsJson()) {
            return response()->json(['success' => 'Module archived successfully!']);
        }
        return back()->with('success', 'Module archived successfully!');
    }

    // Unarchive module
    public function unarchive(TrainingModule $module)
    {
        $this->authorize('update', $module);

        $module->update(['status' => 'draft']);

        if (request()->expectsJson()) {
            return response()->json(['success' => 'Module unarchived successfully!']);
        }
        return back()->with('success', 'Module unarchived successfully!');
    }

    // Delete module
    public function destroy(TrainingModule $module)
    {
        $this->authorize('delete', $module);

        $module->delete();

        return redirect()->route('bdsp.training-modules.index')
            ->with('success', 'Training module deleted successfully!');
    }

    // Entrepreneur progress tracking
    public function trackProgress(TrainingModule $module)
    {
        if (Auth::user()->role !== 'entrepreneur') {
            abort(403);
        }

        $this->authorize('view', $module);

        $progress = $module->getProgressForEntrepreneur(Auth::id());
        $overallProgress = $module->getOverallProgressForEntrepreneur(Auth::id());

        return view('entrepreneur.module-progress', compact('module', 'progress', 'overallProgress'));
    }

    // Entrepreneur index - Show accessible modules
    public function entrepreneurIndex()
    {
        if (Auth::user()->role !== 'entrepreneur') {
            abort(403);
        }

        $modules = Auth::user()->getAccessibleModules();
        
        return view('entrepreneur.training-modules', compact('modules'));
    }

    // Update week progress
    public function updateWeekProgress(Request $request, TrainingModule $module, ModuleWeek $week)
    {
        if (Auth::user()->role !== 'entrepreneur') {
            abort(403);
        }

        $request->validate([
            'completion_percentage' => 'required|integer|min:0|max:100',
            'time_spent' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $progress = WeekProgress::updateOrCreate(
            [
                'module_id' => $module->id,
                'entrepreneur_id' => Auth::id(),
                'week_id' => $week->id,
            ],
            [
                'completion_percentage' => $request->completion_percentage,
                'time_spent' => $request->time_spent ?? 0,
                'notes' => $request->notes,
            ]
        );

        $progress->updateProgress($request->completion_percentage, $request->time_spent);

        return back()->with('success', 'Progress updated successfully!');
    }
}
