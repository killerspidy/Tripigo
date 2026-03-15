<?php $__env->startSection('title', 'Coupons'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Coupons</h5>
            <?php if(auth()->user()->can('create coupons')): ?>
            <a href="<?php echo e(route('coupons.create')); ?>" class="btn btn-primary btn-sm">
                + Create Coupon
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
                            <th>Name</th>
                            <th>Code</th>
                            <th>Discount</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($key + 1); ?></td>
                            <td><?php echo e(Str::limit($coupon->name, 50)); ?></td>
                            <td><code><?php echo e($coupon->code); ?></code></td>
                            <td><?php echo e(number_format($coupon->discount, 2)); ?>%</td>
                            <td>
                                <?php if($coupon->status): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(auth()->user()->can('edit coupons')): ?>
                                <a href="<?php echo e(route('coupons.edit', $coupon->id)); ?>"
                                   class="btn btn-sm btn-info">
                                    Edit
                                </a>
                                <?php endif; ?>
                                <?php if(auth()->user()->can('delete coupons')): ?>
                                <form action="<?php echo e(route('coupons.delete', $coupon->id)); ?>"
                                      method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Delete this coupon?')">
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
                            <td colspan="6" class="text-center">
                                No coupons found
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

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\new travel\resources\views/admin/coupons/index.blade.php ENDPATH**/ ?>