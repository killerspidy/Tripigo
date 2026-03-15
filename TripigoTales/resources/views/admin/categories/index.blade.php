@extends('admin.layouts.app')

@section('title', 'Categories (Destinations)')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Categories (Destinations)</h5>
            @if(auth()->user()->can('create categories'))
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
                + Add Category
            </a>
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categories as $key => $cat)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>
                                @if($cat->image)
                                    <img src="{{ asset($cat->image) }}" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                <strong>{{ $cat->name }}</strong>
                            </td>

                            <td>
                                @if($cat->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if(auth()->user()->can('edit categories'))
                                <a href="{{ route('categories.edit', $cat) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                @endif
                                @if(auth()->user()->can('delete categories'))
                                <form method="POST"
                                      action="{{ route('categories.destroy', $cat) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure? This will also delete all subcategories under this category.')">
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
                            <td colspan="5" class="text-center text-muted">
                                No categories found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
