@extends('layouts.app')

@section('content')
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card shadow-lg w-100" style="max-width: 400px;">
        <div class="card-body text-center py-5">
            <h2 class="mb-4 fw-bold">Who are you?</h2>
            <div class="d-grid gap-3">
                <a href="{{ route('register.investor') }}" class="btn btn-primary btn-lg" role="button" aria-label="Register as Investor">
                    I am an Investor
                </a>
                <a href="{{ route('register.bdsp') }}" class="btn btn-warning btn-lg text-white" role="button" aria-label="Register as BDSP" style="background-color: #f59e42; border-color: #f59e42;">
                    I am a BDSP
                </a>
                <a href="{{ route('register.entrepreneur') }}" class="btn btn-success btn-lg" role="button" aria-label="Register as Entrepreneur">
                    I am an Entrepreneur
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 