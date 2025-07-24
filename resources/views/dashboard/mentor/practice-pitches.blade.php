@extends('layouts.mentor')
@section('title', 'Practice Pitches for Feedback')
@section('content')
@php
    $highlightId = request('highlight');
@endphp
<div class="max-w-4xl mx-auto mt-10 space-y-10">
    <h2 class="text-2xl font-bold mb-4">Pitches Awaiting Your Feedback</h2>

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Approved & Feedback Requested</h3>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Entrepreneur</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Approved On</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($awaitingPitches as $pitch)
                    <tr @if($highlightId == $pitch->id) class="bg-yellow-100 animate-pulse" @endif>
                        <td class="px-4 py-2">
                            <img src="{{ $pitch->user->profile_photo_url ?? asset('images/avatar-placeholder.png') }}" alt="Entrepreneur" class="h-8 w-8 rounded-full object-cover mr-2">
                            {{ $pitch->user->name ?? 'Unknown' }}
                        </td>
                        <td class="px-4 py-2 font-semibold">{{ $pitch->title }}</td>
                        <td class="px-4 py-2">
                            @if(Str::contains($pitch->file_type, 'mp4'))
                                <video src="{{ asset('storage/' . $pitch->file_path) }}" controls class="h-12 w-24"></video>
                            @elseif(Str::contains($pitch->file_type, 'mp3'))
                                <audio src="{{ asset('storage/' . $pitch->file_path) }}" controls></audio>
                            @elseif(Str::contains($pitch->file_type, 'pdf'))
                                <a href="{{ asset('storage/' . $pitch->file_path) }}" target="_blank" class="text-blue-600 underline">View PDF</a>
                            @else
                                <a href="{{ asset('storage/' . $pitch->file_path) }}" target="_blank" class="text-blue-600 underline">Download</a>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ Str::limit($pitch->description, 50) }}</td>
                        <td class="px-4 py-2 text-xs text-gray-500">{{ $pitch->updated_at->diffForHumans() }}</td>
                        <td class="px-4 py-2">
                            <button onclick="document.getElementById('feedback-modal-{{ $pitch->id }}').classList.remove('hidden')" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Give Feedback</button>

                            <!-- Feedback Modal -->
                            <div id="feedback-modal-{{ $pitch->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                                <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-lg relative">
                                    <button onclick="document.getElementById('feedback-modal-{{ $pitch->id }}').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
                                    <h2 class="text-lg font-bold mb-4">Provide Feedback for "{{ $pitch->title }}"</h2>
                                    <form action="{{ route('mentor.practice-pitches.feedback', $pitch->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-semibold mb-2">Your Feedback</label>
                                            <textarea name="feedback" class="form-input w-full rounded-md" rows="5" required></textarea>
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('feedback-modal-{{ $pitch->id }}').classList.add('hidden')" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Cancel</button>
                                            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">Submit Feedback</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-400 py-8">No pitches are currently awaiting your feedback.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-xl shadow p-6 mt-8">
        <h3 class="text-lg font-semibold mb-4">Reviewed Pitches</h3>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Entrepreneur</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Reviewed On</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Your Feedback</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($reviewedPitches as $pitch)
                    <tr>
                        <td class="px-4 py-2">{{ $pitch->user->name ?? 'Unknown' }}</td>
                        <td class="px-4 py-2 font-semibold">{{ $pitch->title }}</td>
                        <td class="px-4 py-2">
                            @if(Str::contains($pitch->file_type, 'mp4'))
                                <video src="{{ asset('storage/' . $pitch->file_path) }}" controls class="h-12 w-24"></video>
                            @elseif(Str::contains($pitch->file_type, 'mp3'))
                                <audio src="{{ asset('storage/' . $pitch->file_path) }}" controls></audio>
                            @elseif(Str::contains($pitch->file_type, 'pdf'))
                                <a href="{{ asset('storage/' . $pitch->file_path) }}" target="_blank" class="text-blue-600 underline">View PDF</a>
                            @else
                                <a href="{{ asset('storage/' . $pitch->file_path) }}" target="_blank" class="text-blue-600 underline">Download</a>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ Str::limit($pitch->description, 50) }}</td>
                        <td class="px-4 py-2 text-xs text-gray-500">{{ $pitch->updated_at->diffForHumans() }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ Str::limit($pitch->feedback, 50) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-400 py-8">You haven't reviewed any pitches yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection