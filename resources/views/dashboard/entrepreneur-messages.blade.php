@extends('layouts.entrepreneur')
@section('title', 'Messages')
@section('content')
<div class="max-w-5xl mx-auto mt-8 h-[80vh] md:h-[70vh] flex flex-col">
    <h2 class="text-3xl font-bold mb-6">Messages</h2>
    <div class="bg-white rounded-2xl shadow flex flex-1 overflow-hidden min-h-[400px]">
        <!-- Conversations List (Sidebar) -->
        <div class="hidden md:block w-1/3 border-r bg-gray-50 p-4 h-full">
            @include('dashboard.partials.entrepreneur.conversations-list')
        </div>
        <!-- Mobile Sidebar Toggle -->
        <div class="md:hidden flex items-center justify-between px-4 py-2 border-b bg-gray-50">
            <span class="font-semibold">Conversations</span>
            <button @click="sidebarOpen = true" class="md:hidden p-2 rounded hover:bg-purple-100"><i class="bi bi-list text-2xl"></i></button>
        </div>
        <!-- Mobile Sidebar Drawer -->
        <div x-data="{ sidebarOpen: false }" x-show="sidebarOpen" class="fixed inset-0 z-40 flex md:hidden" style="display: none;">
            <div class="fixed inset-0 bg-black bg-opacity-30" @click="sidebarOpen = false"></div>
            <div class="relative w-64 bg-white h-full shadow-xl p-4">
                <button class="absolute top-2 right-2 p-2" @click="sidebarOpen = false"><i class="bi bi-x-lg"></i></button>
                @include('dashboard.partials.entrepreneur.conversations-list')
            </div>
        </div>
        <!-- Chat Panel -->
        <div class="flex-1 flex flex-col h-full">
            @include('dashboard.partials.entrepreneur.chat-panel')
            <!-- Message Input -->
            <div class="border-t p-4 bg-gray-50">
                @include('dashboard.partials.entrepreneur.message-input')
            </div>
        </div>
    </div>
</div>
@endsection 