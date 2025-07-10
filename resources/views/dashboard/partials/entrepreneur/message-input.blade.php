<form class="flex gap-3 items-center relative">
    <label class="cursor-pointer">
        <input type="file" class="hidden" multiple>
        <i class="bi bi-paperclip text-xl text-gray-400 hover:text-purple-600"></i>
    </label>
    <button type="button" class="text-xl text-gray-400 hover:text-yellow-500"><i class="bi bi-emoji-smile"></i></button>
    <input type="text" class="flex-1 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-400" placeholder="Type your message...">
    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition disabled:opacity-50">Send</button>
    <!-- Attachment preview (hidden by default, show with Alpine.js if files selected) -->
    <div x-show="false" class="absolute left-0 bottom-full mb-2 flex gap-2">
        <!-- Example preview -->
        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-xs">IMG</div>
    </div>
</form> 