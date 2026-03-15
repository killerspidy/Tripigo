<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <title>AdminBite admin Template - Edit Role</title>
    <link href="../../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../../dist/css/style.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
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
                    <h5 class="mb-0">Edit Role</h5>
                    <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">Back</a>
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

                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Role Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control"
                                       placeholder="e.g., manager, editor"
                                       value="{{ old('name', $role->name) }}"
                                       required>
                                <small class="form-text text-muted">Use lowercase letters, numbers, and underscores only</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Permissions</label>
                                <div class="border p-3" style="max-height: 500px; overflow-y: auto;">
                                    @if($permissions->count() > 0)
                                        @foreach($groupedPermissions as $entity => $entityPermissions)
                                            <div class="mb-4">
                                                <h6 class="text-primary mb-2">
                                                    <strong>{{ ucfirst($entity) }}</strong>
                                                    <button type="button" class="btn btn-sm btn-link p-0 ml-2" onclick="toggleEntity('{{ $entity }}')">
                                                        <small>(Select All)</small>
                                                    </button>
                                                </h6>
                                                <div class="row" id="entity_{{ $entity }}">
                                                    @foreach($entityPermissions as $permission)
                                                        <div class="col-md-3 mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input entity-{{ $entity }}" type="checkbox" 
                                                                       name="permissions[]" 
                                                                       value="{{ $permission->id }}" 
                                                                       id="perm_{{ $permission->id }}"
                                                                       {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">No permissions available. Please run the PermissionSeeder to create permissions.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Update Role</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
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
    <script>
        function toggleEntity(entity) {
            const checkboxes = document.querySelectorAll('.entity-' + entity);
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        }
    </script>
</body>
</html>
