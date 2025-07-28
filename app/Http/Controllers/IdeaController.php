<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            $ideas = Idea::with('user')->latest()->paginate(12);
        } else {
            $ideas = Idea::with('user')->where('status', 'approved')->latest()->paginate(12);
        }
        return view('ideas.index', compact('ideas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ideas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'problem_statement' => 'required|string',
            'proposed_solution' => 'nullable|string',
            'sector' => 'nullable|string|max:255',
            'target_beneficiaries' => 'nullable|string',
            'urgency_level' => 'required|in:low,medium,high',
            'related_sdgs' => 'nullable|array',
            'related_sdgs.*' => 'integer|min:1|max:17',
            'tags' => 'nullable|string|max:500',
        ]);
        
        $data['user_id'] = Auth::id();
        $data['status'] = 'open'; // Default status for new ideas
        
        // Handle description field (required by original table structure)
        $data['description'] = $data['problem_statement']; // Use problem_statement as description
        
        // Convert SDGs array to JSON if provided
        if (isset($data['related_sdgs'])) {
            $data['related_sdgs'] = json_encode($data['related_sdgs']);
        }
        
        $idea = Idea::create($data);
        return redirect()->route('ideas.show', $idea)->with('success', 'Idea submitted successfully! It will be reviewed by our team.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        $idea->load(['user', 'comments.user', 'pitches.user', 'votes']);
        return view('ideas.show', compact('idea'));
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        if (Auth::id() !== $idea->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }
        $idea->delete();
        return redirect()->route('ideas.index')->with('success', 'Idea deleted.');
    }

    // Admin moderation methods
    public function approve(Idea $idea)
    {
        if (!auth()->user()->isAdmin()) abort(403);
        $idea->status = 'approved';
        $idea->save();
        return back()->with('success', 'Idea approved!');
    }

    public function reject(Idea $idea)
    {
        if (!auth()->user()->isAdmin()) abort(403);
        $idea->status = 'rejected';
        $idea->save();
        return back()->with('success', 'Idea rejected.');
    }
}
