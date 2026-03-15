@extends('admin.layouts.app')

@section('title', 'Subcategories (Travel Types)')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Subcategories (Travel Types)</h5>
            @if(auth()->user()->can('create categories'))
            <a href="{{ route('subcategories.create') }}" class="btn btn-primary btn-sm">
                + Add Subcategory
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
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Parent Category</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($subcategories as $key => $subcat)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>
                                @if($subcat->image)
                                    <img src="{{ asset($subcat->image) }}" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                <strong>{{ $subcat->name }}</strong>
                            </td>

                            <td>
                                {{ $subcat->parent->name ?? '-' }}
                            </td>

                            <td>
                                @if($subcat->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if(auth()->user()->can('edit categories'))
                                <a href="{{ route('subcategories.edit', $subcat) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                @endif
                                @if(auth()->user()->can('delete categories'))
                                <form method="POST"
                                      action="{{ route('subcategories.destroy', $subcat) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure? This will also delete all tours under this subcategory.')">
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
                            <td colspan="6" class="text-center text-muted">
                                No subcategories found
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
