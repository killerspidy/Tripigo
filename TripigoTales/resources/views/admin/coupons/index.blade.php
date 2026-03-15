@extends('admin.layouts.app')

@section('title', 'Coupons')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Coupons</h5>
            @if(auth()->user()->can('create coupons'))
            <a href="{{ route('coupons.create') }}" class="btn btn-primary btn-sm">
                + Create Coupon
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
                            <th>Name</th>
                            <th>Code</th>
                            <th>Discount</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($coupons as $key => $coupon)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ Str::limit($coupon->name, 50) }}</td>
                            <td><code>{{ $coupon->code }}</code></td>
                            <td>{{ number_format($coupon->discount, 2) }}%</td>
                            <td>
                                @if($coupon->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->can('edit coupons'))
                                <a href="{{ route('coupons.edit', $coupon->id) }}"
                                   class="btn btn-sm btn-info">
                                    Edit
                                </a>
                                @endif
                                @if(auth()->user()->can('delete coupons'))
                                <form action="{{ route('coupons.delete', $coupon->id) }}"
                                      method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Delete this coupon?')">
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
                                No coupons found
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
