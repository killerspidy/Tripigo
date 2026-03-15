<?php $__env->startSection('title', 'Edit Gallery'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Gallery Item</h5>
                    <a href="<?php echo e(route('galleries.index')); ?>" class="btn btn-sm btn-secondary">Back</a>
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

                    <form method="POST" action="<?php echo e(route('galleries.update', $gallery->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       value="<?php echo e(old('title', $gallery->title)); ?>"
                                       required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Image</label>
                                <?php if($gallery->image): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo e(asset($gallery->image)); ?>" width="120" height="90" style="object-fit:cover;" class="img-thumbnail">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Leave empty to keep current image.</small>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="<?php echo e(route('galleries.index')); ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\travel update website\working\resources\views/admin/galleries/edit.blade.php ENDPATH**/ ?>