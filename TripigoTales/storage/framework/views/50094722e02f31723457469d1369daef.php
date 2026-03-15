<?php $__env->startSection('title', 'Subcategories (Travel Types)'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Subcategories (Travel Types)</h5>
            <?php if(auth()->user()->can('create categories')): ?>
            <a href="<?php echo e(route('subcategories.create')); ?>" class="btn btn-primary btn-sm">
                + Add Subcategory
            </a>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Parent Category</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($key + 1); ?></td>

                            <td>
                                <?php if($subcat->image): ?>
                                    <img src="<?php echo e(asset($subcat->image)); ?>" width="50" height="50" style="object-fit: cover;">
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <strong><?php echo e($subcat->name); ?></strong>
                            </td>

                            <td>
                                <?php echo e($subcat->parent->name ?? '-'); ?>

                            </td>

                            <td>
                                <?php if($subcat->status): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php if(auth()->user()->can('edit categories')): ?>
                                <a href="<?php echo e(route('subcategories.edit', $subcat)); ?>"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                <?php endif; ?>
                                <?php if(auth()->user()->can('delete categories')): ?>
                                <form method="POST"
                                      action="<?php echo e(route('subcategories.destroy', $subcat)); ?>"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure? This will also delete all tours under this subcategory.')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No subcategories found
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\travel update website\working\resources\views/admin/subcategories/index.blade.php ENDPATH**/ ?>