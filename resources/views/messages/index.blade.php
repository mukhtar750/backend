@extends($layout ?? (auth()->user()->role === 'bdsp' ? 'layouts.bdsp' : (auth()->user()->role === 'admin' ? 'admin.layouts.admin' : 'layouts.app')))

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="bi bi-chat-dots-fill text-2xl text-purple-600"></i>
                    <h1 class="text-2xl font-bold text-gray-900">Messages</h1>
                </div>
                <button @click="openModal()" class="bg-purple-600 text-white px-4 py-2 rounded-lg shadow hover:bg-purple-700 transition flex items-center">
                    <i class="bi bi-plus-circle mr-2"></i> New Message
                </button>
            </div>
        </div>

        <div class="flex h-96">
            <!-- Sidebar -->
            <div class="w-1/3 border-r border-gray-200 overflow-y-auto">
                <!-- Search -->
                <div class="p-4 border-b border-gray-200">
                    <div class="relative">
                        <input type="text" placeholder="Search Messages" class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-purple-500 focus:outline-none pl-10">
                        <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <!-- AWN Hub -->
                <div class="p-4 border-b border-gray-200">
                    <div onclick="loadGroup('awn-hub')" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                        <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="bi bi-people-fill text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">AWN Hub</h3>
                            <p class="text-xs text-gray-500">Global community chat</p>
                        </div>
                </div>
                <!-- Private Messages -->
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Private Messages</h2>
                    <div class="space-y-2">
                        @forelse($possibleChats as $chat)
                            @php
                                $otherUser = $chat['user'];
                                $unreadCount = $chat['unreadCount'];
                                $latestMessage = $chat['latestMessage'];
                                $avatar = $otherUser->avatar ?? 'https://i.pravatar.cc/40?u=' . $otherUser->id;
                                if ($chat['type'] === 'conversation') {
                                    $onclick = "loadConversation(" . $chat['id'] . ")";
                                } else {
                                    $onclick = "loadNewChat(" . $chat['id'] . ", '" . addslashes($otherUser->name) . "', '" . ucfirst($otherUser->role) . "', '" . $avatar . "')";
                                }
                            @endphp
                            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition relative"
                                 onclick="{{ $onclick }}">
                                <div class="relative">
                                    <img src="{{ $avatar }}" class="h-10 w-10 rounded-full object-cover" alt="{{ $otherUser->name }}">
                                    @if($otherUser->is_online ?? false)
                                        <span class="absolute bottom-0 right-0 h-3 w-3 bg-green-400 border-2 border-white rounded-full"></span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900">{{ $otherUser->name }}</h3>
                                            <div class="text-xs text-gray-500">{{ ucfirst($otherUser->role) }}</div>
                                        </div>
                                        @if($unreadCount > 0)
                                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full animate-pulse">{{ $unreadCount }}</span>
                                        @endif
                                    </div>
                                    @if($latestMessage)
                                        <p class="text-sm text-gray-500 truncate">{{ $latestMessage->content }}</p>
                                        <p class="text-xs text-gray-400">{{ $latestMessage->created_at->diffForHumans() }}</p>
                                    @else
                                        <p class="text-sm text-gray-500 truncate">Start a new conversation</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="bi bi-chat text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No private chats</h3>
                                <p class="text-gray-500">Pair with users to start messaging.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                
            </div>

            
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col" id="chatContainer" style="display: none;">
                <!-- Chat Header -->
                <div class="px-6 py-4 border-b border-gray-200" id="chatHeader"></div>
                <!-- Messages List -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messagesList" style="background-color: #f8f5ff;"></div>
                <!-- Message Input -->
                <div class="border-t border-gray-200 p-4 bg-white" id="messageInputArea"></div>
            </div>
        </div>
    </div>
</div>

