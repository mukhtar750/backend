@extends('layouts.bdsp')

@section('title', 'Practice Pitches')

@section('content')
    @php
        $highlightId = request('highlight');
    @endphp
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Practice Pitches Awaiting Feedback</h1>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrepreneur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($awaitingPitches as $pitch)
                            <tr @if($highlightId == $pitch->id) class="bg-yellow-100 animate-pulse" @endif>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pitch->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pitch->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ Storage::url($pitch->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900">View File</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pitch->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('bdsp.practice-pitches.feedback', $pitch->id) }}" method="POST">
                                        @csrf
                                        <textarea name="feedback" rows="3" class="w-full p-2 border rounded" placeholder="Enter your feedback..."></textarea>
                                        <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Submit Feedback</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No pitches awaiting feedback.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mt-8 mb-6">Reviewed Pitches</h1>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrepreneur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Feedback</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($reviewedPitches as $pitch)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pitch->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pitch->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ Storage::url($pitch->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900">View File</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pitch->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pitch->feedback }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No reviewed pitches.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection