@extends('layouts.mentor')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">{{ $form->title }}</h1>
    <p class="mb-4 text-gray-600">{{ $form->description }}</p>
    <form action="{{ route('mentorship.forms.store', ['form' => $form->id, 'pairing' => $pairing->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @foreach($form->fields->sortBy('order') as $field)
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="field_{{ $field->id }}">
                    {{ $field->label }}@if($field->required)<span class="text-red-500">*</span>@endif
                </label>
                @if($field->field_type === 'text')
                    <input type="text" name="{{ $field->label }}" id="field_{{ $field->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old($field->label) }}" @if($field->required) required @endif>
                @elseif($field->field_type === 'textarea')
                    <textarea name="{{ $field->label }}" id="field_{{ $field->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="4" @if($field->required) required @endif>{{ old($field->label) }}</textarea>
                @elseif($field->field_type === 'date')
                    <input type="date" name="{{ $field->label }}" id="field_{{ $field->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old($field->label) }}" @if($field->required) required @endif>
                @elseif($field->field_type === 'checkbox')
                    <input type="checkbox" name="{{ $field->label }}" id="field_{{ $field->id }}" value="1" class="mr-2" @if(old($field->label)) checked @endif @if($field->required) required @endif>
                @elseif($field->field_type === 'select' && isset($field->options))
                    <select name="{{ $field->label }}" id="field_{{ $field->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" @if($field->required) required @endif>
                        <option value="">Select...</option>
                        @foreach($field->options as $option)
                            <option value="{{ $option }}" @if(old($field->label) == $option) selected @endif>{{ $option }}</option>
                        @endforeach
                    </select>
                @elseif($field->field_type === 'file')
                    <input type="file" name="{{ $field->label }}" id="field_{{ $field->id }}" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none" @if($field->required) required @endif>
                @endif
                @if($field->description)
                    <p class="text-xs text-gray-500 mt-1">{{ $field->description }}</p>
                @endif
                @error($field->label)
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endforeach
        <div class="flex items-center justify-between mt-8">
            <button type="submit" name="action" value="submit_final" class="bg-indigo-700 hover:bg-indigo-800 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                Submit
            </button>
            <button type="submit" name="action" value="draft" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                Save as Draft
            </button>
        </div>
    </form>
</div>
@endsection
