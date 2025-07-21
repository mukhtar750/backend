@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">All Mentorship Form Submissions</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Submissions Overview</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="allSubmissionsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Form Title</th>
                            <th>Submitted By</th>
                            <th>Pairing</th>
                            <th>Submitted At</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $submission)
                        <tr>
                            <td>{{ $submission->id }}</td>
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
                                <a href="{{ route('admin.mentorship.forms.review_submission', $submission->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-clipboard-check"></i> Review
                                </a>
                                <a href="{{ route('admin.mentorship.forms.download_submission', $submission->id) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No submissions found.</td>
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
        $('#allSubmissionsTable').DataTable();
    });
</script>
@endpush