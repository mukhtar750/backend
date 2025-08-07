@extends('admin.layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h1 class="text-3xl font-bold mb-6">All Feedback</h1>
    <table class="w-full text-left border mt-2">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-2 px-3">From</th>
                <th class="py-2 px-3">Target</th>
                <th class="py-2 px-3">Rating</th>
                <th class="py-2 px-3">Comments</th>
                <th class="py-2 px-3">Date</th>
                <th class="py-2 px-3">Status</th>
                <th class="py-2 px-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allFeedback as $feedback)
                <tr class="border-b">
                    <td class="py-2 px-3">
                        @php $user = \App\Models\User::find($feedback->user_id); @endphp
                        {{ $user ? $user->name : 'User Deleted' }}
                        @if($user)
                            <span class="ml-2 px-2 py-0.5 text-xs rounded bg-purple-100 text-purple-800">@displayRole($user->role)</span>
                        @endif
                    </td>
                    <td class="py-2 px-3">
                        @if($feedback->target_type === 'platform')
                            <span class="px-2 py-0.5 text-xs rounded bg-green-100 text-green-800">AWN Platform</span>
                        @elseif($feedback->target_type === 'user')
                            @php $targetUser = \App\Models\User::find($feedback->target_id); @endphp
                            {{ $targetUser ? $targetUser->name : 'User Deleted' }}
                            @if($targetUser)
                                <span class="ml-2 px-2 py-0.5 text-xs rounded bg-blue-100 text-blue-800">@displayRole($targetUser->role)</span>
                            @endif
                        @else
                            {{ $feedback->target_type }}
                        @endif
                    </td>
                    <td class="py-2 px-3">{{ $feedback->rating }}</td>
                    <td class="py-2 px-3">{{ $feedback->comments }}</td>
                    <td class="py-2 px-3">{{ $feedback->created_at->format('Y-m-d H:i') }}</td>
                    <td class="py-2 px-3">
                        <form method="POST" action="{{ route('admin.feedback.update', $feedback->id) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="border rounded px-2 py-1 text-xs" onchange="this.form.submit()">
                                <option value="pending" {{ $feedback->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewed" {{ $feedback->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="resolved" {{ $feedback->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                        </form>
                    </td>
                    <td class="py-2 px-3">
                        <form method="POST" action="{{ route('admin.feedback.destroy', $feedback->id) }}" onsubmit="return confirm('Delete this feedback?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 