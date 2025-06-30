@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>Welcome, Investor!</h2>
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
</div>
@endsection 