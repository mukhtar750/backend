<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PracticePitch;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PracticePitchController extends Controller
{
    // Entrepreneur: List own pitches
    public function index()
    {
        $pitches = PracticePitch::where('user_id', Auth::id())->orderByDesc('created_at')->get();
        return view('dashboard.entrepreneur.practice-pitches', compact('pitches'));
    }

    // Entrepreneur: Submit a new pitch
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:mp4,mp3,pdf|max:51200',
            'feedback_requested' => 'nullable|boolean',
        ]);
        $file = $request->file('file');
        $filePath = $file->store('practice_pitches', 'public');
        $pitch = PracticePitch::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'feedback_requested' => $request->boolean('feedback_requested'),
            'status' => 'pending',
        ]);
        // TODO: Notify admins
        return redirect()->back()->with('success', 'Pitch submitted and pending admin approval.');
    }

    // Admin: List all pending pitches
    public function adminIndex()
    {
        $pitches = PracticePitch::where('status', 'pending')->orderByDesc('created_at')->get();
        return view('admin.practice-pitches.index', compact('pitches'));
    }

    // Admin: Approve a pitch
    public function approve($id)
    {
        $pitch = PracticePitch::findOrFail($id);
        $pitch->status = 'approved';
        $pitch->approved_by = Auth::id();
        $pitch->admin_feedback = null;
        $pitch->save();
        // TODO: Notify entrepreneur
        return redirect()->back()->with('success', 'Pitch approved.');
    }

    // Admin: Reject a pitch
    public function reject(Request $request, $id)
    {
        $pitch = PracticePitch::findOrFail($id);
        $pitch->status = 'rejected';
        $pitch->approved_by = Auth::id();
        $pitch->admin_feedback = $request->input('admin_feedback');
        $pitch->save();
        // TODO: Notify entrepreneur
        return redirect()->back()->with('success', 'Pitch rejected.');
    }

    // Mentor/BDSP: Leave feedback on an approved pitch
    public function feedback(Request $request, $id)
    {
        $pitch = PracticePitch::findOrFail($id);
        $request->validate([
            'feedback' => 'required|string',
        ]);
        $pitch->feedback = $request->feedback;
        $pitch->reviewed_by = Auth::id();
        $pitch->status = 'reviewed';
        $pitch->save();
        // TODO: Notify entrepreneur
        return redirect()->back()->with('success', 'Feedback submitted.');
    }
}
