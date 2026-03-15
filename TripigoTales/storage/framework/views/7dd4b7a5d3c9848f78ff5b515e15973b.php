<?php $__env->startSection('title', 'Blogs'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="mb-0">Blogs</h5>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-outline-primary btn-sm mr-2" data-toggle="modal" data-target="#exportArchiveModal">
                    Export as Archive
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm mr-2" data-toggle="modal" data-target="#importArchiveModal">
                    Import from Archive
                </button>
                <?php if(auth()->user()->can('create blogs')): ?>
                <a href="<?php echo e(route('blogs.create')); ?>" class="btn btn-primary btn-sm">
                    + Blog Create
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
                            <th>Author</th>
                            <th>Published Date</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($key + 1); ?></td>

                           <td>
                                <?php if($blog->image): ?>
                                    <img src="<?php echo e(asset($blog->image)); ?>" width="60" height="60" style="object-fit: cover;">
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>

                            <td><?php echo e(Str::limit($blog->title, 50)); ?></td>

                            <td><?php echo e($blog->author ?? '-'); ?></td>

                            <td><?php echo e($blog->published_date ? $blog->published_date->format('Y-m-d') : '-'); ?></td>

                            <td>
                                <?php if($blog->status): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if(auth()->user()->can('edit blogs')): ?>
                                <a href="<?php echo e(route('blogs.edit',$blog->slug)); ?>"
                                   class="btn btn-sm btn-info">
                                    Edit
                                </a>
                                <?php endif; ?>
                                <?php if(auth()->user()->can('delete blogs')): ?>    
                                <form action="<?php echo e(route('blogs.delete',$blog->slug)); ?>"
                                      method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Delete this blog?')">
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
                            <td colspan="7" class="text-center">
                                No blogs found
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
<div class="modal fade" id="exportArchiveModal" tabindex="-1" role="dialog" aria-labelledby="exportArchiveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportArchiveModalLabel">Export Blogs as Archive</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Download all blogs as a ZIP archive containing <strong>blogs.xlsx</strong> and a <strong>media/</strong> folder with blog images. Use this to backup or migrate blogs with their images.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="<?php echo e(route('blogs.export-archive')); ?>" class="btn btn-primary">Export Archive</a>
            </div>
        </div>
    </div>
</div>

<!-- Import Archive Modal -->
<div class="modal fade" id="importArchiveModal" tabindex="-1" role="dialog" aria-labelledby="importArchiveModalLabel" aria-hidden="true">
    <form action="<?php echo e(route('blogs.import-archive')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importArchiveModalLabel">Import Blogs from Archive</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Upload a ZIP archive that was exported from this panel (contains <strong>blogs.xlsx</strong> and <strong>media/</strong> folder). Blogs and images will be imported.</p>
                    <div class="form-group">
                        <label for="archiveFile">Choose ZIP archive</label>
                        <input type="file" name="archive" id="archiveFile" class="form-control-file" accept=".zip" required>
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

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Omkar Dhamdhere\Tejas Project Frelance\TripigoTales\resources\views/admin/blogs/index.blade.php ENDPATH**/ ?>