@extends('admin.layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Mentorship Sessions</h1>
    <form action="{{ route('admin.mentorship_sessions.clear_all') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all orphaned mentorship sessions? This action cannot be undone.');">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Clear All Orphaned Sessions
        </button>
    </form>
</div>
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pairing</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topic</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scheduled By</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scheduled For</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($sessions as $session)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($session->date_time)->format('Y-m-d H:i') }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($session->pairing)
                        {{ $session->pairing->userOne->name ?? '-' }} <span class="text-gray-400">↔</span> {{ $session->pairing->userTwo->name ?? '-' }}
                        <div class="text-xs text-gray-400 mt-1">{{ strtoupper(str_replace('_', ' ', $session->pairing->pairing_type)) }}</div>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $session->topic ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                        @if($session->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($session->status === 'confirmed') bg-blue-100 text-blue-800
                        @elseif($session->status === 'completed') bg-green-100 text-green-800
                        @elseif($session->status === 'cancelled') bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($session->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $session->scheduledBy->name ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $session->scheduledFor->name ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                    <form action="{{ route('admin.mentorship_sessions.destroy', $session->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this mentorship session?');" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No mentorship sessions found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection