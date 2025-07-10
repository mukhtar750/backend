<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white p-6 rounded-xl shadow flex items-center border border-gray-100 justify-between">
        <div>
            <div class="text-sm text-gray-500 mb-1">Progress</div>
            <div class="text-3xl font-bold">{{ $progress ?? '68%' }}</div>
            <div class="text-xs text-gray-400">Program completion</div>
        </div>
        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-100">
            <i class="bi bi-graph-up text-green-500 text-2xl"></i>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow flex items-center border border-gray-100 justify-between">
        <div>
            <div class="text-sm text-gray-500 mb-1">Training Sessions</div>
            <div class="text-3xl font-bold">{{ $sessions ?? '12' }}</div>
            <div class="text-xs text-gray-400">{{ $sessionsCompleted ?? '8 completed' }}</div>
        </div>
        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-blue-100">
            <i class="bi bi-journal-text text-blue-500 text-2xl"></i>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow flex items-center border border-gray-100 justify-between">
        <div>
            <div class="text-sm text-gray-500 mb-1">Mentorship Hours</div>
            <div class="text-3xl font-bold">{{ $mentorshipHours ?? '24' }}</div>
            <div class="text-xs text-green-500">{{ $mentorshipChange ?? '+15% this month' }}</div>
        </div>
        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-purple-100">
            <i class="bi bi-person-lines-fill text-purple-500 text-2xl"></i>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow flex items-center border border-gray-100 justify-between">
        <div>
            <div class="text-sm text-gray-500 mb-1">Pitch Ready</div>
            <div class="text-3xl font-bold">{{ $pitchReady ?? '85%' }}</div>
            <div class="text-xs text-gray-400">Assessment score</div>
        </div>
        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-orange-100">
            <i class="bi bi-easel text-orange-500 text-2xl"></i>
        </div>
    </div>
</div> 