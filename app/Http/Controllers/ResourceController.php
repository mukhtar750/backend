<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::where('bdsp_id', Auth::id())->get();
        return view('dashboard.bdsp-upload-resources', compact('resources'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png,mp4|max:20480', // 20MB max
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
}