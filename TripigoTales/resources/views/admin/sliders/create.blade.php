@extends('admin.layouts.app')

@section('title', 'Create Slider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add New Slider</h5>
                    <a href="{{ route('sliders.index') }}" class="btn btn-sm btn-secondary">Back</a>
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
                    <form method="POST" action="{{ route('sliders.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Subtitle (small heading)</label>
                                <input type="text" name="subtitle" class="form-control" placeholder="e.g. Road To Travel" value="{{ old('subtitle') }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Begin Your Adventure With Us" value="{{ old('title') }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Slide description">{{ old('description') }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Background Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">JPG, PNG, WebP. Max 2MB</small>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Buttons (with links)</label>
                                <button type="button" class="btn btn-sm btn-success" id="addButtonRow">+ Add Button</button>
                            </div>
                            <div class="col-12" id="buttonsContainer">
                                <div class="button-row row mb-2 align-items-end border-bottom pb-2" data-index="0">
                                    <div class="col-md-4">
                                        <label>Button Label</label>
                                        <input type="text" name="buttons[0][label]" class="form-control form-control-sm" placeholder="e.g. Make An Enquiry">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Link (URL)</label>
                                        <input type="text" name="buttons[0][link]" class="form-control form-control-sm" placeholder="e.g. /contactus or https://...">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Style</label>
                                        <select name="buttons[0][style]" class="form-control form-control-sm">
                                            <option value="nir-btn">Primary (Teal)</option>
                                            <option value="nir-btn-black">Black</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-btn-row">×</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Create Slider</button>
                            <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    var buttonIndex = 1;
    $('#addButtonRow').on('click', function() {
        var html = '<div class="button-row row mb-2 align-items-end border-bottom pb-2" data-index="' + buttonIndex + '">' +
            '<div class="col-md-4"><label>Button Label</label><input type="text" name="buttons[' + buttonIndex + '][label]" class="form-control form-control-sm" placeholder="e.g. Make An Enquiry"></div>' +
            '<div class="col-md-4"><label>Link (URL)</label><input type="text" name="buttons[' + buttonIndex + '][link]" class="form-control form-control-sm" placeholder="/contactus"></div>' +
            '<div class="col-md-3"><label>Style</label><select name="buttons[' + buttonIndex + '][style]" class="form-control form-control-sm"><option value="nir-btn">Primary (Teal)</option><option value="nir-btn-black">Black</option></select></div>' +
            '<div class="col-md-1"><button type="button" class="btn btn-sm btn-outline-danger remove-btn-row">×</button></div></div>';
        $('#buttonsContainer').append(html);
        buttonIndex++;
    });
    $(document).on('click', '.remove-btn-row', function() {
        $(this).closest('.button-row').remove();
    });
});
</script>
@endpush
