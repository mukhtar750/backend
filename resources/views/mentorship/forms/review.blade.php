@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Review Mentorship Form: {{ $submission->form->title }}</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4">Submission Details</h2>
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

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Submit Review</h2>
        <form action="{{ route('mentorship.forms.review.store', $submission->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="comments" class="block text-gray-700 text-sm font-bold mb-2">Comments:</label>
                <textarea name="comments" id="comments" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="5">{{ old('comments') }}</textarea>
                @error('comments')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Decision:</label>
                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="is_approved" value="1" class="form-radio" {{ old('is_approved') === '1' ? 'checked' : '' }}>
                        <span class="ml-2">Approve</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" name="is_approved" value="0" class="form-radio" {{ old('is_approved') === '0' ? 'checked' : '' }}>
                        <span class="ml-2">Reject</span>
                    </label>
                </div>
                @error('is_approved')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Submit Review
                </button>
                <a href="{{ route('mentorship.forms.dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection