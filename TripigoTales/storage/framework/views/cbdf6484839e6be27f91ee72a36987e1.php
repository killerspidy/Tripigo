<?php $__env->startSection('title', 'Booking Management'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ─── Stat Cards ────────────────────────────── */
.stat-card {
    border:none; border-radius:14px; overflow:hidden;
    box-shadow:0 4px 16px rgba(0,0,0,.08); margin-bottom:0;
}
.stat-card .card-body { padding:20px 24px; }
.stat-card .stat-icon {
    width:48px; height:48px; border-radius:12px;
    display:flex; align-items:center; justify-content:center;
    font-size:20px; flex-shrink:0; background:rgba(255,255,255,.25);
}
.stat-card .stat-value { font-size:26px; font-weight:800; color:#fff; line-height:1.1; }
.stat-card .stat-label { font-size:12px; color:rgba(255,255,255,.8); font-weight:500; margin-top:2px; }

/* ─── Table ──────────────────────────────────── */
.bookings-table th {
    font-size:11px; font-weight:700; color:#6b7280;
    text-transform:uppercase; letter-spacing:.5px;
    background:#f9fafb; border-top:none; white-space:nowrap;
}
.bookings-table td { vertical-align:middle; font-size:13px; }
.bookings-table tbody tr:hover { background:#fafbff; }

/* ─── Status Badges ─────────────────────────── */
.s-badge {
    display:inline-block; padding:3px 10px; border-radius:20px;
    font-size:11px; font-weight:700; letter-spacing:.4px;
}
.s-paid     { background:#d4edda; color:#1a7a3c; }
.s-pending  { background:#fff3cd; color:#856404; }
.s-failed   { background:#f8d7da; color:#842029; }
.s-cancelled{ background:#e2e3e5; color:#495057; }
.s-refunded { background:#cff4fc; color:#055160; }

/* ─── Filters Bar ────────────────────────────── */
.filters-bar { background:#f9fafb; border-radius:10px; padding:14px 18px; margin-bottom:20px; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid pb-5">

    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Booking Management</h4>
            <small class="text-muted">All customer tour bookings in one place.</small>
        </div>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card card" style="background:linear-gradient(135deg,#4e73df,#2e59d9);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon">🎟️</div>
                    <div>
                        <div class="stat-value"><?php echo e($stats['total']); ?></div>
                        <div class="stat-label">Total Bookings</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card card" style="background:linear-gradient(135deg,#1cc88a,#17a673);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon">✅</div>
                    <div>
                        <div class="stat-value"><?php echo e($stats['paid']); ?></div>
                        <div class="stat-label">Paid</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card card" style="background:linear-gradient(135deg,#f6c23e,#dda20a);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon">⏳</div>
                    <div>
                        <div class="stat-value"><?php echo e($stats['pending']); ?></div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card card" style="background:linear-gradient(135deg,#36b9cc,#258391);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon">💰</div>
                    <div>
                        <div class="stat-value" style="font-size:20px;">₹<?php echo e(number_format($stats['revenue'], 0)); ?></div>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">

            <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 mb-4">
                <i class="fa fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            
            <div class="filters-bar">
                <form method="GET" action="<?php echo e(route('admin.bookings.index')); ?>">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control form-control-sm"
                                   placeholder="🔍  Search by ID, name, email, Razorpay ID, tour…"
                                   value="<?php echo e(request('search')); ?>" style="border-radius:8px;">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control form-control-sm" style="border-radius:8px;">
                                <option value="">All Statuses</option>
                                <?php $__currentLoopData = ['paid','pending','failed','cancelled','refunded']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s); ?>" <?php echo e(request('status') == $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm w-100" style="border-radius:8px;">Filter</button>
                        </div>
                        <div class="col-md-2">
                            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn btn-outline-secondary btn-sm w-100" style="border-radius:8px;">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            
            <div class="table-responsive">
                <table class="table bookings-table mb-0">
                    <thead>
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>Tour</th>
                            <th>Contact</th>
                            <th>Travel Date</th>
                            <th class="text-center">Persons</th>
                            <th class="text-end">Amount</th>
                            <th class="text-center">Status</th>
                            <th>Booked On</th>
                            <th class="text-center" style="width:120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $trav = $booking->travelers->first();
                            $name  = $trav->name  ?? ($booking->user->name  ?? 'Guest');
                            $phone = $trav->phone ?? ($booking->user->phone ?? null);
                            $email = $trav->email ?? ($booking->user->email ?? null);
                        ?>
                        <tr>
                            <td class="text-muted fw-semibold">#<?php echo e($booking->id); ?></td>
                            <td>
                                <div class="fw-semibold" style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    <?php echo e($booking->tour->title ?? '<span class="text-muted">Deleted Tour</span>'); ?>

                                </div>
                                <small class="text-muted"><?php echo e($booking->tour->location ?? ''); ?></small>
                            </td>
                            <td>
                                <div class="fw-semibold"><?php echo e($name); ?></div>
                                <?php if($phone): ?><small class="text-muted d-block">📞 <?php echo e($phone); ?></small><?php endif; ?>
                                <?php if($email): ?><small class="text-muted d-block">✉ <?php echo e($email); ?></small><?php endif; ?>
                            </td>
                            <td>
                                <div><?php echo e($booking->from_date?->format('d M Y') ?? '—'); ?></div>
                                <?php if($booking->to_date): ?>
                                    <small class="text-muted">→ <?php echo e($booking->to_date->format('d M Y')); ?></small>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="fw-semibold"><?php echo e($booking->persons); ?></span>
                                <?php if($booking->travelers->count() > 0): ?>
                                    <span class="d-block" title="<?php echo e($booking->travelers->count()); ?> traveller details saved"
                                          style="font-size:10px;color:#4e73df;">
                                        👥 <?php echo e($booking->travelers->count()); ?> details
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end fw-bold">₹<?php echo e(number_format($booking->total_amount, 2)); ?></td>
                            <td class="text-center">
                                <?php
                                    $sc = match($booking->status) {
                                        'paid'      => 's-paid',
                                        'pending'   => 's-pending',
                                        'failed'    => 's-failed',
                                        'cancelled' => 's-cancelled',
                                        'refunded'  => 's-refunded',
                                        default     => 's-cancelled',
                                    };
                                ?>
                                <span class="s-badge <?php echo e($sc); ?>"><?php echo e(ucfirst($booking->status)); ?></span>
                            </td>
                            <td>
                                <div style="font-size:12px;"><?php echo e($booking->created_at->format('d M Y')); ?></div>
                                <small class="text-muted"><?php echo e($booking->created_at->format('h:i A')); ?></small>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="<?php echo e(route('admin.bookings.show', $booking->slug)); ?>"
                                       class="btn btn-sm btn-outline-primary" title="View Details"
                                       style="border-radius:6px;padding:4px 10px;">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.bookings.destroy', $booking->slug)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Delete" style="border-radius:6px;padding:4px 10px;"
                                                onclick="return confirm('Delete Booking #<?php echo e($booking->id); ?>?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                                No bookings found matching your filters.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <div class="d-flex justify-content-between align-items-center mt-3 px-1">
                <small class="text-muted">
                    Showing <?php echo e($bookings->firstItem()); ?>–<?php echo e($bookings->lastItem()); ?> of <?php echo e($bookings->total()); ?> bookings
                </small>
                <?php echo e($bookings->links()); ?>

            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Omkar Dhamdhere\Tejas Project Frelance\TripigoTales\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>