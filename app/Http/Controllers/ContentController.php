<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:document,video,image,template,article,announcement',
            'category_id' => 'nullable|exists:categories,id',
            'visibility' => 'required|in:public,entrepreneurs,mentors,investors,admin',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,mp4,jpg,jpeg,png|max:102400',
            'status' => 'required|in:draft,published,pending,rejected',
        ]);

        $filePath = null;
        $fileType = null;
        $fileSize = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('contents', 'public');
            $fileType = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
        }

        $content = Content::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'category_id' => $validated['category_id'] ?? null,
            'visibility' => $validated['visibility'],
            'description' => $validated['description'] ?? null,
            'tags' => $validated['tags'] ?? null,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'status' => $validated['status'],
            'user_id' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'content' => $content]);
    }

    public function index()
    {
        $categories = \DB::table('categories')->get();
        $contents = Content::orderByDesc('created_at')->get();
        $status = null;
        $resources = \App\Models\Resource::with('bdsp')->orderByDesc('created_at')->paginate(20);
        return view('admin.content_management', [
            'contents' => $contents,
            'resources' => $resources,
            'status' => $status,
            'categories' => $categories,
        ]);
    }
    public function edit($id)
    {
        $content = Content::findOrFail($id);
        return response()->json(['content' => $content]);
    }

    public function update(Request $request, $id)
    {
        $content = Content::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:document,video,image,template,article,announcement',
            'category_id' => 'nullable|exists:categories,id',
            'visibility' => 'required|in:public,entrepreneurs,mentors,investors,admin',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,mp4,jpg,jpeg,png|max:102400',
            'status' => 'required|in:draft,published,pending,rejected',
        ]);
        // Handle file replacement
        if ($request->hasFile('file')) {
            if ($content->file_path) {
                \Storage::disk('public')->delete($content->file_path);
            }
            $file = $request->file('file');
            $validated['file_path'] = $file->store('contents', 'public');
            $validated['file_type'] = $file->getClientOriginalExtension();
            $validated['file_size'] = $file->getSize();
        }
        $content->update($validated);
        return response()->json(['success' => true, 'content' => $content]);
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        if ($content->file_path) {
            \Storage::disk('public')->delete($content->file_path);
        }
        $content->delete();
        return response()->json(['success' => true]);
    }
}
