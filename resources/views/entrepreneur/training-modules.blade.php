@extends('layouts.entrepreneur')

@section('title', 'My Training Modules')

@section('content')
<div class="container mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Training Modules</h1>
        <p class="text-gray-600 mt-2">Access structured learning modules from your paired BDSPs</p>
    </div>

        @if($modules->isEmpty())
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <i class="bi bi-book text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Training Modules Available</h3>
                <p class="text-gray-500">Your paired BDSPs haven't created any training modules yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($modules as $module)
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-semibold text-gray-900 line-clamp-2">{{ $module->title }}</h3>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Published
                                </span>
                            </div>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $module->description }}</p>

                            <div class="text-sm text-gray-500 mb-4">
                                <div class="flex items-center mb-2">
                                    <i class="bi bi-person mr-2"></i>
                                    <span>{{ $module->bdsp->name ?? 'Unknown BDSP' }}</span>
                                </div>
                                <div class="flex items-center mb-2">
                                    <i class="bi bi-calendar mr-2"></i>
                                    <span>{{ $module->duration_weeks }} weeks • {{ $module->total_hours }} hours</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="bi bi-list-check mr-2"></i>
                                    <span>{{ $module->weeks->count() }} weekly sessions</span>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <a href="{{ route('entrepreneur.training-modules.show', $module) }}" 
                                   class="flex-1 bg-[#b81d8f] hover:bg-[#a01a7d] text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition">
                                    Start Learning
                                </a>
                                <a href="{{ route('entrepreneur.training-modules.progress', $module) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition">
                                    View Progress
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
