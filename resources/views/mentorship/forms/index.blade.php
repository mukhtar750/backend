@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mentorship Forms</h1>
        <a href="{{ route('mentorship.forms.dashboard') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Dashboard</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Select a Mentorship Pairing</h2>
        
        @if($pairings->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
                <p>You don't have any active mentorship pairings.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($pairings as $pairing)
                    @php
                        $otherUser = ($pairing->user_one_id === auth()->id()) ? $pairing->userTwo : $pairing->userOne;
                    @endphp
                    <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                        <h3 class="font-medium text-lg">{{ $otherUser->name }}</h3>
                        <p class="text-gray-600 mb-2">{{ ucfirst(str_replace('_', ' ', $pairing->pairing_type)) }}</p>
                        <button 
                            class="w-full bg-indigo-100 text-indigo-700 px-4 py-2 rounded-md hover:bg-indigo-200 transition-colors"
                            onclick="toggleForms('pairing-{{ $pairing->id }}')">
                            View Forms
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if(!$pairings->isEmpty())
        @foreach($pairings as $pairing)
            @php
                $otherUser = ($pairing->user_one_id === auth()->id()) ? $pairing->userTwo : $pairing->userOne;
            @endphp
            <div id="pairing-{{ $pairing->id }}" class="hidden bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Forms for Mentorship with {{ $otherUser->name }}</h2>
                    <button class="text-gray-500 hover:text-gray-700" onclick="toggleForms('pairing-{{ $pairing->id }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mb-6">
                    <div class="flex space-x-4 border-b">
                        <button class="px-4 py-2 border-b-2 border-blue-500 text-blue-500 font-medium" onclick="showPhase('first-meeting-{{ $pairing->id }}', this)">First Meeting</button>
                        <button class="px-4 py-2 text-gray-500" onclick="showPhase('ongoing-meetings-{{ $pairing->id }}', this)">Ongoing Meetings</button>
                        <button class="px-4 py-2 text-gray-500" onclick="showPhase('feedback-resources-{{ $pairing->id }}', this)">Feedback & Resources</button>
                    </div>
                </div>

                <div id="first-meeting-{{ $pairing->id }}" class="phase-content">
                    <h3 class="text-lg font-medium mb-4">First Meeting Forms</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($formsByPhase['first_meeting'] ?? [] as $form)
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <h4 class="font-medium">{{ $form->title }}</h4>
                                <p class="text-sm text-gray-600 mb-3">{{ $form->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs px-2 py-1 rounded-full {{ $form->completion_by === 'mentor' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                        For: {{ ucfirst($form->completion_by) }}
                                    </span>
                                    <a href="{{ route('mentorship.forms.create', [$form->id, $pairing->id]) }}" class="text-blue-500 hover:text-blue-700">
                                        Start Form →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div id="ongoing-meetings-{{ $pairing->id }}" class="phase-content hidden">
                    <h3 class="text-lg font-medium mb-4">Ongoing Meeting Forms</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($formsByPhase['ongoing_meetings'] ?? [] as $form)
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <h4 class="font-medium">{{ $form->title }}</h4>
                                <p class="text-sm text-gray-600 mb-3">{{ $form->description }}</p>
                                <a href="{{ route('mentorship.forms.create', [$form->id, $pairing->id]) }}" class="text-blue-500 hover:text-blue-700">
                                    Start Form →
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div id="feedback-resources-{{ $pairing->id }}" class="phase-content hidden">
                    <h3 class="text-lg font-medium mb-4">Feedback & Resources Forms</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($formsByPhase['feedback_resources'] ?? [] as $form)
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <h4 class="font-medium">{{ $form->title }}</h4>
                                <p class="text-sm text-gray-600 mb-3">{{ $form->description }}</p>
                                <a href="{{ route('mentorship.forms.create', [$form->id, $pairing->id]) }}" class="text-blue-500 hover:text-blue-700">
                                    Start Form →
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<script>
    function toggleForms(id) {
        const element = document.getElementById(id);
        if (element.classList.contains('hidden')) {
            document.querySelectorAll('[id^="pairing-"]').forEach(el => {
                el.classList.add('hidden');
            });
            element.classList.remove('hidden');
        } else {
            element.classList.add('hidden');
        }
    }

    function showPhase(id, button) {
        const pairingId = id.split('-').pop();
        document.querySelectorAll(`[id$="-${pairingId}"].phase-content`).forEach(el => {
            el.classList.add('hidden');
        });
        document.getElementById(id).classList.remove('hidden');
        
        button.parentElement.querySelectorAll('button').forEach(btn => {
            btn.classList.remove('border-b-2', 'border-blue-500', 'text-blue-500', 'font-medium');
            btn.classList.add('text-gray-500');
        });
        
        button.classList.remove('text-gray-500');
        button.classList.add('border-b-2', 'border-blue-500', 'text-blue-500', 'font-medium');
    }
</script>
@endsection