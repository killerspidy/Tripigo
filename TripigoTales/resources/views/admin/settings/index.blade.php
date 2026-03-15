@extends('admin.layouts.app')

@section('title', 'Global Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Global GST Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">Enable GST Globally</label>
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="gst_enabled" value="0">
                                <input type="checkbox" class="custom-control-input" id="gst_enabled" name="gst_enabled" value="1" {{ ($settings['gst_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="gst_enabled">Turn GST on/off for all tours</label>
                            </div>
                            <small class="text-muted">When enabled, GST will be added to all bookings according to the percentage below.</small>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">GST Percentage (%)</label>
                            <div class="input-group" style="max-width: 200px;">
                                <input type="number" name="gst_percentage" class="form-control" value="{{ $settings['gst_percentage'] ?? '5' }}" step="0.01" min="0" max="100" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <small class="text-muted">The default tax rate applied to tours (e.g., 5, 12, or 18).</small>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary px-4">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
