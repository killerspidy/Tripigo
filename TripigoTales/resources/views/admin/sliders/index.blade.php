@extends('admin.layouts.app')

@section('title', 'Sliders')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Sliders</h5>
            @if(auth()->user()->can('create sliders'))
            <a href="{{ route('sliders.create') }}" class="btn btn-primary btn-sm">+ Create Slider</a>
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
                            <th>Title</th>
                            <th>Buttons</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $key => $slider)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if($slider->image)
                                    <img src="{{ asset($slider->image) }}" width="80" height="50" style="object-fit:cover;">
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ Str::limit($slider->title, 40) }}</td>
                            <td>
                                @forelse($slider->buttons as $btn)
                                    <span class="badge badge-secondary">{{ $btn->label }}</span>
                                @empty
                                    —
                                @endforelse
                            </td>
                            <td>{{ $slider->sort_order }}</td>
                            <td>
                                @if($slider->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->can('edit sliders'))
                                <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-sm btn-info">Edit</a>
                                @endif
                                @if(auth()->user()->can('delete sliders'))
                                <form action="{{ route('sliders.delete', $slider->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this slider?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center">No sliders found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
