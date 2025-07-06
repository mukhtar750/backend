@extends('layouts.guest')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">BDSP Registration</h2>
    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register.bdsp') }}" class="mx-auto" style="max-width: 500px;">
        @csrf
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <input type="text" name="services_provided" class="form-control" placeholder="Services Provided (comma separated)" value="{{ old('services_provided') }}" required>
        </div>
        <div class="mb-3">
            <input type="number" name="years_of_experience" class="form-control" placeholder="Years of Experience" value="{{ old('years_of_experience') }}" required min="0">
        </div>
        <div class="mb-3">
            <input type="text" name="organization" class="form-control" placeholder="Organization (optional)" value="{{ old('organization') }}">
        </div>
        <div class="mb-3">
            <input type="text" name="certifications" class="form-control" placeholder="Certifications (optional)" value="{{ old('certifications') }}">
        </div>
        <div class="mb-3">
            <input type="url" name="bdsp_linkedin" class="form-control" placeholder="LinkedIn Profile (optional)" value="{{ old('bdsp_linkedin') }}">
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn btn-secondary w-100">Register</button>
    </form>
</div>
@endsection 