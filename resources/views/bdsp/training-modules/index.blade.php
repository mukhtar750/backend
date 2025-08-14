@extends('layouts.bdsp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Training Modules</h1>
            <p class="text-gray-600 mt-2">Create and manage structured learning modules for your mentees</p>
        </div>
        <a href="{{ route('bdsp.training-modules.create') }}" 
           class="bg-[#b81d8f] hover:bg-[#a01a7d] text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition">
            <i class="bi bi-plus-circle mr-2"></i>Create New Module
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    @if($modules->isEmpty())
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <i class="bi bi-book text-6xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Training Modules Yet</h3>
            <p class="text-gray-500 mb-6">Start creating structured learning modules to help your mentees grow</p>
            <a href="{{ route('bdsp.training-modules.create') }}" 
               class="bg-[#b81d8f] hover:bg-[#a01a7d] text-white px-6 py-3 rounded-lg font-semibold">
                Create Your First Module
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($modules as $module)
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-shadow flex flex-col h-full">
                    <div class="p-6 flex flex-col h-full">
                        <!-- Header with title and status -->
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 line-clamp-2 flex-1 mr-3">{{ $module->title }}</h3>
                            <div class="flex-shrink-0">
                                @if($module->status === 'draft')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Draft
                                    </span>
                                @elseif($module->status === 'published')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Published
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Archived
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Description with fixed height -->
                        <div class="mb-4 flex-shrink-0">
                            <p class="text-gray-600 text-sm line-clamp-3 h-16">{{ $module->description }}</p>
                        </div>

                        <!-- Stats grid with fixed height -->
                        <div class="grid grid-cols-2 gap-4 mb-6 text-sm flex-shrink-0">
                            <div>
                                <span class="text-gray-500">Duration:</span>
                                <span class="font-semibold text-gray-900">{{ $module->duration_weeks }} weeks</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Hours:</span>
                                <span class="font-semibold text-gray-900">{{ $module->total_hours }}h</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Weeks:</span>
                                <span class="font-semibold text-gray-900">{{ $module->weeks->count() }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Progress:</span>
                                <span class="font-semibold text-gray-900">{{ $module->progress->count() }} mentees</span>
                            </div>
                        </div>

                        <!-- Action buttons - pushed to bottom -->
                        <div class="flex space-x-2 mt-auto">
                            <a href="{{ route('bdsp.training-modules.show', $module) }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition">
                                View
                            </a>
                            
                            @if($module->status === 'draft')
                                <a href="{{ route('bdsp.training-modules.edit', $module) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition">
                                    Edit
                                </a>
                                
                                <button type="button" 
                                        class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition"
                                        onclick="publishModule({{ $module->id }})">
                                    Publish
                                </button>
                            @endif

                            @if($module->status === 'published')
                                <button type="button" 
                                        class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition"
                                        onclick="archiveModule({{ $module->id }})">
                                    Archive
                                </button>
                            @endif

                            @if($module->status === 'archived')
                                <button type="button" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition"
                                        onclick="unarchiveModule({{ $module->id }})">
                                    Unarchive
                                </button>
                            @endif

                            @if($module->progress->count() === 0)
                                <form action="{{ route('bdsp.training-modules.destroy', $module) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition"
                                            onclick="return confirm('Delete this module? This action cannot be undone.')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

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

<script>
function publishModule(moduleId) {
    if (confirm('Publish this module? It will be visible to your mentees.')) {
        fetch(`/bdsp/training-modules/${moduleId}/publish`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Error publishing module. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error publishing module. Please try again.');
        });
    }
}

function archiveModule(moduleId) {
    if (confirm('Archive this module? It will no longer be visible to mentees.')) {
        fetch(`/bdsp/training-modules/${moduleId}/archive`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Error archiving module. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error archiving module. Please try again.');
        });
    }
}

function unarchiveModule(moduleId) {
    if (confirm('Unarchive this module? It will be set back to draft status.')) {
        fetch(`/bdsp/training-modules/${moduleId}/unarchive`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Error unarchiving module. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error unarchiving module. Please try again.');
        });
    }
}
</script>
@endsection
