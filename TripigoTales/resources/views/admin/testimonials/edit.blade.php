@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Testimonial</h5>
                    <a href="{{ route('testimonials.index') }}" class="btn btn-sm btn-secondary">Back</a>
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
                    <form method="POST" action="{{ route('testimonials.update', $testimonial->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Client Name <span class="text-danger">*</span></label>
                                <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $testimonial->client_name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Client Title / Position</label>
                                <input type="text" name="client_title" class="form-control" value="{{ old('client_title', $testimonial->client_title) }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Testimonial Content <span class="text-danger">*</span></label>
                                <textarea name="content" class="form-control" rows="5" required>{{ old('content', $testimonial->content) }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Client Image</label>
                                @if($testimonial->image)
                                    <div class="mb-2">
                                        <img src="{{ asset($testimonial->image) }}" width="80" height="80" style="object-fit:cover; border-radius:50%;" class="img-thumbnail">
                                    </div>
                                @endif
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $testimonial->sort_order) }}" min="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="status" value="1" {{ old('status', $testimonial->status) ? 'checked' : '' }}>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Update Testimonial</button>
                            <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
