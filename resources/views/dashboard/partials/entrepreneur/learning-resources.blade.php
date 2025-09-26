<div class="bg-white rounded-2xl shadow p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold">Learning Resources</h3>
        <a href="{{ route('entrepreneur.calendar') }}" class="bg-[#b81d8f] hover:bg-[#a259e6] text-white text-xs font-semibold px-5 py-2 rounded-lg shadow transition flex items-center gap-2">
            <i class="bi bi-calendar-event"></i> View Calendar
        </a>
    </div>
    
    @if(isset($learningResources) && $learningResources->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @foreach($learningResources as $resource)
                @php
                    $isShared = $resource->shares()->where('shared_with', auth()->id())->exists();
                    $shareDetails = $resource->getShareFor(auth()->id());
                @endphp
                <div class="border rounded-xl p-4 flex flex-col h-full">
                    <!-- Title and Icon - Fixed height -->
                    <div class="flex items-center gap-2 mb-3 h-12">
                        <i class="bi bi-file-earmark-text text-blue-500 text-2xl flex-shrink-0"></i>
                        <span class="font-semibold text-sm leading-tight">{{ Str::limit($resource->name, 30) }}</span>
                    </div>
                    
                    <!-- BDSP Info - Fixed height -->
                    <div class="text-xs text-gray-600 mb-3 h-5">
                        <i class="bi bi-person mr-1"></i>
                        {{ Str::limit($resource->bdsp->name ?? 'Unknown BDSP', 25) }}
                    </div>
                    
                    <!-- Sharing Status - Fixed height container -->
                    <div class="mb-3 h-20">
                        @if($isShared && $shareDetails)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-2">
                                <div class="text-xs text-green-800 font-medium mb-1">
                                    <i class="bi bi-share mr-1"></i>Shared with you
                                </div>
                                @if($shareDetails->message)
                                    <div class="text-xs text-green-700 italic mb-1">{{ Str::limit($shareDetails->message, 40) }}</div>
                                @else
                                    <div class="text-xs text-green-700 italic mb-1">&nbsp;</div>
                                @endif
                                <div class="text-xs text-green-600">{{ $shareDetails->created_at->diffForHumans() }}</div>
                            </div>
                        @else
                            <!-- Empty space to maintain height consistency -->
                            <div class="h-full"></div>
                        @endif
                    </div>
                    
                    <!-- File Details - Fixed height -->
                    <div class="text-xs text-gray-400 mb-3 h-8">
                        <div class="mb-1">{{ strtoupper($resource->file_type) }} • {{ $resource->file_size ? number_format($resource->file_size / 1024 / 1024, 1) . ' MB' : 'Unknown size' }}</div>
                        <div>{{ $resource->downloads ?? rand(100, 2000) }} downloads</div>
                    </div>
                    
                    <!-- Download Button - Push to bottom -->
                    <div class="mt-auto">
                        @if($resource->file_path)
                            <a href="{{ route('entrepreneur.resource.download', $resource->id) }}" 
                               class="w-full bg-[#b81d8f] hover:bg-[#a259e6] text-white text-xs font-semibold px-4 py-2 rounded-lg transition text-center block">
                                Download
                            </a>
                        @else
                            <button class="w-full bg-gray-300 text-gray-500 text-xs font-semibold px-4 py-2 rounded-lg cursor-not-allowed">
                                Not Available
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center text-gray-500 py-8">
            <i class="bi bi-file-earmark-text text-4xl mb-4"></i>
            <p class="text-lg font-semibold">No Learning Resources Available</p>
            <p class="text-sm">Your paired BDSPs and mentors haven't uploaded any approved resources yet.</p>
        </div>
    @endif
</div> 