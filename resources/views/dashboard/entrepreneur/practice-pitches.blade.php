@extends('layouts.entrepreneur')
@section('title', 'Practice Your Pitch')
@section('content')
<div class="max-w-3xl mx-auto mt-10 space-y-10">
    <h2 class="text-2xl font-bold mb-4">Practice Your Pitch</h2>
    <!-- Upload Form -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Submit a Practice Pitch</h3>
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('practice-pitches.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Title</label>
                <input type="text" name="title" class="form-input w-full rounded-md" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Description</label>
                <textarea name="description" class="form-input w-full rounded-md" rows="3"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Upload File (Video, Audio, or PDF)</label>
                <input type="file" name="file" class="form-input w-full rounded-md" accept=".mp4,.mp3,.pdf" required>
                <span class="text-xs text-gray-400">Max 50MB. Accepted: mp4, mp3, pdf.</span>
            </div>
            <div class="mb-4 flex items-center gap-2">
                <input type="checkbox" name="feedback_requested" id="feedback_requested" value="1">
                <label for="feedback_requested" class="text-sm">Request feedback from a mentor or BDSP</label>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-[#b81d8f] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Submit Pitch</button>
            </div>
        </form>
    </div>
    <!-- Pitch History -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Your Previous Practice Pitches</h3>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Feedback</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pitches as $pitch)
                    <tr>
                        <td class="px-4 py-2 font-semibold">{{ $pitch->title }}</td>
                        <td class="px-4 py-2">
                            @if(Str::contains($pitch->file_type, 'mp4'))
                                <video src="{{ asset('storage/' . $pitch->file_path) }}" controls class="h-8 w-16"></video>
                            @elseif(Str::contains($pitch->file_type, 'mp3'))
                                <audio src="{{ asset('storage/' . $pitch->file_path) }}" controls></audio>
                            @elseif(Str::contains($pitch->file_type, 'pdf'))
                                <a href="{{ asset('storage/' . $pitch->file_path) }}" target="_blank" class="text-blue-600 underline">View PDF</a>
                            @else
                                <a href="{{ asset('storage/' . $pitch->file_path) }}" target="_blank" class="text-blue-600 underline">Download</a>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($pitch->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Pending</span>
                            @elseif($pitch->status === 'approved')
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Approved</span>
                            @elseif($pitch->status === 'rejected')
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">Rejected</span>
                            @elseif($pitch->status === 'reviewed')
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Reviewed</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">
                            @if($pitch->status === 'rejected')
                                <span class="text-red-600">{{ $pitch->admin_feedback }}</span>
                            @elseif($pitch->status === 'reviewed')
                                <span class="text-green-700">{{ $pitch->feedback }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-xs text-gray-500">{{ $pitch->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-400 py-8">No practice pitches submitted yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 