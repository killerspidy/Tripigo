@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Create Add-on</h6>
                <a href="{{ route('addons.index') }}" class="btn btn-secondary btn-sm">Back</a>
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
                <form action="{{ route('addons.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="name">Add-on Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}" placeholder="e.g. Airport Transfer">
                            @error('name')<span class="text-danger text-xs">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="price">Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" required value="{{ old('price') }}" placeholder="0.00">
                            @error('price')<span class="text-danger text-xs">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="tour_ids">Apply to Tours <span class="text-muted">(optional — leave blank to apply globally)</span></label>
                            <select name="tour_ids[]" id="tour_ids" class="form-control" multiple style="height: auto; min-height: 130px;">
                                @foreach($tours as $tour)
                                    <option value="{{ $tour->id }}"
                                        {{ in_array($tour->id, (array) old('tour_ids', [])) ? 'selected' : '' }}>
                                        {{ $tour->title }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold <kbd>Ctrl</kbd> (Windows) or <kbd>⌘ Cmd</kbd> (Mac) to select multiple tours.</small>
                            @error('tour_ids')<span class="text-danger text-xs">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="description">Description (optional)</label>
                            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Brief description of this add-on…">{{ old('description') }}</textarea>
                            @error('description')<span class="text-danger text-xs">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Create Add-on</button>
                    <a href="{{ route('addons.index') }}" class="btn btn-secondary mt-3">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
