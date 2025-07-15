@extends('admin.layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8 mt-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Create Training Session</h2>
    @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.training_programs.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Date & Time</label>
            <input type="datetime-local" name="date_time" value="{{ old('date_time') }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Duration (minutes)</label>
            <input type="number" name="duration" value="{{ old('duration') }}" min="1" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Trainer</label>
            <input type="text" name="trainer" value="{{ old('trainer') }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Target Roles</label>
            <select name="target_roles[]" multiple class="w-full border-gray-300 rounded-md shadow-sm" required>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ (collect(old('target_roles'))->contains($role)) ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
            <small class="text-gray-500">Hold Ctrl (Windows) or Cmd (Mac) to select multiple roles.</small>
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create</button>
            <a href="{{ route('admin.training_programs') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection 