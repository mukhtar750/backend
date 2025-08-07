@extends('admin.layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-900">Edit User</h2>
    <form method="POST" action="{{ route('admin.updateUser', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input w-full rounded-lg border-gray-300" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input w-full rounded-lg border-gray-300" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone ?? $user->entrepreneur_phone ?? '') }}" class="form-input w-full rounded-lg border-gray-300">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Role</label>
            <select name="role" class="form-select w-full rounded-lg border-gray-300" required>
                @foreach($roles as $role)
                    <option value="{{ $role }}" @if(old('role', $user->role) == $role) selected @endif>@displayRole($role)</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Status</label>
            <select name="is_approved" class="form-select w-full rounded-lg border-gray-300" required>
                <option value="1" @if(old('is_approved', $user->is_approved)) selected @endif>Approved</option>
                <option value="0" @if(!old('is_approved', $user->is_approved)) selected @endif>Pending</option>
            </select>
        </div>
        {{-- Role-specific fields --}}
        @if($user->role === 'entrepreneur')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Business Name</label>
                <input type="text" name="business_name" value="{{ old('business_name', $user->business_name) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Sector</label>
                <input type="text" name="sector" value="{{ old('sector', $user->sector) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">CAC Number</label>
                <input type="text" name="cac_number" value="{{ old('cac_number', $user->cac_number) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Funding Stage</label>
                <input type="text" name="funding_stage" value="{{ old('funding_stage', $user->funding_stage) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Website</label>
                <input type="text" name="website" value="{{ old('website', $user->website) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">LinkedIn</label>
                <input type="text" name="entrepreneur_linkedin" value="{{ old('entrepreneur_linkedin', $user->entrepreneur_linkedin) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
        @elseif($user->role === 'bdsp')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Services Provided</label>
                <input type="text" name="services_provided" value="{{ old('services_provided', $user->services_provided) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Years of Experience</label>
                <input type="text" name="years_of_experience" value="{{ old('years_of_experience', $user->years_of_experience) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Organization</label>
                <input type="text" name="organization" value="{{ old('organization', $user->organization) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Certifications</label>
                <input type="text" name="certifications" value="{{ old('certifications', $user->certifications) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">LinkedIn</label>
                <input type="text" name="bdsp_linkedin" value="{{ old('bdsp_linkedin', $user->bdsp_linkedin) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
        @elseif($user->role === 'investor')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Company</label>
                <input type="text" name="company" value="{{ old('company', $user->company) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Type of Investor</label>
                <input type="text" name="type_of_investor" value="{{ old('type_of_investor', $user->type_of_investor) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Interest Areas</label>
                <input type="text" name="interest_areas" value="{{ old('interest_areas', $user->interest_areas) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">LinkedIn</label>
                <input type="text" name="investor_linkedin" value="{{ old('investor_linkedin', $user->investor_linkedin) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
        @endif
        <div class="flex justify-end gap-4 mt-8">
            <a href="{{ route('admin.user-management') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-300 transition">Cancel</a>
            <button type="submit" class="bg-[#b81d8f] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Save Changes</button>
        </div>
    </form>
</div>
@endsection 