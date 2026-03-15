@extends('admin.layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tasks</h5>
            @if(auth()->user()->can('create tasks'))
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">+ Create Task</a>
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
                            <th>Title</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Created By</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $key => $task)
                            <tr>
                                <td>{{ $tasks->firstItem() + $key }}</td>
                                <td>{{ Str::limit($task->title, 40) }}</td>
                                <td>{{ $task->assignee->name ?? '-' }} <small class="text-muted">({{ $task->assignee->email ?? '' }})</small></td>
                                <td>
                                    @if($task->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($task->status === 'in_progress')
                                        <span class="badge badge-info">In Progress</span>
                                    @else
                                        <span class="badge badge-success">Completed</span>
                                    @endif
                                </td>
                                <td>{{ $task->due_date ? $task->due_date->format('d M Y') : '-' }}</td>
                                <td>{{ $task->creator->name ?? '-' }}</td>
                                <td>
                                    @if(auth()->user()->can('edit tasks'))
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-info">Edit</a>
                                    @endif
                                    @if(auth()->user()->can('delete tasks'))
                                    <form action="{{ route('tasks.delete', $task->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this task?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No tasks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $tasks->links() }}</div>
        </div>
    </div>
</div>
@endsection
