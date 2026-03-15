@extends('admin.layouts.app')

@section('title', 'Tours')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="mb-0">Tours</h5>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-outline-primary btn-sm mr-2" data-toggle="modal" data-target="#exportToursArchiveModal">
                    Export as Archive
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm mr-2" data-toggle="modal" data-target="#importToursArchiveModal">
                    Import from Archive
                </button>
                @if(auth()->user()->can('create tours'))
                <a href="{{ route('tours.create') }}" class="btn btn-primary btn-sm">
                    + Tour Create
                </a>
                @endif
            </div>
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
                            <th>Image</th>
                            <th>Title</th>
                            <th>Destination</th>
                            <th>Travel Type</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($tours as $key => $tour)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                           <td>
                                @if($tour->image)
                                    <img src="{{ asset($tour->image) }}" width="60">
                                @else
                                    —
                                @endif
                            </td>

                            <td>{{ $tour->title }}</td>

                            <td>{{ $tour->category->name ?? '-' }}</td>

                            <td>{{ $tour->subcategory->name ?? '-' }}</td>

                            <td>{{ $tour->location }}</td>


                            <td>₹ {{ $tour->price }}</td>

                            <td>
                                @if($tour->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>

                            <td>
                                @if(auth()->user()->can('edit tours'))
                                <a href="{{ route('tours.edit',$tour->slug) }}"
                                   class="btn btn-sm btn-info">
                                    Edit
                                </a>
                                @endif
                                @if(auth()->user()->can('delete tours'))    
                                <form action="{{ route('tours.delete',$tour->slug) }}"
                                      method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Delete this tour?')">
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
                            <td colspan="10" class="text-center">
                                No tours found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Export Archive Modal -->
<div class="modal fade" id="exportToursArchiveModal" tabindex="-1" role="dialog" aria-labelledby="exportToursArchiveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportToursArchiveModalLabel">Export Tours as Archive</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Download all tours as a ZIP archive containing <strong>tours.xlsx</strong> and a <strong>media/</strong> folder with main images, PDFs, and gallery images. Use this to backup or migrate tours.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="{{ route('tours.export-archive') }}" class="btn btn-primary">Export Archive</a>
            </div>
        </div>
    </div>
</div>

<!-- Import Archive Modal -->
<div class="modal fade" id="importToursArchiveModal" tabindex="-1" role="dialog" aria-labelledby="importToursArchiveModalLabel" aria-hidden="true">
    <form action="{{ route('tours.import-archive') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importToursArchiveModalLabel">Import Tours from Archive</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Upload a ZIP archive that was exported from this panel (contains <strong>tours.xlsx</strong> and <strong>media/</strong> folder). Tours and files will be imported.</p>
                    <div class="form-group">
                        <label for="toursArchiveFile">Choose ZIP archive</label>
                        <input type="file" name="archive" id="toursArchiveFile" class="form-control-file" accept=".zip" required>
                        @error('archive')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import Archive</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
