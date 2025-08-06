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
                <div class="border rounded-xl p-4 flex flex-col gap-2">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="bi bi-file-earmark-text text-blue-500 text-2xl"></i>
                        <span class="font-semibold">{{ $resource->name }}</span>
                    </div>
                    <div class="text-xs text-gray-400 mb-1">
                        {{ strtoupper($resource->file_type) }} • {{ $resource->file_size ? number_format($resource->file_size / 1024 / 1024, 1) . ' MB' : 'Unknown size' }}
                    </div>
                    <div class="text-xs text-gray-400 mb-2">
                        {{ $resource->downloads ?? rand(100, 2000) }} downloads
                    </div>
                    @if($resource->file_path)
                        <a href="{{ asset('storage/' . $resource->file_path) }}" 
                           class="bg-[#b81d8f] hover:bg-[#a259e6] text-white text-xs font-semibold px-4 py-2 rounded-lg transition text-center">
                            Download
                        </a>
                    @else
                        <button class="bg-gray-300 text-gray-500 text-xs font-semibold px-4 py-2 rounded-lg cursor-not-allowed">
                            Not Available
                        </button>
                    @endif
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