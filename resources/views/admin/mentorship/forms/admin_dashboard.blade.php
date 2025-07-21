@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Mentorship Forms Admin Dashboard</h1>

    <!-- Overview Cards -->
    <div class="row">
        <!-- Total Submissions Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Submissions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSubmissions }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Review Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Review</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingReviews }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Submissions Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Approved Submissions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $approvedSubmissions }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejected Submissions Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Rejected Submissions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rejectedSubmissions }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Forms for Review Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Forms Awaiting Your Review</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="formsForReviewTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Form Title</th>
                            <th>Submitted By</th>
                            <th>Pairing</th>
                            <th>Submitted At</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formsForReview as $submission)
                        <tr>
                            <td>{{ $submission->form->title }}</td>
                            <td>{{ $submission->user->name }}</td>
                            <td>
                                @if($submission->pairing)
                                    {{ $submission->pairing->userOne->name }} & {{ $submission->pairing->userTwo->name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $submission->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                @if($submission->status == 'pending_review')
                                    <span class="badge badge-warning">Pending Review</span>
                                @elseif($submission->status == 'approved')
                                    <span class="badge badge-success">Approved</span>
                                @elseif($submission->status == 'rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                @else
                                    <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $submission->status)) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.mentorship.forms.review_submission', $submission->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Review
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No forms awaiting review.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- All Submissions Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Mentorship Form Submissions</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="allSubmissionsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Form Title</th>
                            <th>Submitted By</th>
                            <th>Pairing</th>
                            <th>Submitted At</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allSubmissions as $submission)
                        <tr>
                            <td>{{ $submission->form->title }}</td>
                            <td>{{ $submission->user->name }}</td>
                            <td>
                                @if($submission->pairing)
                                    {{ $submission->pairing->userOne->name }} & {{ $submission->pairing->userTwo->name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $submission->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                @if($submission->status == 'pending_review')
                                    <span class="badge badge-warning">Pending Review</span>
                                @elseif($submission->status == 'approved')
                                    <span class="badge badge-success">Approved</span>
                                @elseif($submission->status == 'rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                @else
                                    <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $submission->status)) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.mentorship.forms.show_submission', $submission->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('admin.mentorship.forms.download_submission', $submission->id) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No submissions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script>
    $(document).ready(function() {
        $('#formsForReviewTable').DataTable();
        $('#allSubmissionsTable').DataTable();
    });
</script>
@endpush
