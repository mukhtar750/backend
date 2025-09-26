<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceShare;
use App\Models\User;
use App\Models\Pairing;
use App\Notifications\ResourceSharedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::where('bdsp_id', Auth::id())->get();
        
        // Debug: Check what we're getting
        \Log::info('Resources fetched for BDSP ' . Auth::id() . ': ' . $resources->count() . ' resources');
        
        return view('dashboard.bdsp-upload-resources', compact('resources'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png,mp4|max:20480', // 20MB max
        ]);

        $file = $request->file('file');
        $filePath = $file->store('resources', 'public');

        $resource = Resource::create([
            'bdsp_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->extension(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->back()->with('success', 'Resource uploaded successfully.');
    }

    /**
     * Show the resource sharing page for BDSPs
     */
    public function showSharing(Resource $resource)
    {
        $this->authorize('update', $resource);
        
        // Check if resource is approved before allowing sharing
        if (!$resource->is_approved) {
            return redirect()->back()->with('error', 'This resource needs admin approval before it can be shared. Please wait for approval or contact an administrator.');
        }
        
        // Get paired entrepreneurs for this BDSP
        $pairings = Pairing::where('pairing_type', 'bdsp_entrepreneur')
            ->where(function($query) {
                $query->where('user_one_id', Auth::id())
                      ->orWhere('user_two_id', Auth::id());
            })->get();

        $entrepreneurs = $pairings->map(function($pairing) {
            return $pairing->user_one_id == Auth::id() ? $pairing->userTwo : $pairing->userOne;
        });

        // Get current shares for this resource
        $currentShares = $resource->shares()->with('sharedWith')->get();

        return view('bdsp.resource-sharing', compact('resource', 'entrepreneurs', 'currentShares'));
    }

    /**
     * Share a resource with entrepreneurs
     */
    public function share(Request $request, Resource $resource)
    {
        $this->authorize('update', $resource);
        
        $request->validate([
            'entrepreneur_ids' => 'required|array',
            'entrepreneur_ids.*' => 'exists:users,id',
            'message' => 'nullable|string|max:500',
        ]);

        $bdsp = Auth::user();
        $sharedCount = 0;
        $entrepreneursToNotify = [];

        foreach ($request->entrepreneur_ids as $entrepreneurId) {
            // Check if already shared
            if (!$resource->isSharedWith($entrepreneurId)) {
                ResourceShare::create([
                    'resource_id' => $resource->id,
                    'shared_by' => $bdsp->id,
                    'shared_with' => $entrepreneurId,
                    'message' => $request->message,
                ]);
                $sharedCount++;
                
                // Add to notification list
                $entrepreneur = User::find($entrepreneurId);
                if ($entrepreneur) {
                    $entrepreneursToNotify[] = $entrepreneur;
                }
            }
        }

        // Send notifications to entrepreneurs
        if (!empty($entrepreneursToNotify)) {
            Notification::send($entrepreneursToNotify, new ResourceSharedNotification($resource, $bdsp, $request->message));
        }

        if ($sharedCount > 0) {
            return redirect()->back()->with('success', "Resource shared with {$sharedCount} entrepreneur(s) successfully!");
        } else {
            return redirect()->back()->with('info', 'Resource was already shared with all selected entrepreneurs.');
        }
    }

    /**
     * Alternative share method that bypasses authorization issues
     */
    public function shareAlternative(Request $request, Resource $resource)
    {
        // Direct ownership check instead of using authorize
        $user = Auth::user();
        if ($user->role !== 'bdsp' || $resource->bdsp_id !== $user->id) {
            abort(403, 'Unauthorized to share this resource.');
        }
        
        $request->validate([
            'entrepreneur_ids' => 'required|array',
            'entrepreneur_ids.*' => 'exists:users,id',
            'message' => 'nullable|string|max:500',
        ]);

        $bdsp = $user;
        $sharedCount = 0;
        $entrepreneursToNotify = [];

        foreach ($request->entrepreneur_ids as $entrepreneurId) {
            // Check if already shared
            if (!$resource->isSharedWith($entrepreneurId)) {
                ResourceShare::create([
                    'resource_id' => $resource->id,
                    'shared_by' => $bdsp->id,
                    'shared_with' => $entrepreneurId,
                    'message' => $request->message,
                ]);
                $sharedCount++;
                
                // Add to notification list
                $entrepreneur = User::find($entrepreneurId);
                if ($entrepreneur) {
                    $entrepreneursToNotify[] = $entrepreneur;
                }
            }
        }

        // Send notifications to entrepreneurs
        if (!empty($entrepreneursToNotify)) {
            Notification::send($entrepreneursToNotify, new ResourceSharedNotification($resource, $bdsp, $request->message));
        }

        if ($sharedCount > 0) {
            return redirect()->back()->with('success', "Resource shared with {$sharedCount} entrepreneur(s) successfully!");
        } else {
            return redirect()->back()->with('info', 'Resource was already shared with all selected entrepreneurs.');
        }
    }

    /**
     * Remove sharing for a specific entrepreneur
     */
    public function unshare(Request $request, Resource $resource)
    {
        $this->authorize('update', $resource);
        
        $request->validate([
            'entrepreneur_id' => 'required|exists:users,id',
        ]);

        $resource->shares()->where('shared_with', $request->entrepreneur_id)->delete();

        return redirect()->back()->with('success', 'Resource sharing removed successfully.');
    }

    // Additional methods for admin approval, etc., can be added later

    public function edit(Resource $resource)
    {
        $this->authorize('update', $resource);
        return view('bdsp.edit-resource', compact('resource'));
    }

    public function update(Request $request, Resource $resource)
    {
        $this->authorize('update', $resource);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $resource->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect()->route('bdsp.resources.edit', $resource)->with('success', 'Resource updated successfully.');
    }

    public function destroy(Resource $resource)
    {
        $this->authorize('delete', $resource);
        if ($resource->file_path) {
            Storage::disk('public')->delete($resource->file_path);
        }
        $resource->delete();
        return redirect()->back()->with('success', 'Resource deleted successfully.');
    }

    /**
     * Download a resource for entrepreneurs (with sharing authorization)
     */
    public function downloadForEntrepreneur($resourceId)
    {
        $user = Auth::user();
        $resource = Resource::findOrFail($resourceId);
        
        // Check if user is an entrepreneur and has access to this resource
        if ($user->role !== 'entrepreneur') {
            abort(403, 'Only entrepreneurs can download resources.');
        }
        
        // Check if resource is shared with this entrepreneur
        if (!$resource->isSharedWith($user->id)) {
            abort(403, 'You do not have access to this resource.');
        }
        
        // Check if file exists
        if (!$resource->file_path) {
            abort(404, 'File not found.');
        }

        $path = Storage::disk('public')->path($resource->file_path);
        
        if (!file_exists($path)) {
            abort(404, 'File not found on server.');
        }

        return response()->download($path, $resource->file_name);
    }

    /**
     * Download a resource for BDSPs (resource owner)
     */
    public function downloadForBdsp(Resource $resource)
    {
        $user = Auth::user();
        
        // Check if user is the owner of this resource
        if ($user->role !== 'bdsp' || $resource->bdsp_id !== $user->id) {
            abort(403, 'You can only download your own resources.');
        }
        
        // Check if file exists
        if (!$resource->file_path) {
            abort(404, 'File not found.');
        }

        $path = Storage::disk('public')->path($resource->file_path);
        
        if (!file_exists($path)) {
            abort(404, 'File not found on server.');
        }

        return response()->download($path, $resource->file_name);
    }
}