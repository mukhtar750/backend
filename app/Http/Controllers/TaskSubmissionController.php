<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // Submit a task (by assignee)
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'file' => 'nullable|file|max:10240',
            'notes' => 'nullable|string|max:2000',
        ]);
        if (Auth::id() !== $task->assignee_id) {
            abort(403);
        }
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('task_submissions', 'public');
        }
        $submission = TaskSubmission::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'file_path' => $filePath,
            'notes' => $request->notes,
            'submitted_at' => now(),
            'status' => 'pending',
        ]);
        // TODO: Notify assigner
        $task->assigner->notify(new \App\Notifications\TaskSubmissionNotification($submission));
        return redirect()->back()->with('success', 'Submission uploaded!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskSubmission $submission)
    {
        $user = Auth::user();
        if ($user->id !== $submission->user_id && $user->id !== $submission->task->assigner_id) {
            abort(403);
        }
        return view('tasks.submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    // Review a submission (by assigner)
    public function review(Request $request, TaskSubmission $submission)
    {
        $request->validate([
            'feedback' => 'nullable|string|max:2000',
            'grade' => 'nullable|string|max:20',
        ]);
        $user = Auth::user();
        if ($user->id !== $submission->task->assigner_id) {
            abort(403);
        }
        $submission->feedback = $request->feedback;
        $submission->grade = $request->grade;
        $submission->status = 'reviewed';
        $submission->reviewed_by = $user->id;
        $submission->reviewed_at = now();
        $submission->save();
        // TODO: Notify assignee
        $submission->user->notify(new \App\Notifications\TaskGradedNotification($submission));
        return redirect()->back()->with('success', 'Feedback and grade submitted!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
