@extends('layouts.entrepreneur')
@section('title', 'Feedback')
@section('content')
<div class="max-w-5xl mx-auto mt-10">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Feedback</h2>
            <p class="text-gray-500 mt-1">Give and receive feedback to improve your learning experience</p>
        </div>
        <div>
            <select class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]">
                <option>All Categories</option>
                <option>Mentor</option>
                <option>Training</option>
                <option>Platform</option>
            </select>
        </div>
    </div>
    <!-- Stats Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Feedback Received</div>
            <div class="text-2xl font-bold text-[#b81d8f]">15</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Feedback Given</div>
            <div class="text-2xl font-bold text-[#b81d8f]">8</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Avg. Rating Received</div>
            <div class="text-2xl font-bold text-orange-500 flex items-center gap-1">4.5 <i class="bi bi-star-fill"></i></div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Avg. Rating Given</div>
            <div class="text-2xl font-bold text-[#b81d8f] flex items-center gap-1">4.7 <i class="bi bi-person-circle"></i></div>
        </div>
    </div>
    <!-- Tabs -->
    <div x-data="{ tab: 'give' }" class="mb-6">
        <div class="flex border-b">
            <button @click="tab = 'give'" :class="tab === 'give' ? 'border-[#b81d8f] text-[#b81d8f]' : 'border-transparent text-gray-500'" class="px-6 py-2 font-medium border-b-2 focus:outline-none">Give Feedback</button>
            <button @click="tab = 'received'" :class="tab === 'received' ? 'border-[#b81d8f] text-[#b81d8f]' : 'border-transparent text-gray-500'" class="px-6 py-2 font-medium border-b-2 focus:outline-none">Received</button>
            <button @click="tab = 'analytics'" :class="tab === 'analytics' ? 'border-[#b81d8f] text-[#b81d8f]' : 'border-transparent text-gray-500'" class="px-6 py-2 font-medium border-b-2 focus:outline-none">Analytics</button>
        </div>
        <!-- Give Feedback Tab -->
        <div x-show="tab === 'give'" class="mt-6 space-y-4" x-data="{ showModal: false }">
            <div class="font-semibold text-gray-800 mb-2">Available for Feedback</div>
            <!-- Feedback Card 1: Mentor -->
            <div class="bg-white rounded-xl shadow p-5 flex flex-col md:flex-row md:items-center gap-4 justify-between">
                <div class="flex items-center gap-4">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="h-12 w-12 rounded-full object-cover" alt="Mentor">
                    <div>
                        <div class="font-semibold text-gray-900">Dr. Kemi Adebayo</div>
                        <div class="text-xs text-gray-500">Business Consultant</div>
                        <div class="text-xs text-gray-400">Last session: 2025-01-20</div>
                        <div class="text-xs text-gray-400">Topic: Business Model Validation</div>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2 md:mt-0">
                    <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full">mentor</span>
                    <button @click="showModal = true" class="bg-[#b81d8f] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Give Feedback</button>
                </div>
            </div>
            <!-- Feedback Card 2: Training -->
            <div class="bg-white rounded-xl shadow p-5 flex flex-col md:flex-row md:items-center gap-4 justify-between">
                <div class="flex items-center gap-4">
                    <img src="https://randomuser.me/api/portraits/men/45.jpg" class="h-12 w-12 rounded-full object-cover" alt="Trainer">
                    <div>
                        <div class="font-semibold text-gray-900">Financial Planning Workshop</div>
                        <div class="text-xs text-gray-500">by Grace Mwangi</div>
                        <div class="text-xs text-gray-400">Completed: 2025-01-18</div>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2 md:mt-0">
                    <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">training</span>
                    <button @click="showModal = true" class="bg-[#b81d8f] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Give Feedback</button>
                </div>
            </div>
            <!-- Feedback Card 3: Platform -->
            <div class="bg-white rounded-xl shadow p-5 flex flex-col md:flex-row md:items-center gap-4 justify-between">
                <div>
                    <div class="font-semibold text-gray-900">AWN Information Management Portal</div>
                    <div class="text-xs text-gray-400">Last used: Today</div>
                </div>
                <div class="flex items-center gap-2 mt-2 md:mt-0">
                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">platform</span>
                    <button @click="showModal = true" class="bg-[#b81d8f] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Give Feedback</button>
                </div>
            </div>
            <!-- Feedback Modal -->
            <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" style="display: none;" @keydown.escape.window="showModal = false">
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-auto p-6 relative animate-fade-in">
                    <button @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                    <h3 class="text-2xl font-bold mb-4">Give Feedback</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="h-14 w-14 rounded-full object-cover" alt="Mentor">
                        <div>
                            <div class="font-semibold text-gray-900">Dr. Kemi Adebayo</div>
                            <div class="text-xs text-gray-500">Business Consultant</div>
                        </div>
                    </div>
                    <form @submit.prevent="showModal = false">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">Overall Rating</label>
                            <div class="flex gap-1">
                                <template x-for="i in 5">
                                    <button type="button" :class="'text-3xl ' + (i <= 0 ? 'text-gray-300' : 'text-yellow-400')">&#9733;</button>
                                </template>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">Your Feedback</label>
                            <textarea class="w-full border border-gray-300 rounded-lg p-3 focus:ring-[#b81d8f] focus:border-[#b81d8f]" rows="4" placeholder="Share your experience and suggestions for improvement..."></textarea>
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-1">Category</label>
                            <select class="w-full border border-[#b81d8f] rounded-lg p-2 focus:ring-[#b81d8f] focus:border-[#b81d8f]">
                                <option>Session Quality</option>
                                <option>Content Relevance</option>
                                <option>Communication</option>
                                <option>Preparation</option>
                                <option>Overall Experience</option>
                            </select>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="showModal = false" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition">Cancel</button>
                            <button type="submit" class="px-5 py-2 rounded-lg bg-[#b81d8f] text-white font-semibold hover:bg-[#a01a7d] transition">Submit Feedback</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Received Tab -->
        <div x-show="tab === 'received'" class="mt-6 space-y-4">
            <div class="font-semibold text-gray-800 mb-2">Feedback You Received</div>
            <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-2">
                <div class="flex items-center gap-3">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="h-8 w-8 rounded-full object-cover" alt="Mentor">
                    <div class="font-semibold text-gray-900">Dr. Kemi Adebayo</div>
                    <span class="ml-auto text-orange-500 flex items-center gap-1 font-semibold"><i class="bi bi-star-fill"></i> 5.0</span>
                </div>
                <div class="text-sm text-gray-700">Great participation and insightful questions during the session!</div>
                <div class="text-xs text-gray-400">2025-01-20</div>
            </div>
            <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-2">
                <div class="flex items-center gap-3">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" class="h-8 w-8 rounded-full object-cover" alt="Trainer">
                    <div class="font-semibold text-gray-900">Grace Mwangi</div>
                    <span class="ml-auto text-orange-500 flex items-center gap-1 font-semibold"><i class="bi bi-star-fill"></i> 4.5</span>
                </div>
                <div class="text-sm text-gray-700">Excellent effort in the financial planning workshop.</div>
                <div class="text-xs text-gray-400">2025-01-18</div>
            </div>
        </div>
        <!-- Analytics Tab -->
        <div x-show="tab === 'analytics'" class="mt-6">
            <div class="font-semibold text-gray-800 mb-2">Feedback Analytics</div>
            <div class="bg-white rounded-xl shadow p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Average Rating Given</div>
                        <div class="text-3xl font-bold text-[#b81d8f] flex items-center gap-2">4.7 <i class="bi bi-person-circle"></i></div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Average Rating Received</div>
                        <div class="text-3xl font-bold text-orange-500 flex items-center gap-2">4.5 <i class="bi bi-star-fill"></i></div>
                    </div>
                </div>
                <div class="mt-8">
                    <div class="text-xs text-gray-500 mb-1">Feedback Over Time</div>
                    <div class="h-32 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">[Feedback chart placeholder]</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 