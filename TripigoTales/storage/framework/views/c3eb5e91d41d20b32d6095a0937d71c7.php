

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Add-ons Management</h6>
                <a href="<?php echo e(route('addons.create')); ?>" class="btn btn-primary btn-sm">Add New Add-on</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <?php if(session('success')): ?>
                    <div class="alert alert-success mx-4">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Applied To Tours</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm"><?php echo e($addon->name); ?></h6>
                                            <?php if($addon->description): ?>
                                                <p class="text-xs text-secondary mb-0"><?php echo e(Str::limit($addon->description, 50)); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if($addon->tours->isEmpty()): ?>
                                        <span class="badge badge-sm bg-gradient-secondary">Global (All Tours)</span>
                                    <?php else: ?>
                                        <div class="d-flex flex-wrap gap-1">
                                            <?php $__currentLoopData = $addon->tours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge badge-sm bg-gradient-info" title="<?php echo e($tour->title); ?>" style="font-size:10px; padding: 4px 8px;">
                                                    <?php echo e(Str::limit($tour->title, 20)); ?>

                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">₹<?php echo e(number_format($addon->price, 2)); ?></p>
                                </td>
                                <td class="align-middle border-bottom-0">
                                    <a href="<?php echo e(route('addons.edit', $addon->id)); ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit Addon">
                                        Edit
                                    </a> |
                                    <form action="<?php echo e(route('addons.destroy', $addon->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-link text-danger text-gradient px-3 mb-0" onclick="return confirm('Are you sure you want to delete this add-on?')"><i class="far fa-trash-alt me-2"></i>Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\new travel\resources\views/admin/addons/index.blade.php ENDPATH**/ ?>