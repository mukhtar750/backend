<?php

namespace App\Http\Controllers;

use App\Models\Pitch;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PitchController extends Controller
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
        $user = Auth::user();
        if ($user->role !== 'entrepreneur') {
            abort(403);
        }
        $exists = Pitch::where('idea_id', $idea->id)->where('user_id', $user->id)->first();
        if ($exists) {
            return back()->with('error', 'You have already pitched this idea.');
        }
        $data = $request->validate([
            'content' => 'required|string|max:2000',
        ]);
        $data['user_id'] = $user->id;
        $data['idea_id'] = $idea->id;
        $data['status'] = 'pending';
        Pitch::create($data);
        return back()->with('success', 'Pitch submitted for review!');
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

    public function approve(Pitch $pitch)
    {
        if (!auth()->user()->isAdmin()) abort(403);
        $pitch->status = 'approved';
        $pitch->save();
        return back()->with('success', 'Pitch approved!');
    }

    public function reject(Pitch $pitch)
    {
        if (!auth()->user()->isAdmin()) abort(403);
        $pitch->status = 'rejected';
        $pitch->save();
        return back()->with('success', 'Pitch rejected.');
    }
}
