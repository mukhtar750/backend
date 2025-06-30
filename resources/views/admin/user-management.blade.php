@extends('admin.layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
    <a href="#" class="bg-custom-purple text-white px-4 py-2 rounded-lg shadow hover:bg-custom-purple-700 transition flex items-center">
        <i class="bi bi-download mr-2"></i> Export Data
    </a>
</div>

<div class="bg-white p-6 rounded-lg shadow mb-6">
    {{-- Filters --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <input type="text" placeholder="Search users..." class="form-input rounded-lg border-gray-300 shadow-sm focus:border-custom-purple focus:ring focus:ring-custom-purple-200 focus:ring-opacity-50">
        <select class="form-select rounded-lg border-gray-300 shadow-sm focus:border-custom-purple focus:ring focus:ring-custom-purple-200 focus:ring-opacity-50">
            <option>All Roles</option>
            <option>Entrepreneur</option>
            <option>BDSP</option>
            <option>Investor</option>
        </select>
        <select class="form-select rounded-lg border-gray-300 shadow-sm focus:border-custom-purple focus:ring focus:ring-custom-purple-200 focus:ring-opacity-50">
            <option>All Status</option>
            <option>Pending</option>
            <option>Approved</option>
            <option>Rejected</option>
        </select>
    </div>

    {{-- Users Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach (['User', 'Role', 'Status', 'Join Date', 'Last Active', 'Actions'] as $heading)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $heading }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($allUsers as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40" alt="">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                <div class="text-xs text-gray-400">{{ $user->location ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">{{ ucfirst($user->role) }}</span>
                        <div class="text-xs text-gray-500">{{ $user->company ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->is_approved)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->last_active ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                        <a href="{{ route('admin.editUser', $user->id) }}" class="text-indigo-600 hover:text-indigo-900"><i class="bi bi-pencil"></i> Edit</a>
                        @if(!$user->is_approved)
                            <form action="{{ route('admin.approve', $user->id) }}" method="POST" class="inline-block">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-green-600 hover:text-green-900"><i class="bi bi-person-check"></i> Approve</button>
                            </form>
                            <form action="{{ route('admin.reject', $user->id) }}" method="POST" class="inline-block">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-red-600 hover:text-red-900"><i class="bi bi-person-x"></i> Decline</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.destroy', $user->id) }}" method="POST" class="inline-block">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Users Awaiting Approval --}}
@if(isset($users) && !$users->isEmpty())
<div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Users Awaiting Approval</h3>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            @foreach($users as $user)
                @php
                    $row = [
                        'Name' => $user->name,
                        'Email' => $user->email,
                        'Role' => $user->role,
                    ];
                @endphp
                @foreach($row as $label => $value)
                    <div class="{{ $loop->even ? 'bg-white' : 'bg-gray-50' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ $label }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $value }}</dd>
                    </div>
                @endforeach
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Actions</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 flex space-x-3">
                        <form action="{{ route('admin.approve', $user->id) }}" method="POST">@csrf @method('PATCH')
                            <button type="submit" class="btn-approve">Approve</button>
                        </form>
                        <form action="{{ route('admin.reject', $user->id) }}" method="POST">@csrf @method('PATCH')
                            <button type="submit" class="btn-reject">Reject</button>
                        </form>
                        <form action="{{ route('admin.destroy', $user->id) }}" method="POST">@csrf @method('DELETE')
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</div>
@else
<p class="text-center text-gray-600 py-4">No pending users for approval.</p>
@endif

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    @foreach([
        ['label' => 'Total Users', 'value' => 4, 'icon' => 'bi-people'],
        ['label' => 'Pending Approval', 'value' => 1, 'icon' => 'bi-person-check'],
        ['label' => 'Entrepreneurs', 'value' => 2, 'icon' => 'bi-person-workspace'],
        ['label' => 'Active This Week', 'value' => 4, 'icon' => 'bi-graph-up'],
    ] as $card)
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-gray-500">{{ $card['label'] }}</div>
                <div class="text-2xl font-bold">{{ $card['value'] }}</div>
            </div>
            <i class="bi {{ $card['icon'] }} text-custom-purple text-4xl"></i>
        </div>
    @endforeach
</div>
@endsection
