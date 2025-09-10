@extends('layouts.entrepreneur')
@section('title', 'Task')
@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-4">Task: {{ ucfirst(str_replace('-', ' ', $task)) }}</h1>
    <p>This is a placeholder for the {{ $task }} task page.</p>
</div>
@endsection