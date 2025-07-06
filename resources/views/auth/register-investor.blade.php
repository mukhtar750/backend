@extends('layouts.guest')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Investor Registration</h2>
    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register.investor') }}" class="mx-auto" style="max-width: 500px;">
        @csrf
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{ old('phone') }}" required>
        </div>
        <div class="mb-3">
            <input type="text" name="type_of_investor" class="form-control" placeholder="Type of Investor (e.g. Angel, VC, Corporate)" value="{{ old('type_of_investor') }}" required>
        </div>
        <div class="mb-3">
            <input type="text" name="interest_areas" class="form-control" placeholder="Interest Areas (comma separated)" value="{{ old('interest_areas') }}" required>
        </div>
        <div class="mb-3">
            <input type="text" name="company" class="form-control" placeholder="Company (optional)" value="{{ old('company') }}">
        </div>
        <div class="mb-3">
            <input type="url" name="investor_linkedin" class="form-control" placeholder="LinkedIn Profile (optional)" value="{{ old('investor_linkedin') }}">
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
</div>
@endsection 