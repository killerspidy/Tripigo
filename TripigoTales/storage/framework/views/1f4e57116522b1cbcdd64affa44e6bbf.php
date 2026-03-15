<?php $__env->startSection('title', 'Sliders'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Sliders</h5>
            <?php if(auth()->user()->can('create sliders')): ?>
            <a href="<?php echo e(route('sliders.create')); ?>" class="btn btn-primary btn-sm">+ Create Slider</a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Buttons</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($key + 1); ?></td>
                            <td>
                                <?php if($slider->image): ?>
                                    <img src="<?php echo e(asset($slider->image)); ?>" width="80" height="50" style="object-fit:cover;">
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(Str::limit($slider->title, 40)); ?></td>
                            <td>
                                <?php $__empty_2 = true; $__currentLoopData = $slider->buttons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $btn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <span class="badge badge-secondary"><?php echo e($btn->label); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($slider->sort_order); ?></td>
                            <td>
                                <?php if($slider->status): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(auth()->user()->can('edit sliders')): ?>
                                <a href="<?php echo e(route('sliders.edit', $slider->id)); ?>" class="btn btn-sm btn-info">Edit</a>
                                <?php endif; ?>
                                <?php if(auth()->user()->can('delete sliders')): ?>
                                <form action="<?php echo e(route('sliders.delete', $slider->id)); ?>" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this slider?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="7" class="text-center">No sliders found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\new travel\resources\views/admin/sliders/index.blade.php ENDPATH**/ ?>