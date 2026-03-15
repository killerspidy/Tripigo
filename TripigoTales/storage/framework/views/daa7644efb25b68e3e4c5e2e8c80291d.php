
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <title>Admin - Create Testimonial</title>
    <link href="../../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../../dist/css/style.min.css" rel="stylesheet">
</head>
<body>
    <div class="preloader"><div class="lds-ripple"><div class="lds-pos"></div><div class="lds-pos"></div></div></div>
    <div id="main-wrapper">
        <?php echo $__env->make('admin.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div style="display:flex;">
            <?php echo $__env->make('admin.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <main style="flex:1; padding:70px;">
                <?php echo $__env->yieldContent('content'); ?>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card shadow-sm">
                                <div class="card-header d-flex justify-content-between">
                                    <h5 class="mb-0">Create Task</h5>
                                    <a href="<?php echo e(route('tasks.index')); ?>" class="btn btn-sm btn-secondary">Back</a>
                                </div>
                                <div class="card-body">
                                    <?php if($errors->any()): ?>
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><?php echo e($error); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    <form method="POST" action="<?php echo e(route('tasks.store')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                                <input type="text" name="title" class="form-control" placeholder="Task title" value="<?php echo e(old('title')); ?>" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control" rows="4" placeholder="Task description"><?php echo e(old('description')); ?></textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Assign To (Employee) <span class="text-danger">*</span></label>
                                                <select name="assigned_to" class="form-control" required>
                                                    <option value="">Select employee</option>
                                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($user->id); ?>" <?php echo e(old('assigned_to') == $user->id ? 'selected' : ''); ?>>
                                                            <?php echo e($user->name); ?> (<?php echo e($user->email); ?>)
                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="pending" <?php echo e(old('status', 'pending') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                                                    <option value="in_progress" <?php echo e(old('status') === 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                                                    <option value="completed" <?php echo e(old('status') === 'completed' ? 'selected' : ''); ?>>Completed</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Due Date</label>
                                                <input type="date" name="due_date" class="form-control" value="<?php echo e(old('due_date')); ?>">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Create Task</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?php echo $__env->make('admin.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php /**PATH C:\travel update website\working\resources\views/admin/tasks/create.blade.php ENDPATH**/ ?>