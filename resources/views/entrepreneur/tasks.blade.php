@extends('layouts.entrepreneur')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">My Assignments & Tasks</h1>
    @include('dashboard.entrepreneur-tasks', ['tasks' => $tasks])
</div>
@endsection 