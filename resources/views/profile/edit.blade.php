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
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Profile</h1>
            <a href="{{ route('profile.show') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
                Back to Profile
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Picture Upload -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Profile Picture</label>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        @if($user->profile_picture)
                            <img src="{{ request()->getSchemeAndHttpHost() . '/storage/' . $user->profile_picture }}" 
                                 alt="Current Profile Picture" 
                                 class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7C3AED&background=EDE9FE&size=200" 
                                 alt="Default Avatar" 
                                 class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" 
                               name="profile_picture" 
                               accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                        <p class="text-xs text-gray-500 mt-1">Upload a new profile picture (JPEG, PNG, JPG, GIF, max 2MB)</p>
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Name *</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500"
                           required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email *</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500"
                           required>
                </div>
            </div>

            <!-- Role-specific fields -->
            @if($user->role === 'entrepreneur')
                <div class="border-t pt-6 mt-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Business Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="business_name" class="block text-sm font-semibold text-gray-700 mb-1">Business Name</label>
                            <input type="text" 
                                   id="business_name" 
                                   name="business_name" 
                                   value="{{ old('business_name', $user->business_name) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label for="sector" class="block text-sm font-semibold text-gray-700 mb-1">Sector</label>
                            <input type="text" 
                                   id="sector" 
                                   name="sector" 
                                   value="{{ old('sector', $user->sector) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label for="entrepreneur_phone" class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                            <input type="text" 
                                   id="entrepreneur_phone" 
                                   name="entrepreneur_phone" 
                                   value="{{ old('entrepreneur_phone', $user->entrepreneur_phone) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label for="website" class="block text-sm font-semibold text-gray-700 mb-1">Website</label>
                            <input type="url" 
                                   id="website" 
                                   name="website" 
                                   value="{{ old('website', $user->website) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>
                </div>
            @endif

            @if($user->role === 'investor')
                <div class="border-t pt-6 mt-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Investor Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="company" class="block text-sm font-semibold text-gray-700 mb-1">Company</label>
                            <input type="text" 
                                   id="company" 
                                   name="company" 
                                   value="{{ old('company', $user->company) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                            <input type="text" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $user->phone) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>
                </div>
            @endif

            @if($user->role === 'bdsp')
                <div class="border-t pt-6 mt-6">
                    <h3 class="font-semibold text-gray-800 mb-4">BDSP Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="organization" class="block text-sm font-semibold text-gray-700 mb-1">Organization</label>
                            <input type="text" 
                                   id="organization" 
                                   name="organization" 
                                   value="{{ old('organization', $user->organization) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label for="services_provided" class="block text-sm font-semibold text-gray-700 mb-1">Services Provided</label>
                            <input type="text" 
                                   id="services_provided" 
                                   name="services_provided" 
                                   value="{{ old('services_provided', $user->services_provided) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>
                </div>
            @endif

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('profile.show') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 