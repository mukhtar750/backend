<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Idea $idea)
    {
        $data = $request->validate([
            'type' => 'required|in:up,down',
        ]);
        $user = Auth::user();
        $existing = Vote::where('idea_id', $idea->id)->where('user_id', $user->id)->first();
        if ($existing) {
            if ($existing->type === $data['type']) {
                // Already voted this way, do nothing
                return back();
            }
            // Change vote
            if ($existing->type === 'up') {
                $idea->decrement('upvotes');
            } else {
                $idea->decrement('downvotes');
            }
            $existing->type = $data['type'];
            $existing->save();
        } else {
            $vote = new Vote([
                'idea_id' => $idea->id,
                'user_id' => $user->id,
                'type' => $data['type'],
            ]);
            $vote->save();
        }
        if ($data['type'] === 'up') {
            $idea->increment('upvotes');
        } else {
            $idea->increment('downvotes');
        }
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
