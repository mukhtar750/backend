@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Investor Access Requests</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @if ($accessRequests->isEmpty())
                        <div class="alert alert-info">
                            <p>You don't have any pending access requests from investors.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Investor</th>
                                        <th>Company</th>
                                        <th>Startup</th>
                                        <th>Request Date</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accessRequests as $request)
                                        <tr>
                                            <td>
                                                <strong>{{ $request->investor->name }}</strong><br>
                                                <small>{{ $request->investor->email }}</small>
                                            </td>
                                            <td>{{ $request->investor->company_name ?? 'Not specified' }}</td>
                                            <td>{{ $request->startup->name }}</td>
                                            <td>{{ $request->created_at->format('M d, Y') }}</td>
                                            <td>
                                                @if ($request->message)
                                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#messageModal{{ $request->id }}">
                                                        View Message
                                                    </button>
                                                    
                                                    <!-- Message Modal -->
                                                    <div class="modal fade" id="messageModal{{ $request->id }}" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel{{ $request->id }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="messageModalLabel{{ $request->id }}">Message from {{ $request->investor->name }}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {{ $request->message }}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">No message</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($request->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif ($request->status == 'approved')
                                                    <span class="badge badge-success">Approved</span>
                                                @elseif ($request->status == 'rejected')
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($request->status == 'pending')
                                                    <div class="btn-group" role="group">
                                                        <form action="{{ route('entrepreneur.approve_access', $request->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success mr-1">Approve</button>
                                                        </form>
                                                        
                                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal{{ $request->id }}">
                                                            Reject
                                                        </button>
                                                    </div>
                                                    
                                                    <!-- Reject Modal -->
                                                    <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel{{ $request->id }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form action="{{ route('entrepreneur.reject_access', $request->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="rejectModalLabel{{ $request->id }}">Reject Access Request</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="response_message">Reason for rejection (optional):</label>
                                                                            <textarea class="form-control" name="response_message" rows="3" placeholder="Provide a reason for rejecting this request..."></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                        <button type="submit" class="btn btn-danger">Reject Request</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif ($request->status == 'approved')
                                                    <form action="{{ route('entrepreneur.revoke_access', $request->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-warning">Revoke Access</button>
                                                    </form>
                                                @elseif ($request->status == 'rejected')
                                                    <form action="{{ route('entrepreneur.approve_access', $request->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                                    </form>
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
        </div>
    </div>
</div>
@endsection