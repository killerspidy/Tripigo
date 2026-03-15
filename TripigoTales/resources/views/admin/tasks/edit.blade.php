<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <title>Admin - Edit Testimonial</title>
    <link href="../../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../../dist/css/style.min.css" rel="stylesheet">
</head>
<body>
    <div class="preloader"><div class="lds-ripple"><div class="lds-pos"></div><div class="lds-pos"></div></div></div>
    <div id="main-wrapper">
        @include('admin.partials.header')
        <div style="display:flex;">
            @include('admin.partials.sidebar')
            <main style="flex:1; padding:70px;">
                @yield('content')
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card shadow-sm">
                                <div class="card-header d-flex justify-content-between">
                                    <h5 class="mb-0">Edit Task</h5>
                                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary">Back</a>
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
                                    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                                <input type="text" name="title" class="form-control" placeholder="Task title" value="{{ old('title', $task->title) }}" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control" rows="4" placeholder="Task description">{{ old('description', $task->description) }}</textarea>
                                            </div>
                                            @if(auth()->user()->hasRole('admin'))
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Assign To (Employee) <span class="text-danger">*</span></label>
                                                <select name="assigned_to" class="form-control" required>
                                                    <option value="">Select employee</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }} ({{ $user->email }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @else
                                            <input type="hidden" name="assigned_to" value="{{ $task->assigned_to }}">
                                            @endif
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Due Date</label>
                                                <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Task</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        @include('admin.partials.footer')
    </div>
    <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../dist/js/app.min.js"></script>
    <script src="../../dist/js/app.init.mini-sidebar.js"></script>
    <script src="../../dist/js/app-style-switcher.js"></script>
    <script src="../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../../assets/extra-libs/sparkline/sparkline.js"></script>
    <script src="../../dist/js/waves.js"></script>
    <script src="../../dist/js/sidebarmenu.js"></script>
    <script src="../../dist/js/custom.min.js"></script>
</body>
</html>
