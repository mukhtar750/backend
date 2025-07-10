@extends('layouts.entrepreneur')
@section('title', 'Entrepreneur Hub')
@section('content')
<div class="max-w-5xl mx-auto mt-8 h-[80vh] md:h-[70vh] flex flex-col">
    <h2 class="text-3xl font-bold mb-6">Entrepreneur Hub</h2>
    <div class="bg-white rounded-2xl shadow flex flex-1 overflow-hidden min-h-[400px]">
        <!-- Chat Panel -->
        <div class="flex-1 flex flex-col h-full">
            <div class="flex flex-col h-full">
                <!-- Chat Header -->
                <div class="sticky top-0 z-10 bg-white border-b flex items-center gap-3 px-6 py-4">
                    <i class="bi bi-people-fill text-3xl text-[#b81d8f]"></i>
                    <div class="flex-1">
                        <div class="font-semibold text-lg text-gray-900">Entrepreneur Hub</div>
                        <div class="text-xs text-green-500">Group Chat</div>
                    </div>
                </div>
                <!-- Message History -->
                <div class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-white flex flex-col gap-4">
                    <!-- Example group messages -->
                    <div class="flex items-start gap-3">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="h-8 w-8 rounded-full object-cover" alt="Sarah Johnson">
                        <div>
                            <div class="bg-gray-100 rounded-2xl px-4 py-2 text-gray-800 shadow-sm">Hi everyone! Excited for the next training session?</div>
                            <div class="text-xs text-gray-400 mt-1">Sarah Johnson • 2 hours ago</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 flex-row-reverse">
                        <img src="https://i.pravatar.cc/32" class="h-8 w-8 rounded-full object-cover" alt="You">
                        <div>
                            <div class="bg-purple-100 rounded-2xl px-4 py-2 text-gray-800 shadow-sm">Yes! Looking forward to it.</div>
                            <div class="text-xs text-gray-400 mt-1 text-right">You • 1 hour ago</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="h-8 w-8 rounded-full object-cover" alt="Michael Chen">
                        <div>
                            <div class="bg-gray-100 rounded-2xl px-4 py-2 text-gray-800 shadow-sm">Don’t forget to check the new resources in the portal!</div>
                            <div class="text-xs text-gray-400 mt-1">Michael Chen • 30 minutes ago</div>
                        </div>
                    </div>
                </div>
                <!-- Message Input -->
                <div class="border-t p-4 bg-gray-50">
                    @include('dashboard.partials.entrepreneur.message-input')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 