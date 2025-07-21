@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Mentorship Form: {{ $submission->form->title }}</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <form action="{{ route('mentorship.forms.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="mentorship_form_id" value="{{ $submission->mentorship_form_id }}">
            <input type="hidden" name="pairing_id" value="{{ $submission->pairing_id }}">

            @foreach($submission->form->fields->sortBy('order') as $field)
                <div class="mb-4">
                    <label for="{{ $field->id }}" class="block text-gray-700 text-sm font-bold mb-2">
                        {{ $field->label }} @if($field->required)<span class="text-red-500">*</span>@endif
                    </label>
                    @if($field->field_type === 'text' || $field->field_type === 'number' || $field->field_type === 'date')
                        <input type="{{ $field->field_type }}" name="form_data[{{ $field->id }}]" id="{{ $field->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('form_data.' . $field->id, $submission->form_data[$field->id] ?? '') }}" @if($field->required) required @endif>
                    @elseif($field->field_type === 'textarea')
                        <textarea name="form_data[{{ $field->id }}]" id="{{ $field->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="5" @if($field->required) required @endif>{{ old('form_data.' . $field->id, $submission->form_data[$field->id] ?? '') }}</textarea>
                    @elseif($field->field_type === 'select')
                        <select name="form_data[{{ $field->id }}]" id="{{ $field->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" @if($field->required) required @endif>
                            <option value="">Select an option</option>
                            @foreach($field->options as $option)
                                <option value="{{ $option }}" {{ (old('form_data.' . $field->id, $submission->form_data[$field->id] ?? '') == $option) ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    @elseif($field->field_type === 'radio')
                        @foreach($field->options as $option)
                            <div class="flex items-center mb-2">
                                <input type="radio" name="form_data[{{ $field->id }}]" id="{{ $field->id }}_{{ Str::slug($option) }}" value="{{ $option }}" class="mr-2" {{ (old('form_data.' . $field->id, $submission->form_data[$field->id] ?? '') == $option) ? 'checked' : '' }} @if($field->required) required @endif>
                                <label for="{{ $field->id }}_{{ Str::slug($option) }}">{{ $option }}</label>
                            </div>
                        @endforeach
                    @elseif($field->field_type === 'checkbox')
                        @foreach($field->options as $option)
                            <div class="flex items-center mb-2">
                                <input type="checkbox" name="form_data[{{ $field->id }}][]" id="{{ $field->id }}_{{ Str::slug($option) }}" value="{{ $option }}" class="mr-2" {{ in_array($option, old('form_data.' . $field->id, $submission->form_data[$field->id] ?? [])) ? 'checked' : '' }}>
                                <label for="{{ $field->id }}_{{ Str::slug($option) }}">{{ $option }}</label>
                            </div>
                        @endforeach
                    @elseif($field->field_type === 'file')
                        <input type="file" name="form_data[{{ $field->id }}][]" id="{{ $field->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" @if($field->required) required @endif multiple>
                        @if(!empty($submission->form_data[$field->id]))
                            <p class="text-sm text-gray-600 mt-2">Current files:</p>
                            @foreach($submission->form_data[$field->id] as $fileUrl)
                                <a href="{{ Storage::url($fileUrl) }}" target="_blank" class="text-blue-600 hover:underline block">{{ basename($fileUrl) }}</a>
                            @endforeach
                        @endif
                    @endif
                    @error('form_data.' . $field->id)
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            @if($submission->form->requires_signature)
                <div class="mb-4">
                    <label for="is_signed" class="block text-gray-700 text-sm font-bold mb-2">
                        <input type="checkbox" name="is_signed" id="is_signed" value="1" class="mr-2" {{ old('is_signed', $submission->is_signed) ? 'checked' : '' }}>
                        I confirm the accuracy of the information provided and sign this form.
                    </label>
                    @error('is_signed')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div class="flex items-center justify-between">
                <button type="submit" name="action" value="save_draft" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Save Draft
                </button>
                <button type="submit" name="action" value="submit_final" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Submit Final
                </button>
            </div>
        </form>
    </div>
</div>
@endsection