@extends('layouts.entrepreneur')
@section('title', 'Module')
@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-4">Module: {{ ucfirst(str_replace('-', ' ', $module)) }}</h1>
    <p>This is a placeholder for the {{ $module }} module page.</p>
</div>
@endsection 