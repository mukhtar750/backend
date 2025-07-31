@extends('admin.layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Messages</h1>
    <button onclick="openComposeModal()" class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg shadow hover:bg-[#9e1879] transition flex items-center">
        <i class="bi bi-plus-circle mr-2"></i> Compose Message
    </button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="space-y-4">
                <a href="{{ route('messages.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-purple-100 text-purple-800 font-semibold">
                    <i class="bi bi-inbox-fill"></i> All Messages
                    @if(auth()->user()->getUnreadMessageCount() > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ auth()->user()->getUnreadMessageCount() }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:col-span-3">
        <div class="bg-white rounded-lg shadow">
            <!-- Message List -->
            <div class="border-b border-gray-200">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800">Recent Conversations</h2>
                </div>
            </div>
            
            <div class="divide-y divide-gray-200">
                @php
                    $conversations = auth()->user()->getConversations();
                @endphp
                
                @forelse($conversations as $conversation)
                    @php
                        $otherUser = $conversation->getOtherUser(auth()->id());
                        $unreadCount = $conversation->getUnreadCount(auth()->id());
                        $latestMessage = $conversation->latestMessage;
                    @endphp
                    <div class="p-4 hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route('admin.messages.show', $conversation->id) }}'">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="bi bi-person text-purple-600"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <h3 class="font-semibold text-gray-800">{{ $otherUser->name ?? 'N/A' }}</h3>
                                        <span class="text-xs text-gray-500">{{ $otherUser ? ucfirst($otherUser->role) : 'N/A' }}</span>
                                        @if($latestMessage)
                                            <span class="text-xs text-gray-500">{{ $latestMessage->created_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                    @if($latestMessage)
                                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($latestMessage->content, 100) }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($unreadCount > 0)
                                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $unreadCount }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-chat text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No conversations yet</h3>
                        <p class="text-gray-500 mb-4">Start messaging users to begin conversations.</p>
                        <button onclick="openComposeModal()" class="bg-purple-600 text-white px-4 py-2 rounded-lg shadow hover:bg-purple-700 transition">
                            Start New Conversation
                        </button>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Compose Message Modal -->
<div id="composeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">New Message</h3>
                <button onclick="closeComposeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- Form -->
            <form id="messageForm" class="space-y-4">
                <!-- Recipient -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">To:</label>
                    <select id="recipientId" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none" required>
                        <option value="">Select recipient...</option>
                        @php
                            $messageableUsers = auth()->user()->getMessageableUsers();
                        @endphp
                        @foreach($messageableUsers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Message -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message:</label>
                    <textarea id="messageContent" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none" placeholder="Type your message..." required></textarea>
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Attachment (optional):</label>
                    <input type="file" id="fileInput" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <!-- Selected File -->
                <div id="selectedFile" class="hidden flex items-center space-x-2 p-2 bg-gray-50 rounded">
                    <i class="bi bi-file-earmark text-gray-500"></i>
                    <span id="fileName" class="text-sm text-gray-700"></span>
                    <button type="button" onclick="removeFile()" class="text-red-500 hover:text-red-700">
                        <i class="bi bi-x"></i>
                    </button>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeComposeModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button type="submit" id="sendButton" class="bg-purple-600 text-white px-4 py-2 rounded-lg shadow hover:bg-purple-700 transition">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Modal functions
function openComposeModal() {
    document.getElementById('composeModal').classList.remove('hidden');
}

function closeComposeModal() {
    document.getElementById('composeModal').classList.add('hidden');
    resetForm();
}

function resetForm() {
    document.getElementById('recipientId').value = '';
    document.getElementById('messageContent').value = '';
    document.getElementById('fileInput').value = '';
    document.getElementById('selectedFile').classList.add('hidden');
}

function removeFile() {
    document.getElementById('fileInput').value = '';
    document.getElementById('selectedFile').classList.add('hidden');
}

// File input change handler
document.getElementById('fileInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('selectedFile').classList.remove('hidden');
    }
});

// Form submission
document.getElementById('messageForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const recipientId = document.getElementById('recipientId').value;
    const content = document.getElementById('messageContent').value;
    const fileInput = document.getElementById('fileInput');
    const sendButton = document.getElementById('sendButton');
    
    if (!recipientId || !content.trim()) {
        alert('Please fill in all required fields.');
        return;
    }
    
    // Disable button and show loading
    sendButton.disabled = true;
    sendButton.innerHTML = 'Sending...';
    
    const formData = new FormData();
    formData.append('recipient_id', recipientId);
    formData.append('content', content);
    if (fileInput.files[0]) {
        formData.append('file', fileInput.files[0]);
    }
    
    try {
        const response = await fetch('/messages', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            closeComposeModal();
            // Redirect to the conversation
            window.location.href = `/messages/${data.conversation.id}`;
        } else {
            alert(data.message || 'Failed to send message.');
        }
    } catch (error) {
        console.error('Error sending message:', error);
        alert('Failed to send message. Please try again.');
    } finally {
        // Re-enable button
        sendButton.disabled = false;
        sendButton.innerHTML = 'Send Message';
    }
});

// Close modal when clicking outside
document.getElementById('composeModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeComposeModal();
    }
});
</script>
@endsection