@extends('layouts.investor')
@section('title', 'Pitch Events')
@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2"><i class="bi bi-calendar-event text-[#b81d8f]"></i> Pitch Events</h2>
    <div class="flex gap-2">
        <input type="text" placeholder="Search events..." class="border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" x-model="search">
        <select class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" x-model="tab">
            <option value="upcoming">Upcoming</option>
            <option value="past">Past</option>
            <option value="all">All</option>
        </select>
    </div>
</div>
<div x-data="{
    search: '',
    tab: 'upcoming',
    events: [
        {id: 1, name: 'Lagos Demo Day', date: '2024-07-10', time: '10:00 AM', location: 'Lagos', featured: ['PayLink', 'AgroPro'], status: 'upcoming', registered: false},
        {id: 2, name: 'Virtual Pitch Fest', date: '2024-06-20', time: '2:00 PM', location: 'Online', featured: ['MediQuick'], status: 'upcoming', registered: true},
        {id: 3, name: 'Kano Investor Meetup', date: '2024-05-15', time: '11:00 AM', location: 'Kano', featured: ['Learnly'], status: 'past', registered: false},
    ],
    get filteredEvents() {
        return this.events.filter(e =>
            (!this.search || e.name.toLowerCase().includes(this.search.toLowerCase())) &&
            (this.tab === 'all' || e.status === this.tab)
        );
    },
    selected: null
}" class="relative">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="event in filteredEvents" :key="event.id">
            <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-3 border border-gray-100 hover:shadow-lg transition cursor-pointer" @click="selected = event">
                <div class="flex items-center gap-3">
                    <i class="bi bi-calendar-event text-2xl text-[#b81d8f]"></i>
                    <div>
                        <div class="font-bold text-lg text-gray-800" x-text="event.name"></div>
                        <div class="text-sm text-gray-500" x-text="event.location"></div>
                    </div>
                </div>
                <div class="text-gray-700"><span x-text="event.date"></span> &bull; <span x-text="event.time"></span></div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span class="bg-gray-100 px-2 py-1 rounded" x-text="event.featured.join(', ')"></span>
                </div>
                <div class="mt-2">
                    <button class="px-3 py-1 rounded bg-[#b81d8f] text-white text-xs font-medium hover:bg-[#a01a7d] transition" @click.stop="selected = event">View Details</button>
                    <template x-if="event.status === 'upcoming'">
                        <button class="ml-2 px-3 py-1 rounded bg-gray-200 text-[#b81d8f] text-xs font-medium hover:bg-gray-300 transition" @click.stop="event.registered = true" x-text="event.registered ? 'Registered' : 'Register'"></button>
                    </template>
                </div>
            </div>
        </template>
    </div>
    <!-- Modal -->
    <div x-show="selected" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" style="display: none;" @click.self="selected = null">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-lg relative">
            <button class="absolute top-3 right-3 text-gray-400 hover:text-gray-700" @click="selected = null"><i class="bi bi-x-lg"></i></button>
            <div class="mb-4">
                <div class="font-bold text-2xl text-gray-800" x-text="selected.name"></div>
                <div class="text-sm text-gray-500 mb-2" x-text="selected.location"></div>
                <div class="text-gray-700 mb-2"><span x-text="selected.date"></span> &bull; <span x-text="selected.time"></span></div>
                <div class="text-xs text-gray-500 mb-2">Featured: <span x-text="selected.featured.join(', ')"></span></div>
            </div>
            <div class="text-gray-600 text-sm mb-4">Event details and agenda will be available soon. Register to get updates and reminders.</div>
            <div class="flex gap-2">
                <template x-if="selected.status === 'upcoming'">
                    <button class="px-4 py-2 rounded bg-[#b81d8f] text-white font-semibold hover:bg-[#a01a7d] transition" @click="selected.registered = true" x-text="selected.registered ? 'Registered' : 'Register'"></button>
                </template>
                <button class="px-4 py-2 rounded bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition" @click="selected = null">Close</button>
            </div>
        </div>
    </div>
    <!-- Empty State -->
    <template x-if="filteredEvents.length === 0">
        <div class="flex flex-col items-center justify-center py-16">
            <i class="bi bi-emoji-frown text-5xl text-gray-300 mb-4"></i>
            <div class="text-lg text-gray-500 mb-2">No events found.</div>
            <div class="text-sm text-gray-400">Try adjusting your search or filters.</div>
        </div>
    </template>
</div>
@endsection 