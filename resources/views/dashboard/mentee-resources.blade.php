@extends('layouts.mentee')

@section('title', 'Mentee Resources')

@section('content')
<div class="max-w-5xl mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-4">Learning Resources</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($learningResources as $resource)
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="flex items-center gap-2 mb-2">
                    <i class="bi bi-file-earmark-text text-[#b81d8f] text-xl"></i>
                    <span class="font-semibold">{{ $resource->name }}</span>
                </div>
                <div class="text-sm text-gray-500 mb-2">{{ $resource->description }}</div>
                <div class="text-xs text-gray-400 mb-1">Uploaded by: {{ optional($resource->bdsp)->name ?? 'You' }}</div>
                <div class="text-xs text-gray-400 mb-2">{{ strtoupper($resource->file_type) }} • {{ number_format($resource->file_size / 1024, 1) }} KB</div>
                <a href="{{ route('entrepreneur.resource.download', $resource->id) }}" class="mt-auto bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-[#a01a7d] transition">Download</a>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow p-5 flex flex-col col-span-3">
                <div class="font-semibold mb-2">No learning resources available yet.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection 