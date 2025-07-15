@extends('admin.layouts.admin')
@section('title', 'Feedback Review')
@section('content')
<div class="max-w-6xl mx-auto mt-10" x-data="{ feedbacks: @js($feedback->items()) }">
    <h2 class="text-3xl font-bold mb-6">Feedback Review</h2>
    <div class="mb-4 flex flex-wrap gap-2">
        <form method="GET" class="flex gap-2">
            <select name="status" onchange="this.form.submit()" class="border rounded px-3 py-2">
                <option value="">All Statuses</option>
                <option value="pending"{{ request('status') == 'pending' ? ' selected' : '' }}>Pending</option>
                <option value="reviewed"{{ request('status') == 'reviewed' ? ' selected' : '' }}>Reviewed</option>
                <option value="resolved"{{ request('status') == 'resolved' ? ' selected' : '' }}>Resolved</option>
            </select>
        </form>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="py-2 px-3 text-left">Date</th>
                    <th class="py-2 px-3 text-left">User</th>
                    <th class="py-2 px-3 text-left">Target</th>
                    <th class="py-2 px-3 text-left">Category</th>
                    <th class="py-2 px-3 text-left">Rating</th>
                    <th class="py-2 px-3 text-left">Comments</th>
                    <th class="py-2 px-3 text-left">Status</th>
                    <th class="py-2 px-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedback as $fb)
                <tr class="border-b hover:bg-gray-50" x-data="{ deleting: false, status: '{{ $fb->status }}' }" x-show="!deleting">
                    <td class="py-2 px-3">{{ $fb->created_at->format('Y-m-d') }}</td>
                    <td class="py-2 px-3">{{ $fb->user->name ?? 'N/A' }}</td>
                    <td class="py-2 px-3">{{ ucfirst($fb->target_type) }}{{ $fb->target_id ? ' #'.$fb->target_id : '' }}</td>
                    <td class="py-2 px-3">{{ $fb->category }}</td>
                    <td class="py-2 px-3">{{ $fb->rating ?? '-' }}</td>
                    <td class="py-2 px-3 max-w-xs truncate" title="{{ $fb->comments }}">{{ Str::limit($fb->comments, 50) }}</td>
                    <td class="py-2 px-3">
                        <span class="px-2 py-1 rounded text-xs"
                            :class="status === 'pending' ? 'bg-yellow-100 text-yellow-800' : (status === 'reviewed' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800')">
                            <span x-text="status.charAt(0).toUpperCase() + status.slice(1)"></span>
                        </span>
                    </td>
                    <td class="py-2 px-3 flex gap-2 items-center">
                        @if($fb->status != 'resolved')
                        <form method="POST" action="{{ route('admin.feedback.update', $fb->id) }}" class="inline" @submit.prevent="
                            let form = $event.target;
                            let newStatus = form.status.value;
                            if (!newStatus) return;
                            status = newStatus;
                            fetch(form.action, {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': form._token.value,
                                    'Accept': 'application/json',
                                },
                                body: new URLSearchParams(new FormData(form))
                            }).then(() => {}).catch(() => {});
                        ">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="border rounded px-2 py-1 text-xs" @change="form.dispatchEvent(new Event('submit'))">
                                <option value="">Change Status</option>
                                @if($fb->status != 'reviewed')
                                <option value="reviewed">Mark as Reviewed</option>
                                @endif
                                <option value="resolved">Mark as Resolved</option>
                            </select>
                        </form>
                        @endif
                        <!-- Delete Button -->
                        <form method="POST" action="{{ route('admin.feedback.destroy', $fb->id) }}" x-ref="deleteForm" @submit.prevent="
                            if(confirm('Are you sure you want to delete this feedback?')) {
                                deleting = true;
                                fetch($el.action, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': $el._token.value,
                                        'Accept': 'application/json',
                                    },
                                }).then(() => { deleting = true; }).catch(() => { deleting = false; });
                            }
                        ">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold px-2 py-1 rounded border border-red-200 bg-red-50" title="Delete Feedback">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-6 text-gray-500">No feedback found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-6">{{ $feedback->withQueryString()->links() }}</div>
    </div>
</div>
@endsection 