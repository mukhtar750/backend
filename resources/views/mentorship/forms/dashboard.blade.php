@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Mentorship Forms Dashboard</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4">Progress Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-100 p-4 rounded-lg">
                <h3 class="text-lg font-medium">Total Submissions</h3>
                <p class="text-3xl font-bold">{{ $totalSubmissions }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-lg">
                <h3 class="text-lg font-medium">Approved Submissions</h3>
                <p class="text-3xl font-bold">{{ $approvedSubmissions }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg">
                <h3 class="text-lg font-medium">Pending Reviews</h3>
                <p class="text-3xl font-bold">{{ $pendingReviews }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4">My Submissions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-100 p-4 rounded-lg">
                <h3 class="text-lg font-medium">Drafts</h3>
                <p class="text-3xl font-bold">{{ $mySubmissions->where('is_draft', true)->count() }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg">
                <h3 class="text-lg font-medium">Submitted</h3>
                <p class="text-3xl font-bold">{{ $mySubmissions->where('is_draft', false)->where('status', 'pending')->count() }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg">
                <h3 class="text-lg font-medium">Approved</h3>
                <p class="text-3xl font-bold">{{ $mySubmissions->where('status', 'approved')->count() }}</p>
            </div>
        </div>

        @if($mySubmissions->isEmpty())
            <p>You have no submissions yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">Form Title</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">Pairing</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">Submitted At</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mySubmissions as $submission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b border-gray-200">{{ $submission->form->title }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $submission->pairing->mentor->name }} & {{ $submission->pairing->mentee->name }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $submission->is_draft ? 'bg-gray-200 text-gray-800' : ($submission->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $submission->is_draft ? 'Draft' : ucfirst($submission->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y H:i') : 'N/A' }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">
                                    <a href="{{ route('mentorship.forms.show', $submission->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">View</a>
                                    @if($submission->is_draft || ($submission->status == 'pending' && auth()->user()->id == $submission->submitted_by))
                                        <a href="{{ route('mentorship.forms.edit', $submission->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Forms for Review</h2>
        @if($forReviewSubmissions->isEmpty())
            <p>No forms currently require your review.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">Form Title</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">Submitted By</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">Pairing</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">Submitted At</th>
                            <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($forReviewSubmissions as $submission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b border-gray-200">{{ $submission->form->title }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $submission->submittedBy->name }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $submission->pairing->mentor->name }} & {{ $submission->pairing->mentee->name }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $submission->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $submission->submitted_at->format('M d, Y H:i') }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">
                                    <a href="{{ route('mentorship.forms.show', $submission->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">View</a>
                                    @if($submission->status == 'pending')
                                        <a href="{{ route('mentorship.forms.review', $submission->id) }}" class="text-green-600 hover:text-green-900">Review</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection