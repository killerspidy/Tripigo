@extends('admin.layouts.app')

@section('title', 'Reviews Management')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Reviews Management</h5>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Tour</th>
                            <th>User</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th width="250">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $key => $review)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $review->tour->title ?? 'N/A' }}</td>
                                <td>{{ $review->user->name ?? 'Guest' }}</td>
                                <td>{{ $review->name }}</td>
                                <td>{{ $review->email }}</td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <span class="fa fa-star checked" style="color: #ffc107;"></span>
                                        @else
                                            <span class="fa fa-star-o"></span>
                                        @endif
                                    @endfor
                                    ({{ $review->rating }}/5)
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($review->comment, 50) }}</td>
                                <td>
                                    @if($review->is_approved)
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $review->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('approve reviews')
                                            @if(!$review->is_approved)
                                                <form action="{{ route('reviews.approve', $review->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Approve this review?')">
                                                        Approve
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('reviews.reject', $review->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Reject this review?')">
                                                        Reject
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
                                        
                                        @can('reply reviews')
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#replyModal{{ $review->id }}">
                                                Reply
                                            </button>
                                        @endcan
                                        
                                        @can('delete reviews')
                                            <form action="{{ route('reviews.delete', $review->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this review?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>

                            <!-- Reply Modal -->
                            <div class="modal fade" id="replyModal{{ $review->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reply to Review</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('reviews.reply', $review->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Review Comment:</label>
                                                    <p class="form-control-plaintext">{{ $review->comment }}</p>
                                                </div>
                                                @if($review->admin_reply)
                                                    <div class="form-group">
                                                        <label>Current Reply:</label>
                                                        <p class="form-control-plaintext">{{ $review->admin_reply }}</p>
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <label for="admin_reply{{ $review->id }}">Admin Reply:</label>
                                                    <textarea name="admin_reply" id="admin_reply{{ $review->id }}" class="form-control" rows="4" required>{{ old('admin_reply', $review->admin_reply) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit Reply</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No reviews found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
