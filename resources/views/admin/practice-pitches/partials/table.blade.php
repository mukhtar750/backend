<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Entrepreneur</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">File</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Admin Feedback</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mentor/BDSP Feedback</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($pitches as $pitch)
            <tr>
                <td class="px-4 py-2">{{ $pitch->user->name ?? 'Unknown' }}</td>
                <td class="px-4 py-2 font-semibold">{{ $pitch->title }}</td>
                <td class="px-4 py-2">
                    @if(Str::contains($pitch->file_type, 'mp4'))
                        <video src="{{ asset('storage/' . $pitch->file_path) }}" controls class="h-8 w-16"></video>
                    @elseif(Str::contains($pitch->file_type, 'mp3'))
                        <audio src="{{ asset('storage/' . $pitch->file_path) }}" controls></audio>
                    @elseif(Str::contains($pitch->file_type, 'pdf'))
                        <a href="{{ asset('storage/' . $pitch->file_path) }}" target="_blank" class="text-blue-600 underline">View PDF</a>
                    @else
                        <a href="{{ asset('storage/' . $pitch->file_path) }}" target="_blank" class="text-blue-600 underline">Download</a>
                    @endif
                </td>
                <td class="px-4 py-2 text-sm text-gray-600">{{ Str::limit($pitch->description, 60) }}</td>
                <td class="px-4 py-2 text-xs">
                    @if($pitch->status === 'pending')
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Pending</span>
                    @elseif($pitch->status === 'approved')
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Approved</span>
                    @elseif($pitch->status === 'rejected')
                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">Rejected</span>
                    @elseif($pitch->status === 'reviewed')
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Reviewed</span>
                    @endif
                </td>
                <td class="px-4 py-2 text-sm">
                    @if($pitch->admin_feedback)
                        <span class="text-red-600">{{ $pitch->admin_feedback }}</span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-4 py-2 text-sm">
                    @if($pitch->feedback)
                        <span class="text-green-700">{{ $pitch->feedback }}</span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-4 py-2 text-xs text-gray-500">{{ $pitch->created_at->diffForHumans() }}</td>
                <td class="px-4 py-2 flex gap-2">
                    @if($status === 'pending')
                        <form action="{{ route('admin.practice-pitches.approve', $pitch->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Approve</button>
                        </form>
                        <button onclick="document.getElementById('reject-modal-{{ $pitch->id }}').classList.remove('hidden')" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Reject</button>
                        <!-- Reject Modal -->
                        <div id="reject-modal-{{ $pitch->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md relative">
                                <button onclick="document.getElementById('reject-modal-{{ $pitch->id }}').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
                                <h2 class="text-lg font-bold mb-4">Reject Pitch</h2>
                                <form action="{{ route('admin.practice-pitches.reject', $pitch->id) }}" method="POST">
                                    @csrf
                                    <label class="block text-sm font-semibold mb-2">Reason/Feedback</label>
                                    <textarea name="admin_feedback" class="form-input w-full rounded-md mb-4" rows="3" required></textarea>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="document.getElementById('reject-modal-{{ $pitch->id }}').classList.add('hidden')" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Cancel</button>
                                        <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700">Reject</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center text-gray-400 py-8">No practice pitches found.</td>
            </tr>
        @endforelse
    </tbody>
</table> 