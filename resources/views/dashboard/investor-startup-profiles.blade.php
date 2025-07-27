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
<div x-data="startupProfiles()" x-init="init()" class="relative">
    <!-- Debug Info -->
    <!-- <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 rounded">
        <h3 class="font-bold">Debug Info:</h3>
        <p>Startups Count: <span x-text="startups.length"></span></p>
        <p>Filtered Count: <span x-text="filteredStartups.length"></span></p>
        <p>Search: <span x-text="search"></span></p>
        <p>Sector: <span x-text="sector"></span></p>
        <p>Stage: <span x-text="stage"></span></p>
        <p>Location: <span x-text="location"></span></p>
    </div> -->

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
                    <div class="relative z-10 flex flex-col h-full p-6">
                        <div class="flex items-center gap-3 mb-2">
                            <img :src="startup.logo" alt="" class="h-12 w-12 rounded-full border bg-gray-50 shadow flex-shrink-0">
                            <div class="min-w-0 flex-1">
                                <div class="font-bold text-lg text-gray-800 truncate" x-text="startup.name"></div>
                                <div class="flex gap-1 mt-1">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-[#fbeff7] text-[#b81d8f] border border-[#f3d1ea]" x-text="startup.sector"></span>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200" x-text="startup.stage"></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-gray-700 text-sm line-clamp-2 mb-3" x-text="startup.tagline"></div>
                        <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 mb-3">
                            <span class="bg-gray-100 px-2 py-1 rounded" x-text="startup.location"></span>
                            <span class="bg-gray-100 px-2 py-1 rounded" x-text="startup.stats"></span>
                        </div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-flex items-center gap-1 text-xs text-gray-400"><i class="bi bi-lock-fill"></i> Team Info Restricted</span>
                            <span class="inline-flex items-center gap-1 text-xs text-gray-400"><i class="bi bi-lock-fill"></i> Pitch Deck Restricted</span>
                        </div>
                        
                        <!-- Spacer to push buttons to bottom -->
                        <div class="flex-1"></div>
                        
                        <!-- Action buttons - always at bottom -->
                        <div class="mt-auto">
                            <div class="flex gap-2 mb-2">
                                <button class="flex-1 px-3 py-2 rounded-lg bg-[#b81d8f] text-white text-xs font-semibold shadow hover:bg-[#a01a7d] transition" @click.stop="selected = startup"><i class="bi bi-eye"></i> View Teaser</button>
                                <button class="flex-1 px-3 py-2 rounded-lg bg-gray-200 text-[#b81d8f] text-xs font-semibold shadow hover:bg-gray-300 transition" @click.stop="showRequest = true; selected = startup" x-show="!startup.has_access && startup.request_status !== 'pending'"><i class="bi bi-envelope-paper"></i> Request More Info</button>
                                <button class="flex-1 px-3 py-2 rounded-lg bg-orange-500 text-white text-xs font-semibold shadow hover:bg-orange-600 transition" @click.stop="showRequest = true; selected = startup" x-show="startup.request_status === 'rejected'"><i class="bi bi-arrow-clockwise"></i> Request Again</button>
                                <button class="flex-1 px-3 py-2 rounded-lg bg-green-600 text-white text-xs font-semibold shadow" x-show="startup.has_access" disabled><i class="bi bi-check"></i> Access Granted</button>
                            </div>
                            <!-- Request Status Badge -->
                            <div x-show="startup.request_status === 'pending'" class="mt-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="bi bi-clock mr-1"></i> Request Pending
                                </span>
                            </div>
                            <div x-show="startup.request_status === 'rejected'" class="mt-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="bi bi-x-circle mr-1"></i> Request Declined
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </template>
    
    <!-- Empty State -->
    <template x-if="!loading && filteredStartups.length === 0">
        <div class="flex flex-col items-center justify-center py-16">
            <i class="bi bi-emoji-frown text-5xl text-gray-300 mb-4"></i>
            <div class="text-lg text-gray-500 mb-2">No startups found.</div>
            <div class="text-sm text-gray-400">Try adjusting your search or filters.</div>
        </div>
    </template>
    
    <!-- Modal -->
    <div x-show="selected" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" style="display: none;" @click.self="selected = null">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl relative overflow-hidden" x-show="selected">
            <div class="bg-gradient-to-r from-[#b81d8f] to-[#fbeff7] px-8 py-6 flex items-center gap-4">
                <img :src="selected?.logo" alt="" class="h-16 w-16 rounded-full border-4 border-white shadow-lg">
                <div>
                    <div class="font-bold text-2xl text-white" x-text="selected?.name"></div>
                    <div class="flex gap-2 mt-1">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-white text-[#b81d8f] border border-[#f3d1ea]" x-text="selected?.sector"></span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-white text-gray-600 border border-gray-200" x-text="selected?.stage"></span>
                    </div>
                </div>
                <button class="absolute top-3 right-3 text-white hover:text-[#b81d8f] text-xl" @click="selected = null"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="px-8 py-6">
                <div class="mb-2 text-gray-700 font-semibold" x-text="selected?.tagline"></div>
                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 mb-2">
                    <span class="bg-gray-100 px-2 py-1 rounded" x-text="selected?.location"></span>
                    <span class="bg-gray-100 px-2 py-1 rounded" x-text="selected?.stats"></span>
                </div>
                <div class="text-gray-600 text-sm mb-4" x-text="selected?.description"></div>
                
                <!-- Funding Information -->
                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                    <h4 class="font-semibold text-gray-800 mb-2">Funding Information</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Seeking:</span>
                            <span class="font-semibold text-green-600 ml-1" x-text="selected?.funding_needed || 'N/A'"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Revenue:</span>
                            <span class="font-semibold text-gray-800 ml-1" x-text="selected?.monthly_revenue || 'N/A'"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Team Size:</span>
                            <span class="font-semibold text-gray-800 ml-1" x-text="selected?.team_size || 'N/A'"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Founded:</span>
                            <span class="font-semibold text-gray-800 ml-1" x-text="selected?.year_founded || 'N/A'"></span>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="font-semibold text-gray-700 mb-1 flex items-center gap-2"><i class="bi bi-lock-fill text-gray-400"></i> Team Info Restricted</div>
                    <div class="flex gap-3 opacity-40 blur-sm pointer-events-none select-none">
                        <template x-for="member in selected?.team || []" :key="member.name">
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
                    <button class="px-4 py-2 rounded bg-[#b81d8f] text-white font-semibold hover:bg-[#a01a7d] transition flex items-center gap-2" @click="showRequest = true" x-show="!selected?.has_access && selected?.request_status !== 'pending'"><i class="bi bi-envelope-paper"></i> Request More Info</button>
                    <button class="px-4 py-2 rounded bg-orange-500 text-white font-semibold hover:bg-orange-600 transition flex items-center gap-2" @click="showRequest = true" x-show="selected?.request_status === 'rejected'"><i class="bi bi-arrow-clockwise"></i> Request Again</button>
                    <button class="px-4 py-2 rounded bg-green-600 text-white font-semibold" x-show="selected?.has_access" disabled><i class="bi bi-check"></i> Access Granted</button>
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
                    <div class="text-lg font-bold text-[#b81d8f] mb-2 flex items-center gap-2">
                        <i class="bi" :class="selected?.request_status === 'rejected' ? 'bi-arrow-clockwise' : 'bi-envelope-paper'"></i> 
                        <span x-text="selected?.request_status === 'rejected' ? 'Request Again' : 'Request More Info'"></span>
                    </div>
                    <div class="text-sm text-gray-600 mb-4">
                        <template x-if="selected?.request_status === 'rejected'">
                            You're requesting access to <strong x-text="selected?.name"></strong>'s full profile again. Your previous request was declined, but you can try again with additional context.
                        </template>
                        <template x-if="selected?.request_status !== 'rejected'">
                            You're requesting access to <strong x-text="selected?.name"></strong>'s full profile. This request will be sent to the startup founder and admin.
                        </template>
                    </div>
                    <textarea class="border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" :placeholder="selected?.request_status === 'rejected' ? 'Additional context or reason for re-request (optional)' : 'Message to the startup founder (optional)'" x-model="requestForm.message" rows="4"></textarea>
                    <button type="submit" class="px-4 py-2 rounded bg-[#b81d8f] text-white font-semibold hover:bg-[#a01a7d] transition flex items-center gap-2 justify-center" :disabled="loading">
                        <i class="bi bi-send" x-show="!loading"></i>
                        <i class="bi bi-arrow-clockwise animate-spin" x-show="loading"></i>
                        <span x-text="loading ? 'Sending...' : (selected?.request_status === 'rejected' ? 'Send Re-request' : 'Send Request')"></span>
                    </button>
                </form>
            </template>
            <template x-if="requestSuccess">
                <div class="flex flex-col items-center justify-center py-8">
                    <i class="bi bi-check-circle-fill text-4xl text-[#b81d8f] mb-4"></i>
                    <div class="text-lg font-semibold text-gray-700 mb-2">Request Sent!</div>
                    <div class="text-sm text-gray-500 text-center">Your request for more information has been submitted. The startup founder and admin will be notified.</div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
function startupProfiles() {
    return {
        search: '',
        sector: '',
        stage: '',
        location: '',
        startups: @json($startupsData ?? []),
        selected: null,
        showRequest: false,
        requestSuccess: false,
        loading: false,
        requestForm: { message: '' },
        
        get filteredStartups() {
            console.log('Filtering startups...');
            console.log('Startups data:', this.startups);
            console.log('Startups count:', this.startups.length);
            
            return this.startups.filter(s => {
                const matchesSearch = !this.search || 
                    (s.name && s.name.toLowerCase().includes(this.search.toLowerCase())) || 
                    (s.tagline && s.tagline.toLowerCase().includes(this.search.toLowerCase()));
                
                const matchesSector = !this.sector || (s.sector && s.sector === this.sector);
                const matchesStage = !this.stage || (s.stage && s.stage === this.stage);
                const matchesLocation = !this.location || (s.location && s.location === this.location);
                
                return matchesSearch && matchesSector && matchesStage && matchesLocation;
            });
        },
        
        async submitRequest() {
            if (!this.selected) {
                console.error('No startup selected');
                return;
            }
            
            console.log('Submitting request for startup:', this.selected.id);
            console.log('Request message:', this.requestForm.message);
            
            this.loading = true;
            try {
                // Get CSRF token from meta tag or form
                const csrfToken = document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || 
                                 document.querySelector('input[name="_token"]')?.value ||
                                 '{{ csrf_token() }}';
                
                console.log('CSRF Token:', csrfToken);
                console.log('Request URL:', `/investor/startup/${this.selected.id}/request-access`);
                
                const response = await fetch(`/investor/startup/${this.selected.id}/request-access`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        message: this.requestForm.message
                    })
                });
                
                console.log('Response status:', response.status);
                console.log('Response ok:', response.ok);
                
                if (response.ok) {
                    this.requestSuccess = true;
                    setTimeout(() => { 
                        this.showRequest = false; 
                        this.requestSuccess = false; 
                        this.requestForm.message = '';
                    }, 2000);
                } else {
                    alert('Failed to send request. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to send request. Please try again.');
            } finally {
                this.loading = false;
            }
        },
        
        init() {
            console.log('Initializing startup profiles page');
            console.log('Startups data on init:', this.startups);
            console.log('Startups count on init:', this.startups.length);
            
            // Debug: Log each startup
            this.startups.forEach((startup, index) => {
                console.log(`Startup ${index}:`, startup);
            });
        }
    }
}
</script>
@endsection 