<!-- Compose Message Modal -->
<div x-data="composeModal()" x-show="isOpen" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-black bg-opacity-50 z-50"
     @click.away="closeModal()"
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">New Message</h3>
                <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- Form -->
            <form @submit.prevent="sendMessage()" class="space-y-4">
                <!-- Recipient -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">To:</label>
                    <select x-model="recipientId" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none" required>
                        <option value="">Select recipient...</option>
                        @foreach($messageableUsers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Message -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message:</label>
                    <textarea x-model="content" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none" placeholder="Type your message..." required></textarea>
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Attachment (optional):</label>
                    <input type="file" x-ref="fileInput" @change="handleFileSelect()" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <!-- Selected File -->
                <div x-show="selectedFile" class="flex items-center space-x-2 p-2 bg-gray-50 rounded">
                    <i class="bi bi-file-earmark text-gray-500"></i>
                    <template x-if="selectedFile">
                        <span x-text="selectedFile.name" class="text-sm text-gray-700"></span>
                    </template>
                    <button @click="removeFile()" type="button" class="text-red-500 hover:text-red-700">
                        <i class="bi bi-x"></i>
                    </button>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-4">
                    <button type="button" @click="closeModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button type="submit" :disabled="sending" class="bg-purple-600 text-white px-4 py-2 rounded-lg shadow hover:bg-purple-700 transition disabled:opacity-50">
                        <span x-show="!sending">Send Message</span>
                        <span x-show="sending">Sending...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function composeModal() {
    return {
        isOpen: false,
        recipientId: '',
        content: '',
        selectedFile: null,
        sending: false,

        openModal() {
            this.isOpen = true;
        },

        closeModal() {
            this.isOpen = false;
            this.resetForm();
        },

        handleFileSelect() {
            const file = this.$refs.fileInput.files[0];
            if (file) {
                this.selectedFile = file;
            }
        },

        removeFile() {
            this.selectedFile = null;
            this.$refs.fileInput.value = '';
        },

        resetForm() {
            this.recipientId = '';
            this.content = '';
            this.selectedFile = null;
            this.$refs.fileInput.value = '';
        },

        async sendMessage() {
            if (!this.recipientId || !this.content.trim()) {
                alert('Please fill in all required fields.');
                return;
            }

            this.sending = true;

            const formData = new FormData();
            formData.append('recipient_id', this.recipientId);
            formData.append('content', this.content);
            if (this.selectedFile) {
                formData.append('file', this.selectedFile);
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
                    this.closeModal();
                    // Redirect to the conversation
                    window.location.href = `/messages/${data.conversation.id}`;
                } else {
                    alert(data.message || 'Failed to send message.');
                }
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please try again.');
            } finally {
                this.sending = false;
            }
        }
    }
}
async function loadNewChat(userId, name, role, avatar) {
    document.getElementById('chatContainer').style.display = 'flex';
    const header = document.getElementById('chatHeader');
    header.innerHTML = `
        <div class="flex items-center space-x-3">
            <img src="${avatar}" class="h-10 w-10 rounded-full object-cover" alt="${name}">
            <div>
                <h1 class="text-xl font-bold text-gray-900">${name}</h1>
                <p class="text-sm text-gray-500">${role.charAt(0).toUpperCase() + role.slice(1)}</p>
            </div>
        </div>`;
    const messagesList = document.getElementById('messagesList');
    messagesList.innerHTML = '<div class="text-center py-8 text-gray-500">Start a new conversation</div>';
    const inputArea = document.getElementById('messageInputArea');
    inputArea.innerHTML = `
        <form id="messageForm" class="flex items-center space-x-3" onsubmit="sendFirstMessage(event, ${userId})">
            <div class="flex-1">
                <textarea id="messageInput" rows="1" class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-pink-500 focus:outline-none resize-none bg-gray-50" placeholder="Type a message..."></textarea>
            </div>
            <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-full shadow hover:bg-pink-600 transition">Send</button>
        </form>`;
}
async function sendFirstMessage(e, userId) {
    e.preventDefault();
    const input = document.getElementById('messageInput');
    const content = input.value.trim();
    if (!content) return;
    const formData = new FormData();
    formData.append('recipient_id', userId);
    formData.append('content', content);
    const response = await fetch('/messages', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
        body: formData
    });
    const data = await response.json();
    if (data.success) {
        loadConversation(data.conversation.id);
    } else {
        alert(data.message || 'Failed to send message.');
    }
    input.value = '';
}
</script>
<script>
async function loadConversation(conversationId) {
    document.getElementById('chatContainer').style.display = 'flex';
    const header = document.getElementById('chatHeader');
    const messagesList = document.getElementById('messagesList');
    const inputArea = document.getElementById('messageInputArea');
    // Fetch conversation details and messages
    const response = await fetch(`/messages/${conversationId}`, {
        headers: {
            'Accept': 'application/json',
        }
    });
    const data = await response.json();
    const otherUser = data.otherUser;
    header.innerHTML = `
        <div class="flex items-center space-x-3">
            <img src="${otherUser.avatar || 'https://i.pravatar.cc/40?u=' + otherUser.id}" class="h-10 w-10 rounded-full object-cover" alt="${otherUser.name}">
            <div>
                <h1 class="text-xl font-bold text-gray-900">${otherUser.name}</h1>
                <p class="text-sm text-gray-500">${otherUser.role.charAt(0).toUpperCase() + otherUser.role.slice(1)}</p>
            </div>
        </div>`;
    messagesList.innerHTML = '';
    data.messages.forEach(msg => {
        const isSender = msg.sender_id === {{ auth()->id() }};
        messagesList.innerHTML += `
            <div class="flex ${isSender ? 'justify-end' : 'justify-start'}">
                <div class="flex items-end gap-2 ${isSender ? 'flex-row-reverse' : ''}">
                    <img src="${msg.sender.avatar || 'https://i.pravatar.cc/32?u=' + msg.sender_id}" class="h-8 w-8 rounded-full object-cover" alt="${msg.sender.name}">
                    <div class="max-w-xs lg:max-w-md">
                        <div class="px-4 py-2 rounded-2xl ${isSender ? 'bg-pink-500 text-white' : 'bg-white text-gray-900 shadow'}">
                            ${msg.content}
                            <div class="text-xs opacity-75 mt-1">${msg.sender.name} • ${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})}</div>
                        </div>
                    </div>
                </div>
            </div>`;
    });
    messagesList.scrollTop = messagesList.scrollHeight;
    inputArea.innerHTML = `
        <form id="messageForm" class="flex items-center space-x-3" onsubmit="sendMessage(event, 'conversation', ${conversationId})">
            <div class="flex-1">
                <textarea id="messageInput" rows="1" class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-pink-500 focus:outline-none resize-none bg-gray-50" placeholder="Type a message..."></textarea>
            </div>
            <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-full shadow hover:bg-pink-600 transition">Send</button>
        </form>`;
}
async function loadGroup(slug) {
    document.getElementById('chatContainer').style.display = 'flex';
    const header = document.getElementById('chatHeader');
    const messagesList = document.getElementById('messagesList');
    const inputArea = document.getElementById('messageInputArea');
    // Fetch group details and messages
    const response = await fetch(`/groups/${slug}/messages`);
    const data = await response.json();
    header.innerHTML = `
        <div class="flex items-center space-x-3">
            <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                <i class="bi bi-people-fill text-purple-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">AWN Hub</h1>
                <p class="text-sm text-gray-500">Global community chat</p>
            </div>
        </div>`;
    messagesList.innerHTML = '';
    data.messages.forEach(msg => {
        const isSender = msg.sender_id === {{ auth()->id() }};
        messagesList.innerHTML += `
            <div class="flex ${isSender ? 'justify-end' : 'justify-start'}">
                <div class="flex items-end gap-2 ${isSender ? 'flex-row-reverse' : ''}">
                    <img src="${msg.sender.avatar || 'https://i.pravatar.cc/32?u=' + msg.sender_id}" class="h-8 w-8 rounded-full object-cover" alt="${msg.sender.name}">
                    <div class="max-w-xs lg:max-w-md">
                        <div class="px-4 py-2 rounded-2xl ${isSender ? 'bg-pink-500 text-white' : 'bg-white text-gray-900 shadow'}">
                            ${msg.content}
                            <div class="text-xs opacity-75 mt-1">${msg.sender.name} • ${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})}</div>
                        </div>
                    </div>
                </div>
            </div>`;
    });
    messagesList.scrollTop = messagesList.scrollHeight;
    inputArea.innerHTML = `
        <form id="messageForm" class="flex items-center space-x-3" onsubmit="sendMessage(event, 'group', '${slug}')">
            <div class="flex-1">
                <textarea id="messageInput" rows="1" class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-pink-500 focus:outline-none resize-none bg-gray-50" placeholder="Type a message..."></textarea>
            </div>
            <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-full shadow hover:bg-pink-600 transition">Send</button>
        </form>`;
}
async function sendMessage(e, type, id) {
    e.preventDefault();
    const input = document.getElementById('messageInput');
    const content = input.value.trim();
    if (!content) return;
    const formData = new FormData();
    formData.append('content', content);
    const url = type === 'conversation' ? `/messages/${id}` : `/groups/${id}/messages`;
    await fetch(url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
        body: formData
    });
    input.value = '';
    // Reload the chat to show new message
    if (type === 'conversation') loadConversation(id);
    else loadGroup(id);
}
</script>
@endsection