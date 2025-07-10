@extends('layouts.investor')
@section('title', 'Success Stories')
@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2"><i class="bi bi-award text-[#b81d8f]"></i> Success Stories</h2>
    <div class="flex gap-2">
        <input type="text" placeholder="Search stories..." class="border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" x-model="search">
        <select class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" x-model="filter">
            <option value="">All Sectors</option>
            <option>Fintech</option>
            <option>Health</option>
            <option>AgriTech</option>
            <option>EdTech</option>
        </select>
    </div>
</div>
<div x-data="{
    search: '',
    filter: '',
    stories: [
        {id: 1, name: 'PayLink', sector: 'Fintech', headline: 'Secured $1M in Series A', summary: 'PayLink revolutionized payments and secured major funding.', logo: 'https://logo.clearbit.com/paypal.com', impact: 'Expanded to 3 countries', year: 2024},
        {id: 2, name: 'AgroPro', sector: 'AgriTech', headline: 'Empowered 10,000 farmers', summary: 'AgroPro scaled operations and improved food security.', logo: 'https://logo.clearbit.com/agripro.com', impact: 'Doubled crop yields', year: 2023},
        {id: 3, name: 'MediQuick', sector: 'Health', headline: 'Reached 50,000 users', summary: 'MediQuick made healthcare accessible to thousands.', logo: 'https://logo.clearbit.com/mediquick.com', impact: 'Reduced wait times by 60%', year: 2024},
    ],
    get filteredStories() {
        return this.stories.filter(s =>
            (!this.search || s.name.toLowerCase().includes(this.search.toLowerCase()) || s.headline.toLowerCase().includes(this.search.toLowerCase())) &&
            (!this.filter || s.sector === this.filter)
        );
    },
    selected: null
}" class="relative">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="story in filteredStories" :key="story.id">
            <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-3 border border-gray-100 hover:shadow-lg transition cursor-pointer" @click="selected = story">
                <div class="flex items-center gap-3">
                    <img :src="story.logo" alt="" class="h-12 w-12 rounded-full border">
                    <div>
                        <div class="font-bold text-lg text-gray-800" x-text="story.name"></div>
                        <div class="text-sm text-gray-500" x-text="story.sector"></div>
                    </div>
                </div>
                <div class="font-semibold text-[#b81d8f]" x-text="story.headline"></div>
                <div class="text-gray-700" x-text="story.summary"></div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span class="bg-gray-100 px-2 py-1 rounded" x-text="story.impact"></span>
                    <span class="bg-gray-100 px-2 py-1 rounded" x-text="story.year"></span>
                </div>
                <div class="mt-2">
                    <button class="px-3 py-1 rounded bg-[#b81d8f] text-white text-xs font-medium hover:bg-[#a01a7d] transition" @click.stop="selected = story">Read More</button>
                </div>
            </div>
        </template>
    </div>
    <!-- Modal -->
    <div x-show="selected" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" style="display: none;" @click.self="selected = null">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-lg relative">
            <button class="absolute top-3 right-3 text-gray-400 hover:text-gray-700" @click="selected = null"><i class="bi bi-x-lg"></i></button>
            <div class="flex items-center gap-4 mb-4">
                <img :src="selected.logo" alt="" class="h-16 w-16 rounded-full border">
                <div>
                    <div class="font-bold text-2xl text-gray-800" x-text="selected.name"></div>
                    <div class="text-sm text-gray-500" x-text="selected.sector"></div>
                </div>
            </div>
            <div class="font-semibold text-[#b81d8f] mb-2" x-text="selected.headline"></div>
            <div class="mb-2 text-gray-700" x-text="selected.summary"></div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                <span class="bg-gray-100 px-2 py-1 rounded" x-text="selected.impact"></span>
                <span class="bg-gray-100 px-2 py-1 rounded" x-text="selected.year"></span>
            </div>
            <div class="text-gray-600 text-sm mb-4">Full story details and impact metrics can be shared here. This is a placeholder for the full success story content.</div>
            <div class="flex gap-2">
                <button class="px-4 py-2 rounded bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition" @click="selected = null">Close</button>
            </div>
        </div>
    </div>
    <!-- Empty State -->
    <template x-if="filteredStories.length === 0">
        <div class="flex flex-col items-center justify-center py-16">
            <i class="bi bi-emoji-frown text-5xl text-gray-300 mb-4"></i>
            <div class="text-lg text-gray-500 mb-2">No stories found.</div>
            <div class="text-sm text-gray-400">Try adjusting your search or filters.</div>
        </div>
    </template>
</div>
@endsection 