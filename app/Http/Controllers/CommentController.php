<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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
            'content' => 'required|string|max:1000',
        ]);
        $data['user_id'] = Auth::id();
        $data['idea_id'] = $idea->id;
        Comment::create($data);
        return back()->with('success', 'Comment posted!');
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
    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }
        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }
}
