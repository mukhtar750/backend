<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <ul class="divide-y divide-gray-200">
        @forelse ($pitches as $pitch)
            <li>
                <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-indigo-600 truncate">{{ $pitch->title }}</p>
                        <div class="ml-2 flex-shrink-0 flex">
                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $pitch->user->name }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-2 sm:flex sm:justify-between">
                        <div class="sm:flex">
                            <p class="flex items-center text-sm text-gray-500">
                                Reviewed: {{ $pitch->updated_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700">Your Feedback:</p>
                        <p class="text-sm text-gray-500">{{ $pitch->feedback }}</p>
                    </div>
                </div>
            </li>
        @empty
            <li class="px-4 py-4 sm:px-6">
                <p class="text-sm text-gray-500">You have not reviewed any pitches yet.</p>
            </li>
        @endforelse
    </ul>
</div>