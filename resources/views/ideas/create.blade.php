@extends('layouts.entrepreneur')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Submit a New Idea</h1>
    <form action="{{ route('ideas.store') }}" method="POST" class="bg-white rounded-xl shadow p-6" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Idea Title *</label>
            <input type="text" name="title" class="form-input w-full rounded-md" value="{{ old('title') }}" required>
            @error('title')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Problem Statement *</label>
            <textarea name="problem_statement" class="form-input w-full rounded-md" rows="4" required placeholder="Describe the problem or challenge you're addressing...">{{ old('problem_statement') }}</textarea>
            @error('problem_statement')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Proposed Solution (Optional)</label>
            <textarea name="proposed_solution" class="form-input w-full rounded-md" rows="4" placeholder="Describe your proposed solution or approach...">{{ old('proposed_solution') }}</textarea>
            @error('proposed_solution')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Sector/Theme</label>
                <select name="sector" class="form-select w-full rounded-md">
                    <option value="">Select Sector</option>
                    <option value="Technology" {{ old('sector') == 'Technology' ? 'selected' : '' }}>Technology</option>
                    <option value="Healthcare" {{ old('sector') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                    <option value="Education" {{ old('sector') == 'Education' ? 'selected' : '' }}>Education</option>
                    <option value="Finance" {{ old('sector') == 'Finance' ? 'selected' : '' }}>Finance</option>
                    <option value="Agriculture" {{ old('sector') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                    <option value="Environment" {{ old('sector') == 'Environment' ? 'selected' : '' }}>Environment</option>
                    <option value="Transportation" {{ old('sector') == 'Transportation' ? 'selected' : '' }}>Transportation</option>
                    <option value="Energy" {{ old('sector') == 'Energy' ? 'selected' : '' }}>Energy</option>
                    <option value="Other" {{ old('sector') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('sector')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Urgency Level</label>
                <select name="urgency_level" class="form-select w-full rounded-md">
                    <option value="low" {{ old('urgency_level') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('urgency_level') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('urgency_level') == 'high' ? 'selected' : '' }}>High</option>
                </select>
                @error('urgency_level')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Target Beneficiaries</label>
            <textarea name="target_beneficiaries" class="form-input w-full rounded-md" rows="3" placeholder="Who will benefit from this idea?">{{ old('target_beneficiaries') }}</textarea>
            @error('target_beneficiaries')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Related SDGs (Optional)</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @php
                    $sdgs = [
                        1 => 'No Poverty', 2 => 'Zero Hunger', 3 => 'Good Health', 
                        4 => 'Quality Education', 5 => 'Gender Equality', 6 => 'Clean Water',
                        7 => 'Affordable Energy', 8 => 'Decent Work', 9 => 'Industry Innovation',
                        10 => 'Reduced Inequalities', 11 => 'Sustainable Cities', 12 => 'Responsible Consumption',
                        13 => 'Climate Action', 14 => 'Life Below Water', 15 => 'Life on Land',
                        16 => 'Peace & Justice', 17 => 'Partnerships'
                    ];
                @endphp
                @foreach($sdgs as $number => $title)
                    <label class="flex items-center">
                        <input type="checkbox" name="related_sdgs[]" value="{{ $number }}" class="mr-2" {{ in_array($number, old('related_sdgs', [])) ? 'checked' : '' }}>
                        <span class="text-xs">SDG {{ $number }}: {{ $title }}</span>
                    </label>
                @endforeach
            </div>
            @error('related_sdgs')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Tags (Optional)</label>
            <input type="text" name="tags" class="form-input w-full rounded-md" value="{{ old('tags') }}" placeholder="Enter tags separated by commas (e.g., innovation, sustainability, tech)">
            @error('tags')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('ideas.index') }}" class="px-4 py-2 rounded-lg font-semibold border border-gray-300 text-gray-700 hover:bg-gray-100">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded-lg font-semibold bg-purple-600 text-white hover:bg-purple-700">Submit Idea</button>
        </div>
    </form>
</div>
@endsection 