@extends('layouts.guest')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Entrepreneur Registration</h2>
    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register.entrepreneur') }}" class="mx-auto" style="max-width: 500px;">
        @csrf
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <input type="text" name="business_name" class="form-control" placeholder="Business Name" value="{{ old('business_name') }}" required>
        </div>
        <div class="mb-3">
            <input type="text" name="sector" class="form-control" placeholder="Sector" value="{{ old('sector') }}" required>
        </div>
        <div class="mb-3">
            <input type="text" name="cac_number" class="form-control" placeholder="CAC Number" value="{{ old('cac_number') }}" required>
        </div>
        <div class="mb-3">
            <input type="text" name="funding_stage" class="form-control" placeholder="Funding Stage (e.g. Idea, Seed, Series A)" value="{{ old('funding_stage') }}" required>
        </div>
        <div class="mb-3">
            <input type="url" name="website" class="form-control" placeholder="Business Website (optional)" value="{{ old('website') }}">
        </div>
        <div class="mb-3">
            <input type="text" name="entrepreneur_phone" class="form-control" placeholder="Phone Number" value="{{ old('entrepreneur_phone') }}" required>
        </div>
        <div class="mb-3">
            <input type="url" name="entrepreneur_linkedin" class="form-control" placeholder="LinkedIn Profile (optional)" value="{{ old('entrepreneur_linkedin') }}">
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Register</button>
    </form>
</div>
@endsection 