@extends('admin.layouts.app')

@section('title', 'Edit Gallery')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Gallery Item</h5>
                    <a href="{{ route('galleries.index') }}" class="btn btn-sm btn-secondary">Back</a>
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

                    <form method="POST" action="{{ route('galleries.update', $gallery->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       value="{{ old('title', $gallery->title) }}"
                                       required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Image</label>
                                @if($gallery->image)
                                    <div class="mb-2">
                                        <img src="{{ asset($gallery->image) }}" width="120" height="90" style="object-fit:cover;" class="img-thumbnail">
                                    </div>
                                @endif
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Leave empty to keep current image.</small>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('galleries.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

