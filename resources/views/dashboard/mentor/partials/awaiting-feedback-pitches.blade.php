<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <ul class="divide-y divide-gray-200">
        @forelse ($pitches as $pitch)
            <li x-data="{ showFeedbackForm: false }">
                <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-indigo-600 truncate">{{ $pitch->title }}</p>
                        <div class="ml-2 flex-shrink-0 flex">
                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $pitch->user->name }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-2 sm:flex sm:justify-between">
                        <div class="sm:flex">
                            <p class="flex items-center text-sm text-gray-500">
                                Submitted: {{ $pitch->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                            <button @click="showFeedbackForm = !showFeedbackForm" class="text-indigo-600 hover:text-indigo-900">
                                Give Feedback
                            </button>
                        </div>
                    </div>
                </div>
                <div x-show="showFeedbackForm" class="px-4 py-4 sm:px-6 border-t border-gray-200">
                    <form action="{{ route('practice-pitches.feedback', $pitch->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="feedback-{{ $pitch->id }}" class="block text-sm font-medium text-gray-700">Feedback</label>
                            <textarea id="feedback-{{ $pitch->id }}" name="feedback" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Submit Feedback
                        </button>
                    </form>
                </div>
            </li>
        @empty
            <li class="px-4 py-4 sm:px-6">
                <p class="text-sm text-gray-500">No pitches awaiting feedback.</p>
            </li>
        @endforelse
    </ul>
</div>