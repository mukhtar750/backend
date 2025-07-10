<div x-data="{ search: '' }" class="h-full flex flex-col">
    <div class="mb-4">
        <input type="text" x-model="search" placeholder="Search..." class="w-full px-3 py-2 rounded-lg border focus:ring-2 focus:ring-purple-400 bg-white" />
    </div>
    <ul class="space-y-2 flex-1 overflow-y-auto pr-1">
        <!-- Example conversation item, repeat for each conversation -->
        <li class="flex items-center gap-3 p-3 rounded-lg cursor-pointer border border-transparent hover:bg-purple-50 transition group relative bg-purple-50 border-purple-200">
            <div class="relative">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="h-10 w-10 rounded-full object-cover" alt="Sarah Johnson">
                <span class="absolute bottom-0 right-0 h-3 w-3 bg-green-400 border-2 border-white rounded-full"></span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-gray-900 flex items-center gap-2">
                    Sarah Johnson
                    <span class="ml-1 bg-purple-600 text-white text-xs rounded-full px-2 py-0.5">2</span>
                </div>
                <div class="text-xs text-gray-500 truncate w-32">Thank you for your feedback!</div>
            </div>
            <span class="absolute right-3 top-1/2 -translate-y-1/2 h-2 w-2 bg-purple-500 rounded-full" title="Unread"></span>
        </li>
        <!-- ... more items ... -->
    </ul>
</div> 