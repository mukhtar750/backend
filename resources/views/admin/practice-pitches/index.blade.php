@extends('admin.layouts.admin')
@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold mb-6">Practice Pitch Submissions</h1>
    <div x-data="{ tab: 'pending' }" class="bg-white rounded-xl shadow p-6">
        <div class="mb-6 flex gap-4 border-b pb-2">
            <button @click="tab = 'pending'" :class="tab === 'pending' ? 'border-b-2 border-[#b81d8f] text-[#b81d8f]' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Pending</button>
            <button @click="tab = 'approved'" :class="tab === 'approved' ? 'border-b-2 border-green-600 text-green-700' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Approved</button>
            <button @click="tab = 'rejected'" :class="tab === 'rejected' ? 'border-b-2 border-red-600 text-red-700' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Rejected</button>
            <button @click="tab = 'reviewed'" :class="tab === 'reviewed' ? 'border-b-2 border-blue-600 text-blue-700' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Reviewed</button>
        </div>
        <!-- Pending -->
        <div x-show="tab === 'pending'">
            @include('admin.practice-pitches.partials.table', ['pitches' => $pendingPitches, 'status' => 'pending'])
        </div>
        <!-- Approved -->
        <div x-show="tab === 'approved'">
            @include('admin.practice-pitches.partials.table', ['pitches' => $approvedPitches, 'status' => 'approved'])
        </div>
        <!-- Rejected -->
        <div x-show="tab === 'rejected'">
            @include('admin.practice-pitches.partials.table', ['pitches' => $rejectedPitches, 'status' => 'rejected'])
        </div>
        <!-- Reviewed -->
        <div x-show="tab === 'reviewed'">
            @include('admin.practice-pitches.partials.table', ['pitches' => $reviewedPitches, 'status' => 'reviewed'])
        </div>
    </div>
</div>
@endsection 