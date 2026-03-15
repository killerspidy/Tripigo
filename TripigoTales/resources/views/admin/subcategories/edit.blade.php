@extends('admin.layouts.app')

@section('title', 'Edit Subcategory')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Edit Subcategory (Travel Type)</h5>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" enctype="multipart/form-data" action="{{ route('subcategories.update', $subcategory) }}">
                        @csrf
                        @method('PUT')

                        <!-- Subcategory Name -->
                        <div class="mb-3">
                            <label class="form-label">
                                Subcategory Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                name="name"
                                value="{{ old('name', $subcategory->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter subcategory name"
                                required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Parent Category -->
                        <div class="mb-3">
                            <label class="form-label">
                                Parent Category (Destination) <span class="text-danger">*</span>
                            </label>
                            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror" required>
                                <option value="">Select Parent Category</option>

                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}"
                                    {{ old('parent_id', $subcategory->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Select the parent category (destination) for this subcategory.</small>
                        </div>

                        <!-- Current Image -->
                        @if($subcategory->image)
                            <div class="mb-3">
                                <label class="form-label">Current Image</label><br>
                                <img src="{{ asset($subcategory->image) }}" width="100" height="100" style="object-fit: cover;" class="img-thumbnail">
                            </div>
                        @endif

                        <!-- New Image -->
                        <div class="mb-3">
                            <label class="form-label">Change Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            <small class="form-text text-muted">Leave empty to keep current image. Max size: 2MB. Formats: JPG, JPEG, PNG, WEBP</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label><br>
                            <input type="checkbox"
                                name="status"
                                value="1"
                                {{ old('status', $subcategory->status) ? 'checked' : '' }}>
                            <span>Active</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between text-end">
                            <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">
                                Back
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Update Subcategory
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
