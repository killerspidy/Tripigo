<?php $__env->startSection('title', 'Galleries'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Galleries</h5>
            <?php if(auth()->user()->can('create galleries')): ?>
            <a href="<?php echo e(route('galleries.create')); ?>" class="btn btn-primary btn-sm">
                + Gallery Create
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

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($key + 1); ?></td>
                                <td>
                                    <?php if($gallery->image): ?>
                                        <img src="<?php echo e(asset($gallery->image)); ?>" width="80" height="60" style="object-fit:cover;">
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($gallery->title); ?></td>
                                <td>
                                    <?php if(auth()->user()->can('edit galleries')): ?>
                                    <a href="<?php echo e(route('galleries.edit', $gallery->id)); ?>" class="btn btn-sm btn-info">
                                        Edit
                                    </a>
                                    <?php endif; ?>
                                    <?php if(auth()->user()->can('delete galleries')): ?>
                                    <form action="<?php echo e(route('galleries.delete', $gallery->id)); ?>"
                                          method="POST"
                                          style="display:inline-block"
                                          onsubmit="return confirm('Delete this gallery item?')">
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
                                <td colspan="4" class="text-center">No gallery items found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\new travel\resources\views/admin/galleries/index.blade.php ENDPATH**/ ?>