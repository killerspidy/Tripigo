<?php $__env->startSection('title', 'Booking #' . $booking->id); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ─── Page Header ───────────────────────────── */
.booking-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:18px 24px; margin-bottom:24px;
    background:linear-gradient(135deg,#f0f4ff,#fafbff);
    border-radius:12px; border-left:5px solid #4e73df;
}
.booking-header .booking-id { font-size:22px; font-weight:800; color:#2e59d9; }
.booking-header .booking-meta { font-size:13px; color:#718096; }

/* ─── Section Headers ───────────────────────── */
.section-header {
    display:flex; align-items:center; gap:10px;
    padding:10px 16px; margin-bottom:0;
    background:linear-gradient(135deg,#f0f4ff,#fafbff);
    border-left:4px solid #4e73df; border-radius:0 6px 6px 0;
    font-weight:700; font-size:14px; color:#2e59d9;
}
.section-header i { color:#4e73df; font-size:15px; }

/* ─── Status Badges ─────────────────────────── */
.status-badge {
    display:inline-flex; align-items:center; gap:6px;
    padding:6px 16px; border-radius:30px; font-size:13px; font-weight:700;
}
.status-paid     { background:#d4edda; color:#1a7a3c; border:1.5px solid #a3d9b1; }
.status-pending  { background:#fff3cd; color:#856404; border:1.5px solid #ffc840; }
.status-failed   { background:#f8d7da; color:#842029; border:1.5px solid #f5c2c7; }
.status-cancelled{ background:#e2e3e5; color:#495057; border:1.5px solid #c6c8ca; }
.status-refunded { background:#cff4fc; color:#055160; border:1.5px solid #9eeaf9; }
.status-awaiting { background:#fff3cd; color:#856404; border:1.5px solid #ffc840; }

/* ─── Info Grid ─────────────────────────────── */
.info-row { display:flex; border-bottom:1px solid #f1f3f5; padding:10px 0; }
.info-row:last-child { border-bottom:none; }
.info-label { width:180px; flex-shrink:0; font-weight:600; font-size:13px; color:#6b7280; }
.info-value { font-size:13px; color:#1f2937; flex:1; }
code.ref { background:#f0f4ff; color:#3a5fc8; padding:2px 8px; border-radius:4px; font-size:12px; }

/* ─── Traveler Table ────────────────────────── */
.traveler-table th { font-size:12px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:.5px; background:#f9fafb; }
.traveler-table td { font-size:13px; vertical-align:middle; }

/* ─── Pricing ───────────────────────────────── */
.price-row { display:flex; justify-content:space-between; padding:8px 0; font-size:14px; border-bottom:1px solid #f1f3f5; }
.price-row:last-child { border-bottom:none; }
.price-row.total-row { font-weight:800; font-size:16px; color:#2e59d9; padding-top:12px; }
.price-row .label { color:#6b7280; }
.price-row.discount .amount { color:#16a34a; }

/* ─── Sidebar Cards ─────────────────────────── */
.sidebar-card { border:none; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.06); margin-bottom:20px; }
.sidebar-card .card-header { border-radius:12px 12px 0 0 !important; border-bottom:1px solid #f0f0f0; }
@media print {
    .no-print, .btn, .btn-sm, .btn-outline-secondary, .sidebar-card .form-control, .sidebar-card button, .alert, .breadcrumb, footer, header, .sidebar, .left-sidebar {
        display: none !important;
    }
    body {
        background: #fff !important;
        margin: 0 !important;
        padding: 0 !important;
        font-size: 11px !important;
        width: 100% !important;
        min-width: auto !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    .page-wrapper, .main-wrapper, .content-page, .container-fluid {
        margin-left: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-right: 0 !important;
        width: 100% !important;
        min-width: auto !important;
    }
    .row {
        display: block !important;
        width: 100% !important;
        margin: 0 !important;
    }
    .col-lg-8, .col-lg-4 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        padding: 0 !important;
        margin-bottom: 10px !important;
    }
    .card {
        border: 1px solid #eee !important;
        box-shadow: none !important;
        margin-bottom: 10px !important;
    }
    .booking-header {
        border: 1px solid #eee !important;
        background: #f8f9fa !important;
        padding: 10px !important;
        margin-bottom: 10px !important;
    }
    .section-header {
        background: #f8f9fa !important;
        padding: 5px 10px !important;
        margin-bottom: 5px !important;
    }
    .info-row {
        padding: 5px 0 !important;
    }
    .info-label {
        width: 140px !important;
    }
    .price-row {
        padding: 4px 0 !important;
    }
    .price-row.total-row {
        font-size: 14px !important;
    }
    .print-branding {
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        border-bottom: 2px solid #333;
        padding-bottom: 10px;
    }
    @page {
        size: A4;
        margin: 1cm;
    }
}
.print-branding {
    display: none;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $statusClass = match($booking->status) {
        'paid'      => 'status-paid',
        'pending'   => 'status-pending',
        'failed'    => 'status-failed',
        'cancelled' => 'status-cancelled',
        'refunded'  => 'status-refunded',
        'awaiting_refund' => 'status-awaiting',
        default     => 'status-cancelled',
    };
    $statusIcon = match($booking->status) {
        'paid'      => '✅',
        'pending'   => '⏳',
        'failed'    => '❌',
        'cancelled' => '🚫',
        'refunded'  => '↩️',
        'awaiting_refund' => '⚠️',
        default     => '•',
    };

    $firstTraveler = $booking->travelers->first();
    $contactName  = $firstTraveler->name  ?? ($booking->user->name  ?? 'N/A');
    $contactEmail = $firstTraveler->email ?? ($booking->user->email ?? 'N/A');
    $contactPhone = $firstTraveler->phone ?? ($booking->user->phone ?? 'N/A');
?>

<div class="container-fluid pb-5">

    
    <div class="print-branding">
        <div>
            <h2 class="mb-0">TRIPIGO TALES</h2>
            <p class="mb-0 text-muted">Booking Confirmation | Admin Copy</p>
        </div>
        <div class="text-right">
            <p class="mb-0"><strong>Contact:</strong> +91 7743963339</p>
            <p class="mb-0"><strong>Email:</strong> info@tripigotales.com</p>
        </div>
    </div>

    
    <div class="booking-header">
        <div>
            <div class="booking-id">Booking #<?php echo e($booking->id); ?></div>
            <div class="booking-meta">
                <i class="fa fa-clock-o me-1"></i> Booked on <?php echo e($booking->created_at->format('d M Y, h:i A')); ?>

                &nbsp;·&nbsp;
                <i class="fa fa-map-marker me-1"></i> <?php echo e($booking->tour->location ?? 'Tour Deleted'); ?>

            </div>
        </div>
        <div class="d-flex align-items-center gap-3 no-print">
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="fa fa-print me-1"></i> Print
            </button>
            <span class="status-badge <?php echo e($statusClass); ?>">
                <?php echo e($statusIcon); ?> <?php echo e(ucfirst($booking->status)); ?>

            </span>
            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-arrow-left me-1"></i> Back to Bookings
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4">
        <i class="fa fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row g-4">

        
        <div class="col-lg-8">

            
            <div class="card border-0 rounded-3 shadow-sm mb-4">
                <div class="card-body">
                    <div class="section-header mb-3">
                        <i class="fa fa-map-signs"></i> Tour & Travel Information
                    </div>
                    <div class="px-2">
                        <div class="info-row">
                            <span class="info-label">Tour</span>
                            <span class="info-value fw-semibold">
                                <?php echo e($booking->tour->title ?? 'Deleted Tour'); ?>

                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Location</span>
                            <span class="info-value"><?php echo e($booking->tour->location ?? '—'); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Travel Date</span>
                            <span class="info-value">
                                <?php echo e($booking->from_date ? $booking->from_date->format('d M Y') : 'N/A'); ?>

                                <?php if($booking->to_date): ?>
                                    &nbsp;→&nbsp; <?php echo e($booking->to_date->format('d M Y')); ?>

                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Duration</span>
                            <span class="info-value"><?php echo e($booking->days ?? ($booking->tour->tour_duration ?? 'N/A')); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">No. of Persons</span>
                            <span class="info-value">
                                <strong><?php echo e($booking->persons); ?></strong> traveller(s)
                            </span>
                        </div>
                        <?php if($booking->cancelled_at): ?>
                        <div class="info-row mt-3 bg-light p-3 rounded">
                            <span class="info-label text-danger">Cancellation Info</span>
                            <span class="info-value">
                                <div class="text-danger fw-bold">Cancelled on <?php echo e($booking->cancelled_at->format('d M Y, h:i A')); ?></div>
                                <div class="mt-1"><strong>Reason:</strong> <?php echo e($booking->cancellation_reason ?? 'N/A'); ?></div>
                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if($booking->refund_id): ?>
                        <div class="info-row mt-2 bg-light p-3 rounded">
                            <span class="info-label text-info">Refund Info</span>
                            <span class="info-value">
                                <div class="text-info fw-bold">Refund ID: <?php echo e($booking->refund_id); ?></div>
                                <div class="mt-1"><strong>Amount:</strong> ₹<?php echo e(number_format($booking->refund_amount, 2)); ?></div>
                                <div class="mt-1"><strong>Status:</strong> <?php echo e(ucfirst($booking->refund_status)); ?></div>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="card border-0 rounded-3 shadow-sm mb-4">
                <div class="card-body">
                    <div class="section-header mb-3">
                        <i class="fa fa-address-card-o"></i> Primary Contact
                    </div>
                    <div class="px-2">
                        <div class="info-row">
                            <span class="info-label">Name</span>
                            <span class="info-value"><?php echo e($contactName); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-value">
                                <a href="mailto:<?php echo e($contactEmail); ?>"><?php echo e($contactEmail); ?></a>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Phone</span>
                            <span class="info-value">
                                <a href="tel:<?php echo e($contactPhone); ?>"><?php echo e($contactPhone); ?></a>
                            </span>
                        </div>
                        <?php if($booking->user): ?>
                        <div class="info-row">
                            <span class="info-label">Account User</span>
                            <span class="info-value">
                                <?php echo e($booking->user->name); ?>

                                <small class="text-muted">· <?php echo e($booking->user->email); ?></small>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="card border-0 rounded-3 shadow-sm mb-4">
                <div class="card-body">
                    <div class="section-header mb-3">
                        <i class="fa fa-users"></i> Traveller Details (<?php echo e($booking->travelers->count()); ?>)
                    </div>
                    <?php if($booking->travelers->isNotEmpty()): ?>
                        <div class="table-responsive">
                            <table class="table traveler-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Date of Birth</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $booking->travelers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $traveler): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-muted"><?php echo e($i + 1); ?></td>
                                        <td><strong><?php echo e($traveler->name); ?></strong></td>
                                        <td><?php echo e($traveler->dob ? \Carbon\Carbon::parse($traveler->dob)->format('d M Y') : '—'); ?></td>
                                        <td><?php echo e(ucfirst($traveler->gender ?? '—')); ?></td>
                                        <td><?php echo e($traveler->email ?? '—'); ?></td>
                                        <td><?php echo e($traveler->phone ?? '—'); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0 px-2" style="font-size:13px;">
                            <i class="fa fa-info-circle me-1"></i> No individual traveller details were recorded for this booking.
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            
            <?php if($booking->bookingAddons->isNotEmpty()): ?>
            <div class="card border-0 rounded-3 shadow-sm mb-4">
                <div class="card-body">
                    <div class="section-header mb-3">
                        <i class="fa fa-plus-circle"></i> Selected Add-Ons
                    </div>
                    <div class="table-responsive">
                        <table class="table traveler-table mb-0">
                            <thead>
                                <tr>
                                    <th>Add-On</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Unit Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $booking->bookingAddons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ba): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><strong><?php echo e($ba->addon->name ?? 'Unknown Add-On'); ?></strong></td>
                                    <td class="text-center">× <?php echo e($ba->quantity); ?></td>
                                    <td class="text-end">₹<?php echo e(number_format($ba->price / max($ba->quantity, 1), 2)); ?></td>
                                    <td class="text-end fw-semibold">₹<?php echo e(number_format($ba->price, 2)); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            
            <div class="card border-0 rounded-3 shadow-sm mb-4">
                <div class="card-body">
                    <div class="section-header mb-3">
                        <i class="fa fa-credit-card"></i> Payment Breakdown
                    </div>
                    <div class="px-2" style="max-width:420px;">
                        <div class="price-row">
                            <span class="label">
                                Price per Person (₹<?php echo e(number_format($booking->price_per_person, 2)); ?> × <?php echo e($booking->persons); ?>)
                            </span>
                            <span class="amount">₹<?php echo e(number_format($booking->subtotal ?? ($booking->price_per_person * $booking->persons), 2)); ?></span>
                        </div>

                        <?php if($booking->addons_amount > 0): ?>
                        <div class="price-row">
                            <span class="label">Add-Ons</span>
                            <span class="amount">+ ₹<?php echo e(number_format($booking->addons_amount, 2)); ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if($booking->discount_amount > 0): ?>
                        <div class="price-row discount">
                            <span class="label">
                                Discount
                                <?php if($booking->coupon): ?>
                                    <span class="badge" style="background:#dcfce7;color:#16a34a;font-size:11px;padding:2px 8px;border-radius:12px;">
                                        <?php echo e($booking->coupon->code); ?>

                                    </span>
                                <?php endif; ?>
                            </span>
                            <span class="amount">− ₹<?php echo e(number_format($booking->discount_amount, 2)); ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if($booking->gst_amount > 0): ?>
                        <div class="price-row">
                            <span class="label">GST</span>
                            <span class="amount">+ ₹<?php echo e(number_format($booking->gst_amount, 2)); ?></span>
                        </div>
                        <?php endif; ?>

                        <div class="price-row total-row">
                            <span>Total Charged</span>
                            <span>₹<?php echo e(number_format($booking->total_amount, 2)); ?></span>
                        </div>
                    </div>

                    <hr class="my-3">
                    <div class="px-2">
                        <div class="info-row">
                            <span class="info-label">Razorpay Order ID</span>
                            <span class="info-value"><code class="ref"><?php echo e($booking->razorpay_order_id ?? 'N/A'); ?></code></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Razorpay Payment ID</span>
                            <span class="info-value"><code class="ref"><?php echo e($booking->razorpay_payment_id ?? 'N/A'); ?></code></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        
        <div class="col-lg-4">

            
            <div class="sidebar-card card mb-4 no-print">
                <div class="card-header bg-white">
                    <strong style="font-size:14px;"><i class="fa fa-toggle-on me-2 text-primary"></i>Booking Status</strong>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <span class="status-badge <?php echo e($statusClass); ?>" style="font-size:15px;padding:8px 24px;">
                            <?php echo e($statusIcon); ?> <?php echo e(ucfirst($booking->status)); ?>

                        </span>
                    </div>
                    <form action="<?php echo e(route('admin.bookings.updateStatus', $booking->slug)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <select name="status" class="form-control mb-3" style="border-radius:8px;font-size:14px;">
                            <?php $__currentLoopData = ['pending','paid','failed','cancelled','refunded', 'awaiting_refund']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s); ?>" <?php echo e($booking->status === $s ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst(str_replace('_', ' ', $s))); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <button type="submit" class="btn btn-primary w-100"
                                onclick="return confirm('Update booking status?')">
                            <i class="fa fa-save me-1"></i> Update Status
                        </button>
                    </form>

                    <?php if($booking->status === 'awaiting_refund'): ?>
                    <hr>
                    <form action="<?php echo e(route('admin.bookings.refund', $booking->slug)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-success w-100"
                                onclick="return confirm('Initiate Razorpay Refund for ₹<?php echo e(number_format($booking->total_amount, 2)); ?>?')">
                            <i class="fa fa-reply me-1"></i> Process Refund
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="sidebar-card card mb-4">
                <div class="card-header bg-white">
                    <strong style="font-size:14px;"><i class="fa fa-info-circle me-2 text-primary"></i>Quick Summary</strong>
                </div>
                <div class="card-body">
                    <div class="info-row" style="padding:7px 0;">
                        <span class="info-label" style="width:120px;">Booking ID</span>
                        <span class="info-value fw-semibold">#<?php echo e($booking->id); ?></span>
                    </div>
                    <div class="info-row" style="padding:7px 0;">
                        <span class="info-label" style="width:120px;">Booked On</span>
                        <span class="info-value"><?php echo e($booking->created_at->format('d M Y')); ?></span>
                    </div>
                    <div class="info-row" style="padding:7px 0;">
                        <span class="info-label" style="width:120px;">Travel Date</span>
                        <span class="info-value"><?php echo e($booking->from_date?->format('d M Y') ?? 'N/A'); ?></span>
                    </div>
                    <div class="info-row" style="padding:7px 0;">
                        <span class="info-label" style="width:120px;">Persons</span>
                        <span class="info-value"><?php echo e($booking->persons); ?></span>
                    </div>
                    <div class="info-row" style="padding:7px 0;">
                        <span class="info-label" style="width:120px;">Total</span>
                        <span class="info-value fw-bold text-primary">₹<?php echo e(number_format($booking->total_amount, 2)); ?></span>
                    </div>
                </div>
            </div>

            
            <div class="sidebar-card card border-danger no-print">
                <div class="card-header bg-danger text-white">
                    <strong style="font-size:14px;"><i class="fa fa-exclamation-triangle me-2"></i>Danger Zone</strong>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3" style="font-size:12px;">
                        Permanently deletes this booking record. This action cannot be undone.
                    </p>
                    <form action="<?php echo e(route('admin.bookings.destroy', $booking->slug)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-outline-danger w-100"
                                onclick="return confirm('Permanently delete Booking #<?php echo e($booking->id); ?>? This cannot be undone.')">
                            <i class="fa fa-trash me-1"></i> Delete Booking
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\travel update website\working\resources\views/admin/bookings/show.blade.php ENDPATH**/ ?>