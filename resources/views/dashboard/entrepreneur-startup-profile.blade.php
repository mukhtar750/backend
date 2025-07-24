@extends('layouts.entrepreneur')

@section('title', 'My Startup Profile')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Startup Profile</h1>
        <a href="#" class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg shadow hover:bg-[#a01a7d] transition flex items-center">
            <i class="bi bi-pencil-fill mr-2"></i> Edit Profile
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Profile Overview -->
        <div class="md:col-span-1 bg-gray-50 p-6 rounded-lg">
            <div class="flex flex-col items-center mb-6">
                <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                    <i class="bi bi-building text-gray-400 text-5xl"></i>
                </div>
                <h2 class="text-xl font-bold text-center">{{ $user->business_name ?? 'Your Startup' }}</h2>
                <p class="text-gray-500 text-center">{{ $user->sector ?? 'Technology' }}</p>
            </div>

            <div class="space-y-3">
                <div class="flex items-center">
                    <i class="bi bi-person-fill text-gray-500 mr-3 w-5"></i>
                    <div>
                        <p class="text-sm text-gray-500">Founder</p>
                        <p class="font-medium">{{ $user->name }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <i class="bi bi-envelope-fill text-gray-500 mr-3 w-5"></i>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <i class="bi bi-telephone-fill text-gray-500 mr-3 w-5"></i>
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="font-medium">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <i class="bi bi-geo-alt-fill text-gray-500 mr-3 w-5"></i>
                    <div>
                        <p class="text-sm text-gray-500">Location</p>
                        <p class="font-medium">{{ $user->location ?? 'Not provided' }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <i class="bi bi-globe text-gray-500 mr-3 w-5"></i>
                    <div>
                        <p class="text-sm text-gray-500">Website</p>
                        <p class="font-medium">{{ $user->website ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Startup Details -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Startup Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Business Name</p>
                        <p class="font-medium">{{ $user->business_name ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">CAC Registration Number</p>
                        <p class="font-medium">{{ $user->cac_number ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Sector</p>
                        <p class="font-medium">{{ $user->sector ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Funding Stage</p>
                        <p class="font-medium">{{ $user->funding_stage ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Year Founded</p>
                        <p class="font-medium">{{ $user->year_founded ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Team Size</p>
                        <p class="font-medium">{{ $user->team_size ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Business Description</h3>
                <p class="text-gray-700">{{ $user->business_description ?? 'No business description provided. Click the Edit Profile button to add information about your startup.' }}</p>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Products & Services</h3>
                @if($user->products_services ?? false)
                    <p class="text-gray-700">{{ $user->products_services }}</p>
                @else
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                        <p class="text-blue-700">No products or services listed. Click the Edit Profile button to add information about what your startup offers.</p>
                    </div>
                @endif
            </div>

            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Achievements & Milestones</h3>
                @if($user->achievements ?? false)
                    <p class="text-gray-700">{{ $user->achievements }}</p>
                @else
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                        <p class="text-blue-700">No achievements listed yet. Click the Edit Profile button to add your startup's key milestones and achievements.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Investor Visibility Settings</h2>
    <p class="text-gray-600 mb-4">Control which parts of your profile are visible to potential investors.</p>
    
    <div class="space-y-4">
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div>
                <h3 class="font-medium">Public Profile</h3>
                <p class="text-sm text-gray-500">Make your startup visible to all investors</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>
        
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div>
                <h3 class="font-medium">Financial Information</h3>
                <p class="text-sm text-gray-500">Share revenue, funding history, and financial projections</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>
        
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div>
                <h3 class="font-medium">Team Information</h3>
                <p class="text-sm text-gray-500">Share details about your team members</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>
        
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div>
                <h3 class="font-medium">Contact Information</h3>
                <p class="text-sm text-gray-500">Allow investors to contact you directly</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>
    </div>
    
    <div class="mt-6 flex justify-end">
        <button class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg shadow hover:bg-[#a01a7d] transition">
            Save Preferences
        </button>
    </div>
</div>
@endsection