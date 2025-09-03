@extends('admin.layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Training Programs</h1>
    <a href="{{ route('admin.training_programs.create') }}" class="bg-[#b81d8f] hover:bg-[#a01a7d] text-white px-4 py-2 rounded-lg shadow transition flex items-center">
        <i class="bi bi-plus-circle mr-2"></i> Create New Training
    </a>
</div>
@if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trainer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target Roles</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($sessions as $session)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $session->title }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($session->date_time)->format('Y-m-d H:i') }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $session->duration }} min</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $session->trainer }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @foreach(json_decode($session->target_roles, true) as $role)
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded mr-1 mb-1">@displayRole($role)</span>
                    @endforeach
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                    <a href="{{ route('admin.training_programs.edit', $session->id) }}" class="text-indigo-600 hover:text-indigo-900"><i class="bi bi-pencil"></i> Edit</a>
                    <form action="{{ route('admin.training_programs.destroy', $session->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this training session?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900"><i class="bi bi-trash"></i> Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No training sessions found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 