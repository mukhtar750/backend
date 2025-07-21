@extends('layouts.entrepreneur')
@section('title', 'Download Resource')
@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-4">Download: {{ ucfirst(str_replace('-', ' ', $resource)) }}</h1>
    <p>This is a placeholder for the resource download page.</p>
</div>
@endsection 