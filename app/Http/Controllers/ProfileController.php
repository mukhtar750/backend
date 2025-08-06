<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Show the user's profile page
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the user's profile
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Increased to 5MB
            // Role-specific validation
            'business_name' => 'nullable|string|max:255',
            'sector' => 'nullable|string|max:255',
            'entrepreneur_phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'services_provided' => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'name', 'email', 'business_name', 'sector', 'entrepreneur_phone', 
            'website', 'company', 'phone', 'organization', 'services_provided'
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            try {
                // Delete old profile picture if exists
                if ($user->profile_picture) {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                // Store new profile picture
                $file = $request->file('profile_picture');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                
                // Debug: Log the file details
                \Log::info('Profile picture upload attempt', [
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'filename' => $filename
                ]);
                
                // Use storeAs method instead of put with file_get_contents
                $uploaded = $file->storeAs('profile_pictures', $filename, 'public');
                
                // Debug: Log the upload result
                \Log::info('Profile picture upload result', [
                    'uploaded' => $uploaded,
                    'file_exists' => Storage::disk('public')->exists($uploaded),
                    'url' => Storage::disk('public')->url($uploaded)
                ]);
                
                if ($uploaded) {
                    $data['profile_picture'] = $uploaded;
                } else {
                    return redirect()->back()->with('error', 'Failed to upload profile picture. Please try again.');
                }
            } catch (\Exception $e) {
                \Log::error('Profile picture upload error: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Error uploading profile picture: ' . $e->getMessage());
            }
        }

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    /**
     * Remove the user's profile picture
     */
    public function removeProfilePicture()
    {
        $user = Auth::user();
        
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
            $user->update(['profile_picture' => null]);
        }

        return redirect()->back()->with('success', 'Profile picture removed successfully!');
    }

    /**
     * Get the user's profile picture URL
     */
    public function getProfilePicture()
    {
        $user = Auth::user();
        
        if ($user->profile_picture) {
            $baseUrl = request()->getSchemeAndHttpHost();
            return response()->json([
                'url' => $baseUrl . '/storage/' . $user->profile_picture
            ]);
        }

        return response()->json([
            'url' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7C3AED&background=EDE9FE&size=200'
        ]);
    }
}
