@extends('layouts.investor')
@section('title', 'Messages')
@section('content')
<div class="mb-6 flex items-center gap-2">
    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2"><i class="bi bi-chat-left-text text-[#b81d8f]"></i> Messages</h2>
</div>
<div x-data="{
    conversation: {
        id: 1,
        name: 'Admin',
        last: 'Welcome to the investor portal! How can we assist you?',
        unread: 0,
        messages: [
            {from: 'admin', text: 'Welcome to the investor portal! How can we assist you?', time: '09:00'},
            {from: 'me', text: 'Thank you!', time: '09:01'},
        ]
    },
    newMessage: '',
    sendMessage() {
        if (this.newMessage.trim() !== '') {
            this.conversation.messages.unshift({from: 'me', text: this.newMessage, time: 'Now'});
            this.newMessage = '';
        }
    }
}" class="flex justify-center items-start min-h-[600px]">
    <!-- Chat Card -->
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl flex overflow-hidden border border-gray-100">
        <!-- Sidebar -->
        <aside class="w-72 bg-gradient-to-b from-[#b81d8f] to-[#fbeff7] flex flex-col">
            <div class="p-6 border-b border-[#f3d1ea] flex items-center gap-3">
                <div class="h-12 w-12 rounded-full bg-white flex items-center justify-center text-[#b81d8f] font-bold text-xl border-2 border-[#b81d8f] shadow"><i class="bi bi-person-fill"></i></div>
                <div>
                    <div class="font-semibold text-white text-lg" x-text="conversation.name"></div>
                    <div class="text-xs text-pink-100" x-text="conversation.last"></div>
                </div>
            </div>
            <div class="flex-1 flex flex-col items-center justify-center px-6 py-8">
                <div class="text-center text-white/80 text-sm">You can chat directly with the admin for support, questions, or feedback. Replies may take a few minutes.</div>
            </div>
        </aside>
        <!-- Main Chat Panel -->
        <section class="flex-1 flex flex-col bg-gray-50">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#b81d8f] to-[#fbeff7] px-8 py-4 flex items-center gap-3 border-b border-[#f3d1ea]">
                <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center text-[#b81d8f] font-bold text-lg border-2 border-[#b81d8f]"><i class="bi bi-person-fill"></i></div>
                <div>
                    <div class="font-semibold text-[#b81d8f] text-base" x-text="conversation.name"></div>
                    <div class="text-xs text-gray-500" x-text="conversation.last"></div>
                </div>
            </div>
            <!-- Messages -->
            <div class="flex-1 overflow-y-auto px-8 py-6 flex flex-col-reverse gap-4 bg-gray-50">
                <template x-if="conversation.messages.length === 0">
                    <div class="flex flex-col items-center justify-center h-full py-16">
                        <i class="bi bi-chat-dots text-5xl text-gray-300 mb-4"></i>
                        <div class="text-lg text-gray-500 mb-2">No messages yet.</div>
                        <div class="text-sm text-gray-400">Start the conversation below.</div>
                    </div>
                </template>
                <template x-for="m in conversation.messages" :key="m.text + m.time">
                    <div class="flex" :class="{'justify-end': m.from === 'me', 'justify-start': m.from === 'admin'}">
                        <div class="max-w-xs px-5 py-3 rounded-2xl shadow text-sm relative"
                             :class="m.from === 'me' ? 'bg-[#b81d8f] text-white rounded-br-none' : 'bg-white text-gray-800 rounded-bl-none border border-gray-200'">
                            <div x-text="m.text"></div>
                            <div class="text-xs text-right mt-1 opacity-60" x-text="m.time"></div>
                        </div>
                    </div>
                </template>
            </div>
            <!-- Input -->
            <div class="p-6 border-t border-[#f3d1ea] bg-white flex gap-3 items-center">
                <input type="text" class="flex-1 border border-gray-300 rounded-full py-3 px-6 focus:outline-none focus:ring-2 focus:ring-[#b81d8f] text-sm" placeholder="Type your message to Admin..." x-model="newMessage" @keydown.enter="sendMessage">
                <button class="px-6 py-3 rounded-full bg-[#b81d8f] text-white font-semibold hover:bg-[#a01a7d] transition flex items-center gap-2 shadow" @click="sendMessage"><i class="bi bi-send"></i> Send</button>
            </div>
        </section>
    </div>
</div>
@endsection 