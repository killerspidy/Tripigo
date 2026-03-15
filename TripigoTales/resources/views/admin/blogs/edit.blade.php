@extends('admin.layouts.app')

@section('title', 'Edit Blog')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Blog</h5>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Blog</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">
                    <form method="POST"
                            action="{{ route('blogs.update', $blog->slug) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Blog title"
                                        value="{{ old('title', $blog->title) }}"
                                        required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Author</label>
                                    <input type="text" name="author"
                                        class="form-control @error('author') is-invalid @enderror"
                                        placeholder="Author name"
                                        value="{{ old('author', $blog->author) }}">
                                    @error('author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Published Date</label>
                                    <input type="date" name="published_date"
                                        class="form-control @error('published_date') is-invalid @enderror"
                                        value="{{ old('published_date', $blog->published_date ? $blog->published_date->format('Y-m-d') : '') }}">
                                    @error('published_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Image</label>
                                    @if($blog->image)
                                        <div class="mb-2">
                                            <img src="{{ asset($blog->image) }}" width="150" height="150" style="object-fit: cover;" class="img-thumbnail">
                                            <p class="text-muted small mt-1">Current Image</p>
                                        </div>
                                    @endif
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    <small class="form-text text-muted">Leave empty to keep current image. Accepted formats: JPG, JPEG, PNG (Max: 2MB)</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', $blog->status) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description"
                                            class="form-control @error('description') is-invalid @enderror"
                                            rows="8"
                                            placeholder="Blog description">{{ old('description', $blog->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Update Blog</button>
                                <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
