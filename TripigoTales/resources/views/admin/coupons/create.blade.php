@extends('admin.layouts.app')

@section('title', 'Create Coupon')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add New Coupon</h5>
                    <a href="{{ route('coupons.index') }}" class="btn btn-sm btn-secondary">Back</a>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('coupons.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control"
                                       placeholder="Coupon name"
                                       value="{{ old('name') }}"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Code <span class="text-danger">*</span></label>
                                <input type="text" name="code"
                                       class="form-control"
                                       placeholder="e.g. SAVE10"
                                       value="{{ old('code') }}"
                                       required>
                                <small class="form-text text-muted">Unique code customers will enter (e.g. SAVE10)</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="discount" class="form-control" placeholder="10" step="0.01" min="0" max="999999.99" value="{{ old('discount') }}" required>
                                    <select name="discount_type" class="form-control" style="max-width: 120px;">
                                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed (₹)</option>
                                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                    </select>
                                </div>
                                <small class="form-text text-muted">Discount value and type</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Minimum Spend Amount (₹)</label>
                                <input type="number" name="min_amount" class="form-control" placeholder="0.00" step="0.01" min="0" value="{{ old('min_amount', '0.00') }}">
                                <small class="form-text text-muted">Minimum cart value required to use this coupon</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Expiry Date</label>
                                <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
                                <small class="form-text text-muted">Leave blank for no expiry</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Usage Limit</label>
                                <input type="number" name="usage_limit" class="form-control" placeholder="Unlimited" min="1" value="{{ old('usage_limit') }}">
                                <small class="form-text text-muted">Maximum number of times this coupon can be used across all users</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Create Coupon</button>
                            <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
