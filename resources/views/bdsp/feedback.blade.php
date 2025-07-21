@extends('layouts.bdsp')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Feedback</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('feedback.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Feedback For:</label>
            <select name="target_id" id="target_id_select" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none" required>
                <option value="platform" data-type="platform">AWN Platform</option>
                @if(isset($pairedUsers))
                    @foreach($pairedUsers as $paired)
                        <option value="{{ $paired->id }}" data-type="user">{{ $paired->name }} ({{ ucfirst($paired->role) }})</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="target_type" id="target_type" value="platform">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Rating:</label>
            <select name="rating" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none" required>
                <option value="">Select rating...</option>
                <option value="5">Excellent</option>
                <option value="4">Good</option>
                <option value="3">Average</option>
                <option value="2">Poor</option>
                <option value="1">Very Poor</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Comments:</label>
            <textarea name="comments" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none" placeholder="Type your feedback..." required></textarea>
        </div>
        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-purple-700 transition">Submit Feedback</button>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var select = document.getElementById('target_id_select');
        var typeInput = document.getElementById('target_type');
        select.addEventListener('change', function() {
            var selected = this.options[this.selectedIndex];
            typeInput.value = selected.dataset.type || 'user';
        });
    });
    </script>

    @if(isset($feedbacks) && $feedbacks->count())
        <h2 class="text-xl font-bold mt-10 mb-4">Your Submitted Feedback</h2>
        <table class="w-full text-left border mt-2">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-3">Target</th>
                    <th class="py-2 px-3">Rating</th>
                    <th class="py-2 px-3">Comments</th>
                    <th class="py-2 px-3">Date</th>
                    <th class="py-2 px-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedbacks as $feedback)
                    <tr class="border-b">
                        <td class="py-2 px-3">
                            @if($feedback->target_type === 'platform')
                                AWN Platform
                            @elseif($feedback->target_type === 'user')
                                @php
                                    $targetUser = \App\Models\User::find($feedback->target_id);
                                @endphp
                                {{ $targetUser ? $targetUser->name : 'User Deleted' }}
                            @else
                                {{ $feedback->target_type }}
                            @endif
                        </td>
                        <td class="py-2 px-3">{{ $feedback->rating }}</td>
                        <td class="py-2 px-3">{{ $feedback->comments }}</td>
                        <td class="py-2 px-3">{{ $feedback->created_at->format('Y-m-d H:i') }}</td>
                        <td class="py-2 px-3">
                            <form method="POST" action="{{ route('bdsp.feedback.destroy', $feedback->id) }}" onsubmit="return confirm('Delete this feedback?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection 