@extends('layouts.investor')
@section('title', 'Startup Profiles')
@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2"><i class="bi bi-graph-up-arrow text-[#b81d8f]"></i> Startup Profiles</h2>
    <div class="flex flex-wrap gap-2">
        <input type="text" placeholder="Search startups..." class="border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" x-model="search">
        <select class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" x-model="sector">
            <option value="">All Sectors</option>
            <option>Fintech</option>
            <option>Health</option>
            <option>AgriTech</option>
            <option>EdTech</option>
            <option>Logistics</option>
            <option>Retail</option>
        </select>
        <select class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" x-model="stage">
            <option value="">All Stages</option>
            <option>Pre-Seed</option>
            <option>Seed</option>
            <option>Series A</option>
        </select>
        <select class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" x-model="location">
            <option value="">All Locations</option>
            <option>Lagos</option>
            <option>Kano</option>
            <option>Abuja</option>
            <option>Ibadan</option>
            <option>Accra</option>
            <option>Nairobi</option>
        </select>
    </div>
</div>
<div x-data="{
    search: '',
    sector: '',
    stage: '',
    location: '',
    startups: [
        {id: 1, name: 'PayLink', sector: 'Fintech', tagline: 'Payments made easy', logo: 'https://logo.clearbit.com/paypal.com', stage: 'Seed', location: 'Lagos', stats: '1000+ users', teaser: true, description: 'PayLink is revolutionizing digital payments for African SMEs.', team: [{name: 'Jane Doe', role: 'CEO', photo: 'https://i.pravatar.cc/40?img=1'}], pitchdeck: false},
        {id: 2, name: 'AgroPro', sector: 'AgriTech', tagline: 'Empowering farmers', logo: 'https://logo.clearbit.com/agripro.com', stage: 'Series A', location: 'Kano', stats: 'MVP Launched', teaser: true, description: 'AgroPro connects farmers to markets and resources.', team: [{name: 'John Smith', role: 'Founder', photo: 'https://i.pravatar.cc/40?img=2'}], pitchdeck: true},
        {id: 3, name: 'MediQuick', sector: 'Health', tagline: 'Healthcare on demand', logo: 'https://logo.clearbit.com/mediquick.com', stage: 'Pre-Seed', location: 'Abuja', stats: 'Pilot phase', teaser: true, description: 'MediQuick delivers healthcare to your doorstep.', team: [{name: 'Aisha Bello', role: 'CTO', photo: 'https://i.pravatar.cc/40?img=3'}], pitchdeck: false},
        {id: 4, name: 'Learnly', sector: 'EdTech', tagline: 'Next-gen learning', logo: 'https://logo.clearbit.com/udemy.com', stage: 'Seed', location: 'Ibadan', stats: '500+ students', teaser: true, description: 'Learnly is making quality education accessible.', team: [{name: 'Samuel Okoro', role: 'COO', photo: 'https://i.pravatar.cc/40?img=4'}], pitchdeck: true},
        {id: 5, name: 'CargoSwift', sector: 'Logistics', tagline: 'Smart cargo tracking', logo: 'https://logo.clearbit.com/fedex.com', stage: 'Seed', location: 'Accra', stats: 'Launched in 3 countries', teaser: true, description: 'CargoSwift provides real-time cargo tracking for African businesses.', team: [{name: 'Kwame Mensah', role: 'CEO', photo: 'https://i.pravatar.cc/40?img=5'}], pitchdeck: false},
        {id: 6, name: 'RetailX', sector: 'Retail', tagline: 'Omnichannel retail made easy', logo: 'https://logo.clearbit.com/shopify.com', stage: 'Series A', location: 'Nairobi', stats: '200+ stores onboarded', teaser: true, description: 'RetailX helps retailers manage online and offline sales seamlessly.', team: [{name: 'Linda Njeri', role: 'CMO', photo: 'https://i.pravatar.cc/40?img=6'}], pitchdeck: true},
        {id: 7, name: 'HealthBridge', sector: 'Health', tagline: 'Connecting patients to doctors', logo: 'https://logo.clearbit.com/healthline.com', stage: 'Seed', location: 'Lagos', stats: '10,000+ consultations', teaser: true, description: 'HealthBridge is a telemedicine platform for Africa.', team: [{name: 'Chinedu Eze', role: 'Founder', photo: 'https://i.pravatar.cc/40?img=7'}], pitchdeck: false},
        {id: 8, name: 'FarmFresh', sector: 'AgriTech', tagline: 'Fresh produce, direct to you', logo: 'https://logo.clearbit.com/organicvalley.coop', stage: 'Pre-Seed', location: 'Kano', stats: 'Pilot with 50+ farmers', teaser: true, description: 'FarmFresh connects smallholder farmers to urban markets.', team: [{name: 'Fatima Musa', role: 'COO', photo: 'https://i.pravatar.cc/40?img=8'}], pitchdeck: false},
    ],
    get filteredStartups() {
        return this.startups.filter(s =>
            (!this.search || s.name.toLowerCase().includes(this.search.toLowerCase()) || s.tagline.toLowerCase().includes(this.search.toLowerCase())) &&
            (!this.sector || s.sector === this.sector) &&
            (!this.stage || s.stage === this.stage) &&
            (!this.location || s.location === this.location)
        );
    },
    selected: null,
    showRequest: false,
    requestSuccess: false,
    loading: true,
    requestForm: { name: '', email: '', message: '' },
    submitRequest() {
        this.requestSuccess = true;
        setTimeout(() => { this.showRequest = false; this.requestSuccess = false; }, 2000);
        this.requestForm = { name: '', email: '', message: '' };
    },
    init() {
        setTimeout(() => { this.loading = false; }, 1200);
    }
}" x-init="init" class="relative">
    <template x-if="loading">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <template x-for="i in 8" :key="i">
                <div class="animate-pulse bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex flex-col gap-4">
                    <div class="h-12 w-12 rounded-full bg-gray-200"></div>
                    <div class="h-4 w-2/3 bg-gray-200 rounded"></div>
                    <div class="h-3 w-1/2 bg-gray-100 rounded"></div>
                    <div class="flex gap-2">
                        <div class="h-3 w-12 bg-gray-100 rounded"></div>
                        <div class="h-3 w-10 bg-gray-100 rounded"></div>
                    </div>
                    <div class="h-3 w-20 bg-gray-100 rounded"></div>
                    <div class="h-3 w-24 bg-gray-100 rounded"></div>
                    <div class="flex gap-2 mt-2">
                        <div class="h-8 w-20 bg-gray-100 rounded"></div>
                        <div class="h-8 w-20 bg-gray-100 rounded"></div>
                    </div>
                </div>
            </template>
        </div>
    </template>
    <template x-if="!loading">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <template x-for="startup in filteredStartups" :key="startup.id">
            <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl hover:border-[#b81d8f] hover:scale-[1.03] transition-all duration-200 cursor-pointer overflow-hidden group" @click="selected = startup">
                <div class="absolute inset-0 bg-gradient-to-br from-[#fbeff7] via-white to-[#fbeff7] opacity-80 group-hover:opacity-100 transition"></div>
                <div class="relative z-10 flex flex-col gap-3 p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <img :src="startup.logo" alt="" class="h-12 w-12 rounded-full border bg-gray-50 shadow">
                        <div>
                            <div class="font-bold text-lg text-gray-800" x-text="startup.name"></div>
                            <div class="flex gap-1 mt-1">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-[#fbeff7] text-[#b81d8f] border border-[#f3d1ea]" x-text="startup.sector"></span>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200" x-text="startup.stage"></span>
                            </div>
                        </div>
                    </div>
                    <div class="text-gray-700 text-sm line-clamp-2" x-text="startup.tagline"></div>
                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                        <span class="bg-gray-100 px-2 py-1 rounded" x-text="startup.location"></span>
                        <span class="bg-gray-100 px-2 py-1 rounded" x-text="startup.stats"></span>
                    </div>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="inline-flex items-center gap-1 text-xs text-gray-400"><i class="bi bi-lock-fill"></i> Team Info Restricted</span>
                        <span class="inline-flex items-center gap-1 text-xs text-gray-400"><i class="bi bi-lock-fill"></i> Pitch Deck Restricted</span>
                    </div>
                    <div class="mt-3 flex gap-2">
                        <button class="flex-1 px-3 py-2 rounded-lg bg-[#b81d8f] text-white text-xs font-semibold shadow hover:bg-[#a01a7d] transition" @click.stop="selected = startup"><i class="bi bi-eye"></i> View Teaser</button>
                        <button class="flex-1 px-3 py-2 rounded-lg bg-gray-200 text-[#b81d8f] text-xs font-semibold shadow hover:bg-gray-300 transition" @click.stop="showRequest = true"><i class="bi bi-envelope-paper"></i> Request More Info</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
    </template>
    <!-- Modal -->
    <div x-show="selected" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" style="display: none;" @click.self="selected = null">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl relative overflow-hidden">
            <div class="bg-gradient-to-r from-[#b81d8f] to-[#fbeff7] px-8 py-6 flex items-center gap-4">
                <img :src="selected.logo" alt="" class="h-16 w-16 rounded-full border-4 border-white shadow-lg">
                <div>
                    <div class="font-bold text-2xl text-white" x-text="selected.name"></div>
                    <div class="flex gap-2 mt-1">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-white text-[#b81d8f] border border-[#f3d1ea]" x-text="selected.sector"></span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-white text-gray-600 border border-gray-200" x-text="selected.stage"></span>
                    </div>
                </div>
                <button class="absolute top-3 right-3 text-white hover:text-[#b81d8f] text-xl" @click="selected = null"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="px-8 py-6">
                <div class="mb-2 text-gray-700 font-semibold" x-text="selected.tagline"></div>
                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 mb-2">
                    <span class="bg-gray-100 px-2 py-1 rounded" x-text="selected.location"></span>
                    <span class="bg-gray-100 px-2 py-1 rounded" x-text="selected.stats"></span>
                </div>
                <div class="text-gray-600 text-sm mb-4" x-text="selected.description"></div>
                <div class="mb-4">
                    <div class="font-semibold text-gray-700 mb-1 flex items-center gap-2"><i class="bi bi-lock-fill text-gray-400"></i> Team Info Restricted</div>
                    <div class="flex gap-3 opacity-40 blur-sm pointer-events-none select-none">
                        <template x-for="member in selected.team" :key="member.name">
                            <div class="flex items-center gap-2 bg-gray-50 rounded px-2 py-1">
                                <img :src="member.photo" alt="" class="h-8 w-8 rounded-full border">
                                <div>
                                    <div class="text-xs font-semibold text-gray-800" x-text="member.name"></div>
                                    <div class="text-xs text-gray-500" x-text="member.role"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="font-semibold text-gray-700 mb-1 flex items-center gap-2"><i class="bi bi-lock-fill text-gray-400"></i> Pitch Deck Restricted</div>
                    <div class="opacity-40 blur-sm pointer-events-none select-none">
                        <a href="#" class="inline-flex items-center gap-2 px-3 py-2 rounded bg-[#b81d8f] text-white text-xs font-medium hover:bg-[#a01a7d] transition"><i class="bi bi-file-earmark-pdf"></i> Download Pitch Deck</a>
                    </div>
                </div>
                <div class="mb-4 text-center text-sm text-gray-500 bg-gray-50 rounded p-3 flex items-center gap-2 justify-center">
                    <i class="bi bi-info-circle text-[#b81d8f]"></i>
                    To unlock full profile details, please request access from the startup or admin.
                </div>
                <div class="flex gap-2 justify-center">
                    <button class="px-4 py-2 rounded bg-[#b81d8f] text-white font-semibold hover:bg-[#a01a7d] transition flex items-center gap-2" @click="showRequest = true"><i class="bi bi-envelope-paper"></i> Request More Info</button>
                    <button class="px-4 py-2 rounded bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition" @click="selected = null">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Request More Info Modal -->
    <div x-show="showRequest" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" style="display: none;" @click.self="showRequest = false">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 relative">
            <button class="absolute top-3 right-3 text-gray-400 hover:text-[#b81d8f] text-xl" @click="showRequest = false"><i class="bi bi-x-lg"></i></button>
            <template x-if="!requestSuccess">
                <form @submit.prevent="submitRequest" class="flex flex-col gap-4">
                    <div class="text-lg font-bold text-[#b81d8f] mb-2 flex items-center gap-2"><i class="bi bi-envelope-paper"></i> Request More Info</div>
                    <input type="text" class="border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" placeholder="Your Name" x-model="requestForm.name" required>
                    <input type="email" class="border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" placeholder="Your Email" x-model="requestForm.email" required>
                    <textarea class="border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" placeholder="Message (optional)" x-model="requestForm.message"></textarea>
                    <button type="submit" class="px-4 py-2 rounded bg-[#b81d8f] text-white font-semibold hover:bg-[#a01a7d] transition flex items-center gap-2 justify-center"><i class="bi bi-send"></i> Send Request</button>
                </form>
            </template>
            <template x-if="requestSuccess">
                <div class="flex flex-col items-center justify-center py-8">
                    <i class="bi bi-check-circle-fill text-4xl text-[#b81d8f] mb-4"></i>
                    <div class="text-lg font-semibold text-gray-700 mb-2">Request Sent!</div>
                    <div class="text-sm text-gray-500 text-center">Your request for more information has been submitted. The startup or admin will contact you soon.</div>
                </div>
            </template>
        </div>
    </div>
    <!-- Empty State -->
    <template x-if="!loading && filteredStartups.length === 0">
        <div class="flex flex-col items-center justify-center py-16">
            <i class="bi bi-emoji-frown text-5xl text-gray-300 mb-4"></i>
            <div class="text-lg text-gray-500 mb-2">No startups found.</div>
            <div class="text-sm text-gray-400">Try adjusting your search or filters.</div>
        </div>
    </template>
</div>
@endsection 