@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Testimonials</h5>
            @if(auth()->user()->can('create testimonials'))
            <a href="{{ route('testimonials.create') }}" class="btn btn-primary btn-sm">+ Create Testimonial</a>
            @endif
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Client Name</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $key => $testimonial)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if($testimonial->image)
                                    <img src="{{ asset($testimonial->image) }}" width="50" height="50" style="object-fit:cover; border-radius:50%;">
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $testimonial->client_name }}</td>
                            <td>{{ $testimonial->client_title ?? '—' }}</td>
                            <td>{{ Str::limit($testimonial->content, 50) }}</td>
                            <td>{{ $testimonial->sort_order }}</td>
                            <td>
                                @if($testimonial->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->can('edit testimonials'))
                                <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="btn btn-sm btn-info">Edit</a>
                                @endif
                                @if(auth()->user()->can('delete testimonials'))
                                <form action="{{ route('testimonials.delete', $testimonial->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this testimonial?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center">No testimonials found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
