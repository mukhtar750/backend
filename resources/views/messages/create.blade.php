@php
    $layout = match (auth()->user()->role) {
        'entrepreneur' => 'layouts.entrepreneur',
        'bdsp' => 'layouts.bdsp',
        'mentor' => 'layouts.mentor',
        'mentee' => 'layouts.mentee',
        'investor' => 'layouts.investor',
        'admin' => 'admin.layouts.admin',
        default => 'layouts.app',
    };
@endphp
@extends($layout)

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">New Message</h1>
    <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="recipient_id" class="block text-gray-700 font-bold mb-2">To:</label>
            <select name="recipient_id" id="recipient_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Select recipient...</option>
                @foreach($messageableUsers as $user)
                    <option value="{{ $user->id }}" {{ (isset($recipient) && $recipient && $recipient->id == $user->id) ? 'selected' : '' }}>
                        {{ $user->name }} ({{ ucfirst($user->role) }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-bold mb-2">Message:</label>
            <textarea name="content" id="content" rows="4" class="w-full border rounded px-3 py-2" required></textarea>
        </div>
        <div class="mb-4">
            <label for="file" class="block text-gray-700 font-bold mb-2">Attachment (optional):</label>
            <input type="file" name="file" id="file" class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700">Send</button>
    </form>
</div>
@endsection