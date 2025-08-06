@php
    $role = auth()->check() ? auth()->user()->role : null;
    $layout = match($role) {
        'mentor' => 'layouts.mentor',
        'entrepreneur' => 'layouts.entrepreneur',
        'mentee' => 'layouts.mentee',
        'investor' => 'layouts.investor',
        'bdsp' => 'layouts.bdsp',
        default => 'layouts.app',
    };
@endphp
@extends($layout)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
            <a href="{{ route('profile.edit') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition">
                Edit Profile
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profile Picture Section -->
            <div class="md:col-span-1">
                <div class="text-center">
                    <div class="relative inline-block">
                        @if($user->profile_picture)
                            <img src="{{ request()->getSchemeAndHttpHost() . '/storage/' . $user->profile_picture }}" 
                                 alt="Profile Picture" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-purple-200">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7C3AED&background=EDE9FE&size=200" 
                                 alt="Default Avatar" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-purple-200">
                        @endif
                        
                        @if($user->profile_picture)
                            <form action="{{ route('profile.remove-picture') }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                    Remove Picture
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="md:col-span-2">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                        <p class="text-gray-900">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <p class="text-gray-900">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
                        <p class="text-gray-900">{{ ucfirst($user->role) }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Account Status</label>
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $user->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $user->is_approved ? 'Approved' : 'Pending Approval' }}
                        </span>
                    </div>

                    <!-- Role-specific information -->
                    @if($user->role === 'entrepreneur')
                        <div class="border-t pt-4">
                            <h3 class="font-semibold text-gray-800 mb-3">Business Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($user->business_name)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Business Name</label>
                                        <p class="text-gray-900">{{ $user->business_name }}</p>
                                    </div>
                                @endif
                                @if($user->sector)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Sector</label>
                                        <p class="text-gray-900">{{ $user->sector }}</p>
                                    </div>
                                @endif
                                @if($user->entrepreneur_phone)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                                        <p class="text-gray-900">{{ $user->entrepreneur_phone }}</p>
                                    </div>
                                @endif
                                @if($user->website)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Website</label>
                                        <p class="text-gray-900">{{ $user->website }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($user->role === 'investor')
                        <div class="border-t pt-4">
                            <h3 class="font-semibold text-gray-800 mb-3">Investor Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($user->company)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Company</label>
                                        <p class="text-gray-900">{{ $user->company }}</p>
                                    </div>
                                @endif
                                @if($user->type_of_investor)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Investor Type</label>
                                        <p class="text-gray-900">{{ $user->type_of_investor }}</p>
                                    </div>
                                @endif
                                @if($user->phone)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                                        <p class="text-gray-900">{{ $user->phone }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($user->role === 'bdsp')
                        <div class="border-t pt-4">
                            <h3 class="font-semibold text-gray-800 mb-3">BDSP Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($user->organization)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Organization</label>
                                        <p class="text-gray-900">{{ $user->organization }}</p>
                                    </div>
                                @endif
                                @if($user->services_provided)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Services Provided</label>
                                        <p class="text-gray-900">{{ $user->services_provided }}</p>
                                    </div>
                                @endif
                                @if($user->years_of_experience)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Years of Experience</label>
                                        <p class="text-gray-900">{{ $user->years_of_experience }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 