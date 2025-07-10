<div class="bg-white p-6 rounded-lg shadow mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Resource Uploads</h3>
        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center gap-2 text-sm">
            <i class="bi bi-upload"></i> Upload New
        </button>
    </div>
    <div class="space-y-4">
        @foreach ([['title' => 'Business Plan Template', 'date' => '2024-06-01'], ['title' => 'Pitch Deck Guide', 'date' => '2024-05-28']] as $resource)
            <div class="flex items-center justify-between bg-gray-50 px-4 py-3 rounded-md hover:bg-gray-100 transition">
                <div>
                    <div class="font-semibold text-gray-800">{{ $resource['title'] }}</div>
                    <div class="text-xs text-gray-500">Uploaded: {{ $resource['date'] }}</div>
                </div>
                <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-xs flex items-center gap-1">
                    <i class="bi bi-eye"></i> View
                </button>
            </div>
        @endforeach
    </div>
</div> 