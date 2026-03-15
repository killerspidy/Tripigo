@extends('admin.layouts.app')

@section('title', 'Roles')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Roles</h5>
            {{-- <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
                + Create Role
            </a> --}}
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
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th>Users Count</th>
                            <th>Created At</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($roles as $key => $role)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <strong>{{ $role->name }}</strong>
                                @if($role->name === 'admin')
                                    <span class="badge badge-warning">Protected</span>
                                @endif
                            </td>
                            <td>
                                @forelse($role->permissions as $permission)
                                    <span class="badge badge-secondary">{{ $permission->name }}</span>
                                @empty
                                    <span class="text-muted">No permissions</span>
                                @endforelse
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $role->users_count ?? $role->users()->count() }}</span>
                            </td>
                            <td>{{ $role->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('roles.edit', $role->id) }}"
                                   class="btn btn-sm btn-info">
                                    Edit
                                </a>

                                @if($role->name !== 'admin')
                                <form action="{{ route('roles.delete', $role->id) }}"
                                      method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Delete this role? All users with this role will lose their role assignment.')">
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
                            <td colspan="6" class="text-center">
                                No roles found
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
