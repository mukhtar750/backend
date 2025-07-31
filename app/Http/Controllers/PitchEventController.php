<?php

namespace App\Http\Controllers;

use App\Models\PitchEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\PitchEventNotification;

class PitchEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = PitchEvent::with('creator')->orderBy('event_date', 'desc')->get();
        return view('admin.pitch_events', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = PitchEvent::with('creator')->orderBy('event_date', 'desc')->get();
        return view('admin.pitch_events', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Decode JSON string fields to arrays if needed
        foreach (['agenda', 'requirements', 'prizes'] as $field) {
            if ($request->has($field) && is_string($request->$field)) {
                $decoded = json_decode($request->$field, true);
                if (is_array($decoded)) {
                    $request->merge([$field => $decoded]);
                }
            }
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'event_type' => 'required|in:virtual,in-person,hybrid',
            'capacity' => 'nullable|integer|min:1',
            'registration_deadline' => 'nullable|date|before:event_date',
            'status' => 'required|in:draft,published,cancelled',
            'featured_startups' => 'nullable|array',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'agenda' => 'nullable|array',
            'requirements' => 'nullable|array',
            'prizes' => 'nullable|array',
            'tags' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pitch_events', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Set created_by to current user
        $validated['created_by'] = Auth::id();

        // Create the event
        $event = PitchEvent::create($validated);

        // Notify all approved investors if published
        if ($event->status === 'published') {
            $investors = User::where('role', 'investor')->where('is_approved', true)->get();
            foreach ($investors as $investor) {
                $investor->notify(new PitchEventNotification($event));
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Pitch event created successfully!',
            'event' => $event->load('creator')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = PitchEvent::with('creator')->findOrFail($id);
        return view('admin.pitch_events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = PitchEvent::findOrFail($id);
        return view('admin.pitch_events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = PitchEvent::findOrFail($id);
        // Decode JSON string fields to arrays if needed
        foreach (['agenda', 'requirements', 'prizes'] as $field) {
            if ($request->has($field) && is_string($request->$field)) {
                $decoded = json_decode($request->$field, true);
                if (is_array($decoded)) {
                    $request->merge([$field => $decoded]);
                }
            }
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'event_type' => 'required|in:virtual,in-person,hybrid',
            'capacity' => 'nullable|integer|min:1',
            'registration_deadline' => 'nullable|date|before:event_date',
            'status' => 'required|in:draft,published,cancelled',
            'featured_startups' => 'nullable|array',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'agenda' => 'nullable|array',
            'requirements' => 'nullable|array',
            'prizes' => 'nullable|array',
            'tags' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }
            $imagePath = $request->file('image')->store('pitch_events', 'public');
            $validated['image_path'] = $imagePath;
        }

        $event->update($validated);

        // Notify all approved investors if status is now published
        if ($event->status === 'published') {
            $investors = User::where('role', 'investor')->where('is_approved', true)->get();
            foreach ($investors as $investor) {
                $investor->notify(new PitchEventNotification($event));
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Pitch event updated successfully!',
            'event' => $event->load('creator')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = PitchEvent::findOrFail($id);
        
        // Delete image if exists
        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }
        
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pitch event deleted successfully!'
        ]);
    }

    public function register($eventId)
    {
        $event = \App\Models\PitchEvent::findOrFail($eventId);
        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'You must be logged in to register.'], 401);
        }
        $alreadyRegistered = $event->confirmedParticipants()->where('user_id', $userId)->exists();
        if ($alreadyRegistered) {
            return response()->json(['success' => false, 'message' => 'You are already registered for this event.'], 409);
        }
        $event->participants()->create([
            'user_id' => $userId,
            'status' => 'confirmed',
            'registered_at' => now(),
        ]);
        return redirect()->back()->with('success', 'You have successfully registered for the event!');
    }
}
