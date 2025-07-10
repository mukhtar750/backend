<div class="flex flex-col h-full">
    <!-- Chat Header -->
    <div class="sticky top-0 z-10 bg-white border-b flex items-center gap-3 px-6 py-4">
        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="h-10 w-10 rounded-full object-cover" alt="Sarah Johnson">
        <div class="flex-1">
            <div class="font-semibold text-lg text-gray-900">Sarah Johnson</div>
            <div class="text-xs text-green-500">Online</div>
        </div>
        <div class="flex gap-2">
            <button class="p-2 rounded-full hover:bg-gray-100"><i class="bi bi-telephone text-lg"></i></button>
            <button class="p-2 rounded-full hover:bg-gray-100"><i class="bi bi-camera-video text-lg"></i></button>
            <button class="p-2 rounded-full hover:bg-gray-100"><i class="bi bi-info-circle text-lg"></i></button>
        </div>
    </div>
    <!-- Message History -->
    <div class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-white flex flex-col gap-4">
        <!-- Example message bubbles -->
        <div class="flex items-start gap-3">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="h-8 w-8 rounded-full object-cover" alt="Sarah Johnson">
            <div>
                <div class="bg-gray-100 rounded-2xl px-4 py-2 text-gray-800 shadow-sm">Hi, I wanted to thank you for your last session!</div>
                <div class="text-xs text-gray-400 mt-1">Sarah Johnson • 2 hours ago</div>
            </div>
        </div>
        <div class="flex items-start gap-3 flex-row-reverse">
            <img src="https://i.pravatar.cc/32" class="h-8 w-8 rounded-full object-cover" alt="You">
            <div>
                <div class="bg-purple-100 rounded-2xl px-4 py-2 text-gray-800 shadow-sm">You're welcome, Sarah! Let me know if you have more questions.</div>
                <div class="text-xs text-gray-400 mt-1 text-right">You • 1 hour ago</div>
            </div>
        </div>
        <!-- ... more messages ... -->
    </div>
</div> 