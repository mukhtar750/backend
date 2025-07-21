@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Mentorship Form Submission Details</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4">{{ $submission->form->title }}</h2>
        <p class="text-gray-600 mb-4">{{ $submission->form->description }}</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <p class="font-semibold">Submitted By:</p>
                <p>{{ $submission->submittedBy->name }}</p>
            </div>
            <div>
                <p class="font-semibold">Pairing:</p>
                <p>{{ $submission->pairing->mentor->name }} & {{ $submission->pairing->mentee->name }}</p>
            </div>
            <div>
                <p class="font-semibold">Status:</p>
                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $submission->is_draft ? 'bg-gray-200 text-gray-800' : ($submission->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') }}">
                    {{ $submission->is_draft ? 'Draft' : ucfirst($submission->status) }}
                </p>
            </div>
            <div>
                <p class="font-semibold">Submitted At:</p>
                <p>{{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y H:i') : 'N/A' }}</p>
            </div>
            @if($submission->is_signed)
            <div>
                <p class="font-semibold">Signed At:</p>
                <p>{{ $submission->signed_at ? $submission->signed_at->format('M d, Y H:i') : 'N/A' }}</p>
            </div>
            @endif
        </div>

        <h3 class="text-xl font-semibold mb-3">Form Data</h3>
        @foreach($submission->form_data as $fieldId => $value)
            @php
                $field = $submission->form->fields->firstWhere('id', $fieldId);
            @endphp
            @if($field)
                <div class="mb-4">
                    <p class="font-semibold">{{ $field->label }}:</p>
                    @if(is_array($value))
                        @if($field->field_type === 'file')
                            @foreach($value as $fileUrl)
                                <a href="{{ Storage::url($fileUrl) }}" target="_blank" class="text-blue-600 hover:underline block">{{ basename($fileUrl) }}</a>
                            @endforeach
                        @else
                            <p>{{ implode(', ', $value) }}</p>
                        @endif
                    @else
                        <p>{{ $value }}</p>
                    @endif
                </div>
            @endif
        @endforeach
    </div>

    @if($submission->reviews->isNotEmpty())
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold mb-3">Reviews</h3>
            @foreach($submission->reviews as $review)
                <div class="border-b pb-4 mb-4 last:border-b-0 last:pb-0">
                    <p class="font-semibold">Reviewed By: {{ $review->reviewedBy->name }}</p>
                    <p class="text-gray-600">Comments: {{ $review->comments }}</p>
                    <p class="text-gray-600">Status: <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $review->is_approved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $review->is_approved ? 'Approved' : 'Rejected' }}</span></p>
                    <p class="text-gray-600 text-sm">Reviewed At: {{ $review->created_at->format('M d, Y H:i') }}</p>
                </div>
            @endforeach
        </div>
    @endif

    <div class="flex justify-end">
        <a href="{{ route('mentorship.forms.dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Back to Dashboard</a>
        @if($submission->isEditable())
            <a href="{{ route('mentorship.forms.edit', $submission->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Edit Submission</a>
        @endif
        @if($submission->status == 'pending' && auth()->user()->can('review', $submission))
            <a href="{{ route('mentorship.forms.review', $submission->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Review Submission</a>
        @endif
    </div>
</div>
@endsection