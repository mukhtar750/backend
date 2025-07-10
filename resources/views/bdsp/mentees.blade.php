@extends('layouts.bdsp')
@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-1">Mentorship Management</h2>
            <p class="text-gray-500">Manage mentorship sessions and track progress</p>
        </div>
        <button class="bg-purple-500 hover:bg-purple-600 text-white px-5 py-2 rounded-lg font-semibold text-sm flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Schedule Session
        </button>
    </div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-purple-600">3</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-people"></i> Total Sessions</div>
        </div>
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-blue-500">2</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-calendar-event"></i> Scheduled</div>
        </div>
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-green-500">1</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-check-circle"></i> Completed</div>
        </div>
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-orange-500">4.8</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-star"></i> Avg. Rating</div>
        </div>
    </div>
    <!-- Tabs & Session Cards -->
    <div x-data="{ tab: 'scheduled' }">
        <div class="mb-4 border-b">
            <nav class="flex gap-8">
                <button @click="tab = 'scheduled'" :class="tab === 'scheduled' ? 'border-b-2 border-purple-500 text-purple-600 font-semibold' : 'text-gray-500 hover:text-purple-600'" class="py-2 focus:outline-none">Scheduled (2)</button>
                <button @click="tab = 'completed'" :class="tab === 'completed' ? 'border-b-2 border-purple-500 text-purple-600 font-semibold' : 'text-gray-500 hover:text-purple-600'" class="py-2 focus:outline-none">Completed (1)</button>
                <button @click="tab = 'all'" :class="tab === 'all' ? 'border-b-2 border-purple-500 text-purple-600 font-semibold' : 'text-gray-500 hover:text-purple-600'" class="py-2 focus:outline-none">All (3)</button>
            </nav>
        </div>
        <!-- Session Cards -->
        <div class="space-y-6">
            <!-- Scheduled Tab -->
            <template x-if="tab === 'scheduled'">
                <div>
                    <!-- Session 1 -->
                    <div class="bg-white rounded-xl border p-6 flex flex-col gap-4 shadow-sm relative mb-6">
                        <span class="absolute top-4 right-4 bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">Scheduled</span>
                        <div class="flex items-center gap-4">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white" alt="Dr. Kemi Adebayo">
                            <div>
                                <div class="font-semibold text-gray-900">Dr. Kemi Adebayo <span class="text-xs text-gray-400 ml-1">Mentor</span></div>
                                <div class="text-gray-500 text-sm">Business Model Validation</div>
                            </div>
                            <i class="bi bi-camera-video text-purple-500 text-xl ml-4"></i>
                            <img src="https://randomuser.me/api/portraits/women/65.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white ml-4" alt="Fatima Al-Rashid">
                            <div>
                                <div class="font-semibold text-gray-900">Fatima Al-Rashid <span class="text-xs text-gray-400 ml-1">Mentee</span></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 text-gray-500 text-sm mt-2">
                            <div><i class="bi bi-calendar-event"></i> 2025-01-25 at 2:00 PM</div>
                            <div><i class="bi bi-clock"></i> 60 minutes</div>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Chat">
                                <i class="bi bi-chat-dots text-lg text-gray-500"></i>
                            </button>
                            <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Message">
                                <i class="bi bi-envelope text-lg text-gray-500"></i>
                            </button>
                        </div>
                        <div class="flex gap-3 mt-4">
                            <button class="text-red-500 font-semibold hover:underline">Cancel</button>
                            <button class="text-blue-500 font-semibold hover:underline">Reschedule</button>
                            <button class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold ml-auto">Join Session</button>
                        </div>
                    </div>
                    <!-- Session 2 -->
                    <div class="bg-white rounded-xl border p-6 flex flex-col gap-4 shadow-sm relative">
                        <span class="absolute top-4 right-4 bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">Scheduled</span>
                        <div class="flex items-center gap-4">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white" alt="Dr. Kemi Adebayo">
                            <div>
                                <div class="font-semibold text-gray-900">Dr. Kemi Adebayo <span class="text-xs text-gray-400 ml-1">Mentor</span></div>
                                <div class="text-gray-500 text-sm">Market Research Strategy</div>
                            </div>
                            <i class="bi bi-telephone text-purple-500 text-xl ml-4"></i>
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white ml-4" alt="Amina Hassan">
                            <div>
                                <div class="font-semibold text-gray-900">Amina Hassan <span class="text-xs text-gray-400 ml-1">Mentee</span></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 text-gray-500 text-sm mt-2">
                            <div><i class="bi bi-calendar-event"></i> 2025-01-28 at 11:00 AM</div>
                            <div><i class="bi bi-clock"></i> 60 minutes</div>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Chat">
                                <i class="bi bi-chat-dots text-lg text-gray-500"></i>
                            </button>
                            <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Message">
                                <i class="bi bi-envelope text-lg text-gray-500"></i>
                            </button>
                        </div>
                        <div class="flex gap-3 mt-4">
                            <button class="text-red-500 font-semibold hover:underline">Cancel</button>
                            <button class="text-blue-500 font-semibold hover:underline">Reschedule</button>
                            <button class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold ml-auto">Join Session</button>
                        </div>
                    </div>
                </div>
            </template>
            <!-- Completed Tab -->
            <template x-if="tab === 'completed'">
                <div>
                    <!-- Completed Session -->
                    <div class="bg-white rounded-xl border p-6 flex flex-col gap-4 shadow-sm relative">
                        <span class="absolute top-4 right-4 bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full">Completed</span>
                        <div class="flex items-center gap-4">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white" alt="Dr. Kemi Adebayo">
                            <div>
                                <div class="font-semibold text-gray-900">Dr. Kemi Adebayo <span class="text-xs text-gray-400 ml-1">Mentor</span></div>
                                <div class="text-gray-500 text-sm">Business Model Validation</div>
                            </div>
                            <i class="bi bi-camera-video text-purple-500 text-xl ml-4"></i>
                            <img src="https://randomuser.me/api/portraits/women/65.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white ml-4" alt="Fatima Al-Rashid">
                            <div>
                                <div class="font-semibold text-gray-900">Fatima Al-Rashid <span class="text-xs text-gray-400 ml-1">Mentee</span></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 text-gray-500 text-sm mt-2">
                            <div><i class="bi bi-calendar-event"></i> 2025-01-25 at 2:00 PM</div>
                            <div><i class="bi bi-clock"></i> 60 minutes</div>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Chat">
                                <i class="bi bi-chat-dots text-lg text-gray-500"></i>
                            </button>
                            <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Message">
                                <i class="bi bi-envelope text-lg text-gray-500"></i>
                            </button>
                        </div>
                        <div class="flex gap-3 mt-4">
                            <button class="text-gray-400 font-semibold cursor-not-allowed" disabled>Cancel</button>
                            <button class="text-gray-400 font-semibold cursor-not-allowed" disabled>Reschedule</button>
                            <button class="bg-green-500 text-white px-4 py-2 rounded-lg font-semibold ml-auto cursor-not-allowed" disabled>Completed</button>
                        </div>
                    </div>
                </div>
            </template>
            <!-- All Tab -->
            <template x-if="tab === 'all'">
                <div>
                    <!-- Session 1 (Scheduled) -->
                    <div class="bg-white rounded-xl border p-6 flex flex-col gap-4 shadow-sm relative mb-6">
                        <span class="absolute top-4 right-4 bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">Scheduled</span>
                        <div class="flex items-center gap-4">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white" alt="Dr. Kemi Adebayo">
                            <div>
                                <div class="font-semibold text-gray-900">Dr. Kemi Adebayo <span class="text-xs text-gray-400 ml-1">Mentor</span></div>
                                <div class="text-gray-500 text-sm">Business Model Validation</div>
                            </div>
                            <i class="bi bi-camera-video text-purple-500 text-xl ml-4"></i>
                            <img src="https://randomuser.me/api/portraits/women/65.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white ml-4" alt="Fatima Al-Rashid">
                            <div>
                                <div class="font-semibold text-gray-900">Fatima Al-Rashid <span class="text-xs text-gray-400 ml-1">Mentee</span></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 text-gray-500 text-sm mt-2">
                            <div><i class="bi bi-calendar-event"></i> 2025-01-25 at 2:00 PM</div>
                            <div><i class="bi bi-clock"></i> 60 minutes</div>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Chat">
                                <i class="bi bi-chat-dots text-lg text-gray-500"></i>
                            </button>
                            <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Message">
                                <i class="bi bi-envelope text-lg text-gray-500"></i>
                            </button>
                        </div>
                        <div class="flex gap-3 mt-4">
                            <button class="text-red-500 font-semibold hover:underline">Cancel</button>
                            <button class="text-blue-500 font-semibold hover:underline">Reschedule</button>
                            <button class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold ml-auto">Join Session</button>
                        </div>
                    </div>
                    <!-- Session 2 (Scheduled) -->
                    <div class="bg-white rounded-xl border p-6 flex flex-col gap-4 shadow-sm relative mb-6">
                        <span class="absolute top-4 right-4 bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">Scheduled</span>
                        <div class="flex items-center gap-4">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white" alt="Dr. Kemi Adebayo">
                            <div>
                                <div class="font-semibold text-gray-900">Dr. Kemi Adebayo <span class="text-xs text-gray-400 ml-1">Mentor</span></div>
                                <div class="text-gray-500 text-sm">Market Research Strategy</div>
                            </div>
                            <i class="bi bi-telephone text-purple-500 text-xl ml-4"></i>
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white ml-4" alt="Amina Hassan">
                            <div>
                                <div class="font-semibold text-gray-900">Amina Hassan <span class="text-xs text-gray-400 ml-1">Mentee</span></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 text-gray-500 text-sm mt-2">
                            <div><i class="bi bi-calendar-event"></i> 2025-01-28 at 11:00 AM</div>
                            <div><i class="bi bi-clock"></i> 60 minutes</div>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Chat">
                                <i class="bi bi-chat-dots text-lg text-gray-500"></i>
                            </button>
                            <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Message">
                                <i class="bi bi-envelope text-lg text-gray-500"></i>
                            </button>
                        </div>
                        <div class="flex gap-3 mt-4">
                            <button class="text-red-500 font-semibold hover:underline">Cancel</button>
                            <button class="text-blue-500 font-semibold hover:underline">Reschedule</button>
                            <button class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold ml-auto">Join Session</button>
                        </div>
                    </div>
                    <!-- Session 3 (Completed) -->
                    <div class="bg-white rounded-xl border p-6 flex flex-col gap-4 shadow-sm relative">
                        <span class="absolute top-4 right-4 bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full">Completed</span>
                        <div class="flex items-center gap-4">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white" alt="Dr. Kemi Adebayo">
                            <div>
                                <div class="font-semibold text-gray-900">Dr. Kemi Adebayo <span class="text-xs text-gray-400 ml-1">Mentor</span></div>
                                <div class="text-gray-500 text-sm">Business Model Validation</div>
                            </div>
                            <i class="bi bi-camera-video text-purple-500 text-xl ml-4"></i>
                            <img src="https://randomuser.me/api/portraits/women/65.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white ml-4" alt="Fatima Al-Rashid">
                            <div>
                                <div class="font-semibold text-gray-900">Fatima Al-Rashid <span class="text-xs text-gray-400 ml-1">Mentee</span></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 text-gray-500 text-sm mt-2">
                            <div><i class="bi bi-calendar-event"></i> 2025-01-25 at 2:00 PM</div>
                            <div><i class="bi bi-clock"></i> 60 minutes</div>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Chat">
                                <i class="bi bi-chat-dots text-lg text-gray-500"></i>
                            </button>
                            <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Message">
                                <i class="bi bi-envelope text-lg text-gray-500"></i>
                            </button>
                        </div>
                        <div class="flex gap-3 mt-4">
                            <button class="text-gray-400 font-semibold cursor-not-allowed" disabled>Cancel</button>
                            <button class="text-gray-400 font-semibold cursor-not-allowed" disabled>Reschedule</button>
                            <button class="bg-green-500 text-white px-4 py-2 rounded-lg font-semibold ml-auto cursor-not-allowed" disabled>Completed</button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection 