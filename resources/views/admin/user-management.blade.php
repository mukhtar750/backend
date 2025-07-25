@extends('admin.layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
    <a href="#" class="flex items-center gap-2 bg-pink-600 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-pink-700 transition text-base font-bold border-2 border-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-300">
        <i class="bi bi-download text-xl"></i>
        Export Data
    </a>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

<!-- Tabs -->
<div x-data="{ tab: '{{ request('tab', 'users') }}' }" class="mb-6">
    <nav class="flex space-x-4 border-b border-gray-200">
        <button @click="tab = 'users'" :class="tab === 'users' ? 'border-b-2 border-[#b81d8f] text-[#b81d8f]' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Users</button>
        <button @click="tab = 'pairings'" :class="tab === 'pairings' ? 'border-b-2 border-[#b81d8f] text-[#b81d8f]' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Pairings</button>
        <button @click="tab = 'startup-profiles'" :class="tab === 'startup-profiles' ? 'border-b-2 border-[#b81d8f] text-[#b81d8f]' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Startup Profiles</button>
    </nav>

    <!-- Users Tab -->
    <div x-show="tab === 'users'" class="mt-6">
        {{-- Filters --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <input type="text" placeholder="Search users..." class="form-input rounded-lg border-gray-300 shadow-sm focus:border-magenta focus:ring focus:ring-magenta-200 focus:ring-opacity-50">
            <select class="form-select rounded-lg border-gray-300 shadow-sm focus:border-magenta focus:ring focus:ring-magenta-200 focus:ring-opacity-50">
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

    <!-- Pairings Tab -->
    <div x-show="tab === 'pairings'" class="mt-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">User Pairings</h2>
            <a href="{{ route('admin.pairings.create') }}" class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg shadow hover:bg-[#a01a7d] transition flex items-center">
                <i class="bi bi-plus-circle mr-2"></i> Create New Pairing
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pairing Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User One</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Two</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mentorship Agreement</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if($pairings->count() > 0)
                        @foreach($pairings as $pairing)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">{{ ucwords(str_replace('_', ' ', $pairing->pairing_type)) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full" src="https://via.placeholder.com/32" alt="">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $pairing->userOne->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $pairing->userOne->email }}</div>
                                        <div class="text-xs text-gray-400">{{ ucfirst($pairing->userOne->role) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full" src="https://via.placeholder.com/32" alt="">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $pairing->userTwo->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $pairing->userTwo->email }}</div>
                                        <div class="text-xs text-gray-400">{{ ucfirst($pairing->userTwo->role) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $pairing->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $agreementForm = \App\Models\MentorshipForm::where('form_type', 'mentorship_agreement')->first();
                                    $mentor = $pairing->userOne->role === 'mentor' ? $pairing->userOne : $pairing->userTwo;
                                    $mentee = $pairing->userOne->role === 'mentee' ? $pairing->userOne : $pairing->userTwo;
                                    $mentorSubmission = $agreementForm ? \App\Models\MentorshipFormSubmission::where([
                                        'pairing_id' => $pairing->id,
                                        'mentorship_form_id' => $agreementForm->id,
                                        'submitted_by' => $mentor->id,
                                    ])->first() : null;
                                    $menteeSubmission = $agreementForm ? \App\Models\MentorshipFormSubmission::where([
                                        'pairing_id' => $pairing->id,
                                        'mentorship_form_id' => $agreementForm->id,
                                        'submitted_by' => $mentee->id,
                                    ])->first() : null;
                                @endphp
                                <div>
                                    <span class="font-semibold">Mentor:</span> {{ $mentorSubmission && $mentorSubmission->is_signed ? 'Signed' : 'Pending' }}<br>
                                    <span class="font-semibold">Mentee:</span> {{ $menteeSubmission && $menteeSubmission->is_signed ? 'Signed' : 'Pending' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <form action="{{ route('admin.pairings.destroy', $pairing->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unpair these users?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"><i class="bi bi-x-circle"></i> Unpair</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                             <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                 No pairings found. <a href="{{ route('admin.pairings.create') }}" class="text-blue-600 hover:underline">Create your first pairing</a>
                             </td>
                         </tr>
                    @endif
                </tbody>
            </table>
        </div>
    
    <!-- Startup Profiles Tab -->
    <div x-show="tab === 'startup-profiles'" class="mt-6">
        <table border="1" style="width:100%; background: #fff;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Founder</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($startups as $startup)
                    <tr>
                        <td>{{ $startup->id }}</td>
                        <td>{{ $startup->name }}</td>
                        <td>{{ $startup->founder->name ?? 'Unknown' }}</td>
                        <td>{{ $startup->status }}</td>
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
            <i class="bi {{ $card['icon'] }} text-magenta text-4xl"></i>
        </div>
    @endforeach
</div>
@endsection