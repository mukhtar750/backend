@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Submission Details: {{ $submission->form->title }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Submission Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Submitted By:</strong> {{ $submission->user->name }}</p>
                    <p><strong>Pairing:</strong>
                        @if($submission->pairing)
                            {{ $submission->pairing->userOne->name }} & {{ $submission->pairing->userTwo->name }}
                        @else
                            N/A
                        @endif
                    </p>
                    <p><strong>Status:</strong>
                        @if($submission->status == 'pending_review')
                            <span class="badge badge-warning">Pending Review</span>
                        @elseif($submission->status == 'approved')
                            <span class="badge badge-success">Approved</span>
                        @elseif($submission->status == 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                        @else
                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $submission->status)) }}</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Submitted At:</strong> {{ $submission->created_at->format('M d, Y H:i') }}</p>
                    <p><strong>Last Updated:</strong> {{ $submission->updated_at->format('M d, Y H:i') }}</p>
                    @if($submission->signed_at)
                        <p><strong>Signed At:</strong> {{ $submission->signed_at->format('M d, Y H:i') }}</p>
                    @endif
                </div>
            </div>
            <hr>
            <h5>Form Data</h5>
            @php
                $formData = json_decode($submission->form_data, true);
            @endphp
            @if($formData)
                @foreach($submission->form->fields as $field)
                    @if(isset($formData[$field->name]))
                        <div class="mb-3">
                            <strong>{{ $field->label }}:</strong>
                            @if($field->type == 'file')
                                @php
                                    $fileInfo = $formData[$field->name];
                                    $filePath = Storage::url($fileInfo['path']);
                                @endphp
                                @if(is_array($fileInfo) && isset($fileInfo['name']) && isset($fileInfo['path']))
                                    <a href="{{ $filePath }}" target="_blank">{{ $fileInfo['name'] }}</a>
                                @else
                                    N/A (File not found or invalid format)
                                @endif
                            @elseif(is_array($formData[$field->name]))
                                <ul>
                                    @foreach($formData[$field->name] as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                {{ $formData[$field->name] }}
                            @endif
                        </div>
                    @endif
                @endforeach
            @else
                <p>No form data available.</p>
            @endif

            <hr>
            <h5>Review Information</h5>
            @if($submission->review)
                <p><strong>Reviewed By:</strong> {{ $submission->review->user->name }}</p>
                <p><strong>Review Status:</strong>
                    @if($submission->review->status == 'approved')
                        <span class="badge badge-success">Approved</span>
                    @elseif($submission->review->status == 'rejected')
                        <span class="badge badge-danger">Rejected</span>
                    @endif
                </p>
                <p><strong>Reviewed At:</strong> {{ $submission->review->created_at->format('M d, Y H:i') }}</p>
                <p><strong>Comments:</strong> {{ $submission->review->comments ?? 'N/A' }}</p>
            @else
                <p>No review available for this submission.</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('admin.mentorship.forms.list_submissions') }}" class="btn btn-secondary">Back to Submissions</a>
                <a href="{{ route('admin.mentorship.forms.review_submission', $submission->id) }}" class="btn btn-info">Review Submission</a>
                <a href="{{ route('admin.mentorship.forms.download_submission', $submission->id) }}" class="btn btn-success">Download Submission</a>
            </div>
        </div>
    </div>
</div>
@endsection