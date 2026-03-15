@extends('admin.layouts.app')

@section('title', 'Galleries')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Galleries</h5>
            @if(auth()->user()->can('create galleries'))
            <a href="{{ route('galleries.create') }}" class="btn btn-primary btn-sm">
                + Gallery Create
            </a>
            @endif
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
                            <th>Image</th>
                            <th>Title</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($galleries as $key => $gallery)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($gallery->image)
                                        <img src="{{ asset($gallery->image) }}" width="80" height="60" style="object-fit:cover;">
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ $gallery->title }}</td>
                                <td>
                                    @if(auth()->user()->can('edit galleries'))
                                    <a href="{{ route('galleries.edit', $gallery->id) }}" class="btn btn-sm btn-info">
                                        Edit
                                    </a>
                                    @endif
                                    @if(auth()->user()->can('delete galleries'))
                                    <form action="{{ route('galleries.delete', $gallery->id) }}"
                                          method="POST"
                                          style="display:inline-block"
                                          onsubmit="return confirm('Delete this gallery item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No gallery items found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
