<form action="{{ route('bdsp.messages.store') }}" method="POST" enctype="multipart/form-data" class="flex gap-3 items-center relative">
    @csrf
    <input type="hidden" name="recipient_id" value="{{ $otherUser->id }}">
    <label class="cursor-pointer">
        <input type="file" name="file" class="hidden" id="bdspMessageFile">
        <i class="bi bi-paperclip text-xl text-gray-400 hover:text-purple-600"></i>
    </label>
    <textarea name="content" rows="1" class="flex-1 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-400 resize-none" placeholder="Type your message..." required></textarea>
    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition disabled:opacity-50">Send</button>
</form> 