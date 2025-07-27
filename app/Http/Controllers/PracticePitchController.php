<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PracticePitch;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\PracticePitchStatusNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

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
        try {
            \Log::info('Practice pitch upload started', [
                'user_id' => Auth::id(),
                'file_size' => $request->file('file') ? $request->file('file')->getSize() : 'no file',
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
            ]);

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'file' => 'required|file|mimes:mp4,mp3,pdf|max:51200',
                'feedback_requested' => 'nullable|boolean',
            ]);

            $file = $request->file('file');
            
            // Check if storage is working
            if (!Storage::disk('public')->exists('practice_pitches')) {
                Storage::disk('public')->makeDirectory('practice_pitches');
            }
            
            $filePath = $file->store('practice_pitches', 'public');
            
            \Log::info('File stored successfully', ['path' => $filePath]);
            
            $pitch = PracticePitch::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'feedback_requested' => $request->boolean('feedback_requested'),
                'status' => 'pending',
            ]);

            \Log::info('Practice pitch created', ['pitch_id' => $pitch->id]);

            // Notify all admins/staff
            $admins = User::whereIn('role', ['admin', 'staff'])->get();
            Notification::send($admins, new PracticePitchStatusNotification($pitch, 'admin_new'));

            return redirect()->back()->with('success', 'Pitch submitted and pending admin approval.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Practice pitch validation failed', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Practice pitch upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['file' => 'Upload failed: ' . $e->getMessage()]);
        }
    }

    // Admin: List all pitches grouped by status
    public function adminIndex()
    {
        $pendingPitches = PracticePitch::with('user')->where('status', 'pending')->orderByDesc('created_at')->get();
        $approvedPitches = PracticePitch::with('user')->where('status', 'approved')->orderByDesc('created_at')->get();
        $rejectedPitches = PracticePitch::with('user')->where('status', 'rejected')->orderByDesc('created_at')->get();
        $reviewedPitches = PracticePitch::with('user')->where('status', 'reviewed')->orderByDesc('created_at')->get();
        return view('admin.practice-pitches.index', compact('pendingPitches', 'approvedPitches', 'rejectedPitches', 'reviewedPitches'));
    }

    // Admin: Approve a pitch
    public function approve($id)
    {
        $pitch = PracticePitch::findOrFail($id);
        $pitch->status = 'approved';
        $pitch->approved_by = Auth::id();
        $pitch->admin_feedback = null;
        $pitch->save();

        // Notify entrepreneur
        $pitch->user->notify(new PracticePitchStatusNotification($pitch, 'entrepreneur_approved'));

        // If feedback is requested, notify mentors/BDSPs
        if ($pitch->feedback_requested) {
            $mentors = User::whereIn('role', ['mentor', 'bdsp'])->get();
            Notification::send($mentors, new PracticePitchStatusNotification($pitch, 'mentor_new'));
        }

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

        // Notify entrepreneur
        $pitch->user->notify(new PracticePitchStatusNotification($pitch, 'entrepreneur_rejected'));

        return redirect()->back()->with('success', 'Pitch rejected.');
    }

    // Mentor: List pitches awaiting and reviewed feedback
    public function mentorIndex()
    {
        $userId = Auth::id();
        $awaitingPitches = PracticePitch::with('user')
            ->where('status', 'approved')
            ->where('feedback_requested', true)
            ->whereNull('feedback')
            ->orderByDesc('updated_at')
            ->get();
        $reviewedPitches = PracticePitch::with('user')
            ->where('status', 'reviewed')
            ->where('reviewed_by', $userId)
            ->orderByDesc('updated_at')
            ->get();
        return view('dashboard.mentor.practice-pitches', compact('awaitingPitches', 'reviewedPitches'));
    }

    // BDSP: List pitches awaiting and reviewed feedback
    public function bdspIndex()
    {
        $userId = Auth::id();
        $awaitingPitches = PracticePitch::with('user')
            ->where('status', 'approved')
            ->where('feedback_requested', true)
            ->whereNull('feedback')
            ->orderByDesc('updated_at')
            ->get();
        $reviewedPitches = PracticePitch::with('user')
            ->where('status', 'reviewed')
            ->where('reviewed_by', $userId)
            ->orderByDesc('updated_at')
            ->get();
        return view('dashboard.bdsp.practice-pitches', compact('awaitingPitches', 'reviewedPitches'));
    }

    // Mentor/BDSP: Leave feedback on an approved pitch
    public function feedback(Request $request, $id)
    {
        $pitch = PracticePitch::findOrFail($id);

        // Security check: Only approved pitches can receive feedback
        if ($pitch->status !== 'approved') {
            return redirect()->back()->with('error', 'This pitch is not awaiting feedback.');
        }

        $request->validate([
            'feedback' => 'required|string',
        ]);

        $pitch->feedback = $request->feedback;
        $pitch->reviewed_by = Auth::id();
        $pitch->status = 'reviewed';
        $pitch->save();

        // Notify entrepreneur
        $pitch->user->notify(new PracticePitchStatusNotification($pitch, 'entrepreneur_reviewed'));

        if (Auth::user()->role === 'bdsp') {
            return redirect()->route('bdsp.practice-pitches.index')->with('success', 'Feedback submitted.');
        } else {
            return redirect()->route('mentor.practice-pitches.index')->with('success', 'Feedback submitted.');
        }
    }
}
