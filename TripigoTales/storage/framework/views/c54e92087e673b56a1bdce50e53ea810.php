<?php $__env->startSection('title', 'Tasks'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tasks</h5>
            <?php if(auth()->user()->can('create tasks')): ?>
            <a href="<?php echo e(route('tasks.create')); ?>" class="btn btn-primary btn-sm">+ Create Task</a>
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
                            <th>Title</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Created By</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($tasks->firstItem() + $key); ?></td>
                                <td><?php echo e(Str::limit($task->title, 40)); ?></td>
                                <td><?php echo e($task->assignee->name ?? '-'); ?> <small class="text-muted">(<?php echo e($task->assignee->email ?? ''); ?>)</small></td>
                                <td>
                                    <?php if($task->status === 'pending'): ?>
                                        <span class="badge badge-warning">Pending</span>
                                    <?php elseif($task->status === 'in_progress'): ?>
                                        <span class="badge badge-info">In Progress</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">Completed</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($task->due_date ? $task->due_date->format('d M Y') : '-'); ?></td>
                                <td><?php echo e($task->creator->name ?? '-'); ?></td>
                                <td>
                                    <?php if(auth()->user()->can('edit tasks')): ?>
                                    <a href="<?php echo e(route('tasks.edit', $task->id)); ?>" class="btn btn-sm btn-info">Edit</a>
                                    <?php endif; ?>
                                    <?php if(auth()->user()->can('delete tasks')): ?>
                                    <form action="<?php echo e(route('tasks.delete', $task->id)); ?>" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this task?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No tasks found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3"><?php echo e($tasks->links()); ?></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\travel update website\working\resources\views/admin/tasks/index.blade.php ENDPATH**/ ?>