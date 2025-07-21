@extends('layouts.bdsp')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8" x-data="composeModal()" x-init="init()">
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
            <!-- Conversations List -->
            <div class="w-1/3 border-r border-gray-200">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Conversations</h2>
                    <div class="space-y-2">
                        @forelse($conversations as $conversation)
                            @php
                                $otherUser = $conversation->getOtherUser(auth()->id());
                                $unreadCount = $conversation->getUnreadCount(auth()->id());
                                $latestMessage = $conversation->latestMessage;
                            @endphp
                            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition"
                                 onclick="window.location.href='{{ route('bdsp.messages.show', $conversation->id) }}'">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="bi bi-person text-purple-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $otherUser->name }}</h3>
                                        @if($unreadCount > 0)
                                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $unreadCount }}</span>
                                        @endif
                                    </div>
                                    @if($latestMessage)
                                        <p class="text-sm text-gray-500 truncate">{{ $latestMessage->content }}</p>
                                        <p class="text-xs text-gray-400">{{ $latestMessage->created_at->diffForHumans() }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="bi bi-chat text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No conversations</h3>
                                <p class="text-gray-500">Start a conversation to begin messaging.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="bi bi-chat-dots text-4xl text-purple-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome to Messages</h2>
                    <p class="text-gray-600 mb-6">Select a conversation from the list or start a new one.</p>
                    <button @click="openModal()" class="bg-purple-600 text-white px-6 py-3 rounded-lg shadow hover:bg-purple-700 transition">
                        Start New Conversation
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Compose Message Modal -->
<div x-show="isOpen" 
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
        init() {
            window.addEventListener('open-message-modal', (event) => {
                this.openModal(event.detail.recipientId, event.detail.recipientName);
            });
        },
        openModal(recipientId = '', recipientName = '') {
            if (recipientId) {
                this.recipientId = recipientId;
            }
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
                const response = await fetch('{{ route('bdsp.messages.store') }}', {
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
                    window.location.href = `/bdsp/messages/${data.conversation.id}`;
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
</script>
@endsection 