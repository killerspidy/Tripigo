<?php $__env->startSection('title', 'Edit Coupon'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Coupon</h5>
                    <a href="<?php echo e(route('coupons.index')); ?>" class="btn btn-sm btn-secondary">Back</a>
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

                    <form method="POST" action="<?php echo e(route('coupons.update', $coupon->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control"
                                       placeholder="Coupon name"
                                       value="<?php echo e(old('name', $coupon->name)); ?>"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Code <span class="text-danger">*</span></label>
                                <input type="text" name="code"
                                       class="form-control"
                                       placeholder="e.g. SAVE10"
                                       value="<?php echo e(old('code', $coupon->code)); ?>"
                                       required>
                                <small class="form-text text-muted">Unique code customers will enter</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="discount" class="form-control" placeholder="10" step="0.01" min="0" max="999999.99" value="<?php echo e(old('discount', $coupon->discount)); ?>" required>
                                    <select name="discount_type" class="form-control" style="max-width: 120px;">
                                        <option value="fixed" <?php echo e(old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : ''); ?>>Fixed (₹)</option>
                                        <option value="percentage" <?php echo e(old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : ''); ?>>Percentage (%)</option>
                                    </select>
                                </div>
                                <small class="form-text text-muted">Discount value and type</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Minimum Spend Amount (₹)</label>
                                <input type="number" name="min_amount" class="form-control" placeholder="0.00" step="0.01" min="0" value="<?php echo e(old('min_amount', $coupon->min_amount)); ?>">
                                <small class="form-text text-muted">Minimum cart value required to use this coupon</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Expiry Date</label>
                                <input type="date" name="expiry_date" class="form-control" value="<?php echo e(old('expiry_date', $coupon->expiry_date ? $coupon->expiry_date->format('Y-m-d') : '')); ?>">
                                <small class="form-text text-muted">Leave blank for no expiry</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Usage Limit</label>
                                <input type="number" name="usage_limit" class="form-control" placeholder="Unlimited" min="1" value="<?php echo e(old('usage_limit', $coupon->usage_limit)); ?>">
                                <small class="form-text text-muted">Maximum number of times this coupon can be used across all users. Currently used: <?php echo e($coupon->used_count); ?> times.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?php echo e(old('status', $coupon->status) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="status">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Update Coupon</button>
                            <a href="<?php echo e(route('coupons.index')); ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\travel update website\working\resources\views/admin/coupons/edit.blade.php ENDPATH**/ ?>