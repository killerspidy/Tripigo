@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Add-ons Management</h6>
                <a href="{{ route('addons.create') }}" class="btn btn-primary btn-sm">Add New Add-on</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if(session('success'))
                    <div class="alert alert-success mx-4">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Applied To Tours</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($addons as $addon)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $addon->name }}</h6>
                                            @if($addon->description)
                                                <p class="text-xs text-secondary mb-0">{{ Str::limit($addon->description, 50) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($addon->tours->isEmpty())
                                        <span class="badge badge-sm bg-gradient-secondary">Global (All Tours)</span>
                                    @else
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($addon->tours as $tour)
                                                <span class="badge badge-sm bg-gradient-info" title="{{ $tour->title }}" style="font-size:10px; padding: 4px 8px;">
                                                    {{ Str::limit($tour->title, 20) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">₹{{ number_format($addon->price, 2) }}</p>
                                </td>
                                <td class="align-middle border-bottom-0">
                                    <a href="{{ route('addons.edit', $addon->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit Addon">
                                        Edit
                                    </a> |
                                    <form action="{{ route('addons.destroy', $addon->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger text-gradient px-3 mb-0" onclick="return confirm('Are you sure you want to delete this add-on?')"><i class="far fa-trash-alt me-2"></i>Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
