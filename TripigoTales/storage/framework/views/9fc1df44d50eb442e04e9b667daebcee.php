<?php $__env->startSection('title', 'Tours'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="mb-0">Tours</h5>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-outline-primary btn-sm mr-2" data-toggle="modal" data-target="#exportToursArchiveModal">
                    Export as Archive
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm mr-2" data-toggle="modal" data-target="#importToursArchiveModal">
                    Import from Archive
                </button>
                <?php if(auth()->user()->can('create tours')): ?>
                <a href="<?php echo e(route('tours.create')); ?>" class="btn btn-primary btn-sm">
                    + Tour Create
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-body">
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
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
                            <th>Destination</th>
                            <th>Travel Type</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $tours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($key + 1); ?></td>

                           <td>
                                <?php if($tour->image): ?>
                                    <img src="<?php echo e(asset($tour->image)); ?>" width="60">
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>

                            <td><?php echo e($tour->title); ?></td>

                            <td><?php echo e($tour->category->name ?? '-'); ?></td>

                            <td><?php echo e($tour->subcategory->name ?? '-'); ?></td>

                            <td><?php echo e($tour->location); ?></td>


                            <td>₹ <?php echo e($tour->price); ?></td>

                            <td>
                                <?php if($tour->status): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if(auth()->user()->can('edit tours')): ?>
                                <a href="<?php echo e(route('tours.edit',$tour->slug)); ?>"
                                   class="btn btn-sm btn-info">
                                    Edit
                                </a>
                                <?php endif; ?>
                                <?php if(auth()->user()->can('delete tours')): ?>    
                                <form action="<?php echo e(route('tours.delete',$tour->slug)); ?>"
                                      method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Delete this tour?')">
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
                            <td colspan="10" class="text-center">
                                No tours found
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Export Archive Modal -->
<div class="modal fade" id="exportToursArchiveModal" tabindex="-1" role="dialog" aria-labelledby="exportToursArchiveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportToursArchiveModalLabel">Export Tours as Archive</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Download all tours as a ZIP archive containing <strong>tours.xlsx</strong> and a <strong>media/</strong> folder with main images, PDFs, and gallery images. Use this to backup or migrate tours.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="<?php echo e(route('tours.export-archive')); ?>" class="btn btn-primary">Export Archive</a>
            </div>
        </div>
    </div>
</div>

<!-- Import Archive Modal -->
<div class="modal fade" id="importToursArchiveModal" tabindex="-1" role="dialog" aria-labelledby="importToursArchiveModalLabel" aria-hidden="true">
    <form action="<?php echo e(route('tours.import-archive')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importToursArchiveModalLabel">Import Tours from Archive</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Upload a ZIP archive that was exported from this panel (contains <strong>tours.xlsx</strong> and <strong>media/</strong> folder). Tours and files will be imported.</p>
                    <div class="form-group">
                        <label for="toursArchiveFile">Choose ZIP archive</label>
                        <input type="file" name="archive" id="toursArchiveFile" class="form-control-file" accept=".zip" required>
                        <?php $__errorArgs = ['archive'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import Archive</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Omkar Dhamdhere\Tejas Project Frelance\TripigoTales\resources\views/admin/tours/index.blade.php ENDPATH**/ ?>