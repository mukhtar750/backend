<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display the entrepreneur's tasks and assignments
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get tasks assigned to this entrepreneur
        $tasksQuery = Task::where('assignee_id', $user->id);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status != 'all') {
            $tasksQuery->where('status', $request->status);
        }
        
        // Filter by priority if provided
        if ($request->has('priority') && $request->priority != 'all') {
            $tasksQuery->where('priority', $request->priority);
        }
        
        // Sort tasks
        $sort = $request->get('sort', 'due_date');
        $direction = $request->get('direction', 'asc');
        
        $tasksQuery->orderBy($sort, $direction);
        
        $tasks = $tasksQuery->paginate(10);
        
        // Get task counts for summary cards
        $totalTasks = Task::where('assignee_id', $user->id)->count();
        $completedTasks = Task::where('assignee_id', $user->id)->where('status', 'completed')->count();
        $inProgressTasks = Task::where('assignee_id', $user->id)->where('status', 'in_progress')->count();
        $overdueTasks = Task::where('assignee_id', $user->id)
            ->where('status', '!=', 'completed')
            ->where('due_date', '<', now())
            ->count();
        
        return view('entrepreneur.tasks', compact(
            'tasks', 
            'totalTasks', 
            'completedTasks', 
            'inProgressTasks', 
            'overdueTasks'
        ));
    }
    
    /**
     * Mark a task as completed
     */
    public function markAsCompleted(Task $task)
    {
        // Check if the authenticated user is the assignee of this task
        if ((int)Auth::id() !== (int)$task->assignee_id) {
            return redirect()->back()->with('error', 'You are not authorized to update this task.');
        }
        
        $task->status = 'completed';
        $task->completed_at = now();
        $task->save();
        
        return redirect()->back()->with('success', 'Task marked as completed!');
    }
    
    /**
     * Mark a task as in progress
     */
    public function markAsInProgress(Task $task)
    {
        // Check if the authenticated user is the assignee of this task
        if ((int)Auth::id() !== (int)$task->assignee_id) {
            return redirect()->back()->with('error', 'You are not authorized to update this task.');
        }
        
        $task->status = 'in_progress';
        $task->save();
        
        return redirect()->back()->with('success', 'Task marked as in progress!');
    }
    
    
    /**
     * Admin method to update a task
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assignee_id' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);
        
        $task->title = $request->title;
        $task->description = $request->description;
        $task->assignee_id = $request->assignee_id;
        $task->due_date = $request->due_date;
        $task->priority = $request->priority;
        $task->status = $request->status;
        
        if ($request->status === 'completed' && !$task->completed_at) {
            $task->completed_at = now();
        }
        
        $task->save();
        
        return redirect()->back()->with('success', 'Task updated successfully!');
    }
    
    /**
     * Admin method to delete a task
     */
    public function destroy(Task $task)
    {
        $task->delete();
        
        return redirect()->back()->with('success', 'Task deleted successfully!');
    }

    // BDSP: View tasks assigned by this BDSP
    public function bdspIndex()
    {
        $user = auth()->user();
        $tasks = \App\Models\Task::with('assignees')->where('assigner_id', $user->id)->orderBy('due_date')->get();
        return view('bdsp.tasks', compact('tasks'));
    }

    // Mentor: View tasks assigned by this Mentor
    public function mentorIndex()
    {
        $user = auth()->user();
        $tasks = \App\Models\Task::where('assigner_id', $user->id)->orderBy('due_date')->get();
        return view('mentor.tasks', compact('tasks'));
    }

    public function create()
    {
        try {
            $user = auth()->user();
            
            // Get all users this user is paired with, with eager loading
            $pairings = $user->allPairings()
                ->with(['userOne', 'userTwo'])
                ->get();
            
            // Extract unique users from pairings
            $pairedUsers = $pairings->map(function($pairing) use ($user) {
                return $pairing->user_one_id == $user->id 
                    ? $pairing->userTwo 
                    : $pairing->userOne;
            })->filter() // Remove nulls
             ->unique('id')
             ->values(); // Reset keys
            
            return view('tasks.create', compact('pairedUsers'));
            
        } catch (\Exception $e) {
            \Log::error('Error in TaskController@create: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load task creation form. Please try again.');
        }
    }
    
    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assignees' => 'required|array|min:1',
            'assignees.*' => 'exists:users,id',
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
        ]);
        
        // Start a database transaction
        \DB::beginTransaction();
        
        try {
            // Create the task
            $task = new Task();
            $task->fill([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'assigner_id' => auth()->id(),
                'due_date' => $validated['due_date'],
                'priority' => $validated['priority'],
                'status' => 'pending',
            ]);
            
            $task->save();
            
            // Prepare assignee data
            $assigneeData = collect($validated['assignees'])
                ->mapWithKeys(fn($id) => [
                    $id => [
                        'status' => 'pending',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ])->toArray();
            
            // Attach assignees
            $task->assignees()->syncWithoutDetaching($assigneeData);
            
            // Load assignees for notification
            $assignees = \App\Models\User::whereIn('id', $validated['assignees'])->get();
            
            // Commit the transaction
            \DB::commit();
            
            // Send notifications
            foreach ($assignees as $assignee) {
                $assignee->notify(new \App\Notifications\AssignmentAssignedNotification($task));
            }
            
            return redirect()->back()
                ->with('success', 'Task created and assigned successfully!');
                
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Task creation failed: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create task. Please try again.');
        }
    }
}