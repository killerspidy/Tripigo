@extends('admin.layouts.app')

@section('title', 'Blogs')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="mb-0">Blogs</h5>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-outline-primary btn-sm mr-2" data-toggle="modal" data-target="#exportArchiveModal">
                    Export as Archive
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm mr-2" data-toggle="modal" data-target="#importArchiveModal">
                    Import from Archive
                </button>
                @if(auth()->user()->can('create blogs'))
                <a href="{{ route('blogs.create') }}" class="btn btn-primary btn-sm">
                    + Blog Create
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
                            <th>Author</th>
                            <th>Published Date</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($blogs as $key => $blog)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                           <td>
                                @if($blog->image)
                                    <img src="{{ asset($blog->image) }}" width="60" height="60" style="object-fit: cover;">
                                @else
                                    —
                                @endif
                            </td>

                            <td>{{ Str::limit($blog->title, 50) }}</td>

                            <td>{{ $blog->author ?? '-' }}</td>

                            <td>{{ $blog->published_date ? $blog->published_date->format('Y-m-d') : '-' }}</td>

                            <td>
                                @if($blog->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>

                            <td>
                                @if(auth()->user()->can('edit blogs'))
                                <a href="{{ route('blogs.edit',$blog->slug) }}"
                                   class="btn btn-sm btn-info">
                                    Edit
                                </a>
                                @endif
                                @if(auth()->user()->can('delete blogs'))    
                                <form action="{{ route('blogs.delete',$blog->slug) }}"
                                      method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Delete this blog?')">
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
                            <td colspan="7" class="text-center">
                                No blogs found
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
<div class="modal fade" id="exportArchiveModal" tabindex="-1" role="dialog" aria-labelledby="exportArchiveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportArchiveModalLabel">Export Blogs as Archive</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Download all blogs as a ZIP archive containing <strong>blogs.xlsx</strong> and a <strong>media/</strong> folder with blog images. Use this to backup or migrate blogs with their images.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="{{ route('blogs.export-archive') }}" class="btn btn-primary">Export Archive</a>
            </div>
        </div>
    </div>
</div>

<!-- Import Archive Modal -->
<div class="modal fade" id="importArchiveModal" tabindex="-1" role="dialog" aria-labelledby="importArchiveModalLabel" aria-hidden="true">
    <form action="{{ route('blogs.import-archive') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importArchiveModalLabel">Import Blogs from Archive</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Upload a ZIP archive that was exported from this panel (contains <strong>blogs.xlsx</strong> and <strong>media/</strong> folder). Blogs and images will be imported.</p>
                    <div class="form-group">
                        <label for="archiveFile">Choose ZIP archive</label>
                        <input type="file" name="archive" id="archiveFile" class="form-control-file" accept=".zip" required>
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
