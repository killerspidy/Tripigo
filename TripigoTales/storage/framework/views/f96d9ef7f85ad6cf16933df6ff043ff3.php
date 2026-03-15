<?php echo $__env->make('frontend.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>
@media print {
    header, footer, .breadcrumb-main, .dot-overlay, .sidebar-sticky, .nir-btn, .nir-btn-black, .section-shape, .col-lg-4 {
        display: none !important;
    }
    body {
        background: #fff !important;
        margin: 0;
        padding: 0;
        font-size: 12px !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    .bg-lgrey {
        background: #fff !important;
    }
    .container {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .col-lg-8 {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
    .payment-book {
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }
    .booking-box {
        padding: 0 !important;
    }
    .booking-box-title {
        background: #f8f9fa !important;
        color: #000 !important;
        border: 2px solid #000 !important;
        margin-top: 10px !important;
        margin-bottom: 10px !important;
        padding: 15px !important;
    }
    .booking-box-title i {
        padding: 10px !important;
        font-size: 16px !important;
    }
    .booking-box-title i, .booking-box-title h3, .booking-box-title p, .booking-box-title strong {
        color: #000 !important;
    }
    h4 {
        border-bottom: 2px solid #000 !important;
        padding-bottom: 3px !important;
        margin-top: 12px !important;
        margin-bottom: 8px !important;
        font-size: 15px !important;
    }
    table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 15px !important;
    }
    th, td {
        border: 1px solid #dee2e6 !important;
        padding: 5px 10px !important;
        text-align: left !important;
    }
    th {
        background-color: #f8f9fa !important;
        color: #000 !important;
        font-weight: bold !important;
    }
    .badge {
        border: 1px solid #000 !important;
        color: #000 !important;
        background: none !important;
        padding: 2px 5px !important;
    }
    code {
        word-break: break-all !important;
    }
    .print-only {
        display: block !important;
    }
    .mb-4 { margin-bottom: 10px !important; }
    @page {
        size: A4;
        margin: 1cm;
    }
}
.print-only {
    display: none;
}

/* Responsiveness Fixes */
@media (max-width: 991px) {
    .ps-4 {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
    }
    .booking-box-title i {
        margin-bottom: 15px;
    }
}
@media (max-width: 767px) {
    .travellers-info {
        overflow-x: auto;
    }
    .travellers-info table {
        min-width: 600px;
    }
    .booking-box-title h3 {
        font-size: 1.25rem;
    }
}
@media (max-width: 575px) {
    .booking-box {
        padding: 1.5rem !important;
    }
    .nir-btn, .nir-btn-black {
        width: 100%;
        text-align: center;
        margin-bottom: 10px;
    }
    .booking-border.d-flex {
        flex-direction: column;
    }
}
</style>

<div class="print-only text-center mb-4">
    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Tripigo Tales" style="height: 60px;">
    <h2 class="mt-2">Booking Confirmation</h2>
    <hr>
</div>

    <!-- BreadCrumb Starts -->
    <section class="breadcrumb-main pb-20 pt-14" style="background-image: url(<?php echo e(asset('images/bg/bg1.jpg')); ?>);">
        <div class="section-shape section-shape1 top-inherit bottom-0" style="background-image: url(<?php echo e(asset('images/shape8.png')); ?>);"></div>
        <div class="breadcrumb-outer">
            <div class="container">
                <div class="breadcrumb-content text-center">
                    <h1 class="mb-3">Booking Confirmed</h1>
                    <nav aria-label="breadcrumb" class="d-block">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('frontend.tour')); ?>">Tours</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Confirmation</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="dot-overlay"></div>
    </section>
    <!-- BreadCrumb Ends -->

    <!-- Booking Confirmation starts -->
    <section class="trending pt-6 pb-0 bg-lgrey">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-xs-12 mb-4">
                    <div class="payment-book">
                        <div class="booking-box">

                            <!-- Success Banner -->
                            <div class="booking-box-title d-md-flex align-items-center bg-title p-4 mb-4 rounded text-md-start text-center">
                                <i class="fa fa-check px-4 py-3 bg-white rounded title fs-5"></i>
                                <div class="title-content ms-md-3">
                                    <h3 class="mb-1 white">Thank You! Your booking is confirmed.</h3>
                                    <p class="mb-0 white">A confirmation has been sent to <strong><?php echo e($user->email ?? 'your email address'); ?></strong>.</p>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="travellers-info mb-4">
                                <table>
                                    <thead>
                                        <th>Booking ID</th>
                                        <th>Booking Date</th>
                                        <th>Total Paid</th>
                                        <th>Payment Method</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="theme2">#<?php echo e($booking->id); ?></td>
                                            <td class="theme2"><?php echo e($booking->created_at->format('d M Y, h:i A')); ?></td>
                                            <td class="theme2">₹<?php echo e(number_format($booking->total_amount, 2)); ?></td>
                                            <td class="theme2">Razorpay (Online)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Traveller Information -->
                            <div class="travellers-info mb-4">
                                <h4>Traveller Information</h4>
                                <table>
                                    <tr>
                                        <td>Full Name</td>
                                        <td><?php echo e($user->name ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email Address</td>
                                        <td><?php echo e($user->email ?? 'N/A'); ?></td>
                                    </tr>
                                    <?php if($user->phone ?? null): ?>
                                    <tr>
                                        <td>Phone</td>
                                        <td><?php echo e($user->phone); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($user->address ?? null): ?>
                                    <tr>
                                        <td>Address</td>
                                        <td><?php echo e($user->address); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($user->city ?? null): ?>
                                    <tr>
                                        <td>City</td>
                                        <td><?php echo e($user->city); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($user->pincode ?? null): ?>
                                    <tr>
                                        <td>PIN Code</td>
                                        <td><?php echo e($user->pincode); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            </div>

                            <!-- Tour & Booking Details -->
                            <div class="travellers-info mb-4">
                                <h4>Tour Details</h4>
                                <table>
                                    <tr>
                                        <td>Tour</td>
                                        <td><a href="<?php echo e(route('frontend.tour.detail', $tour->slug)); ?>" class="theme"><?php echo e($tour->title); ?></a></td>
                                    </tr>
                                    <?php if($tour->location): ?>
                                    <tr>
                                        <td>Location</td>
                                        <td><?php echo e($tour->location); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td>Travel Dates</td>
                                        <td>
                                            <?php echo e($booking->from_date ? $booking->from_date->format('d M Y') : 'N/A'); ?> 
                                            &ndash; 
                                            <?php echo e($booking->to_date ? $booking->to_date->format('d M Y') : 'N/A'); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Duration</td>
                                        <td><?php echo e($booking->days ? $booking->days . ' ' . Str::plural('Day', $booking->days) : 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>No. of Persons</td>
                                        <td><?php echo e($booking->persons); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Price per Person</td>
                                        <td>₹<?php echo e(number_format($booking->price_per_person, 2)); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Amount</strong></td>
                                        <td><strong>₹<?php echo e(number_format($booking->total_amount, 2)); ?></strong></td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Payment Details -->
                            <div class="booking-border mb-4">
                                <h4 class="border-b pb-2 mb-2">Payment Details</h4>
                                <table class="w-100">
                                    <tr>
                                        <td>Status</td>
                                        <td><span class="badge bg-success text-white px-3 py-1"><?php echo e(ucfirst($booking->status)); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Payment ID</td>
                                        <td><code><?php echo e($booking->razorpay_payment_id); ?></code></td>
                                    </tr>
                                    <tr>
                                        <td>Order ID</td>
                                        <td><code><?php echo e($booking->razorpay_order_id); ?></code></td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Action Buttons -->
                            <div class="booking-border d-flex flex-wrap gap-2">
                                <a href="javascript:window.print();" class="nir-btn"><i class="fa fa-print"></i> Print</a>
                                <a href="<?php echo e(route('frontend.tour.detail', $tour->slug)); ?>" class="nir-btn-black"><i class="fa fa-eye"></i> View Tour</a>
                                <a href="<?php echo e(route('frontend.tour')); ?>" class="nir-btn-black"><i class="fa fa-search"></i> Explore More Tours</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12 mb-4 ps-4">
                    <div class="sidebar-sticky">
                        <div class="list-sidebar">

                            <!-- Tour Card -->
                            <div class="sidebar-item bordernone bg-white rounded box-shadow overflow-hidden mb-4">
                                <?php if($tour->image): ?>
                                    <img src="<?php echo e(asset($tour->image)); ?>" alt="<?php echo e($tour->title); ?>" class="w-100" style="height: 200px; object-fit: cover;">
                                <?php endif; ?>
                                <div class="p-3">
                                    <h5 class="mb-1"><a href="<?php echo e(route('frontend.tour.detail', $tour->slug)); ?>"><?php echo e($tour->title); ?></a></h5>
                                    <?php if($tour->location): ?>
                                        <p class="mb-1 theme"><i class="icon-location-pin"></i> <?php echo e($tour->location); ?></p>
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span><i class="fa fa-calendar"></i> <?php echo e($booking->days ? $booking->days . ' ' . Str::plural('Day', $booking->days) : 'N/A'); ?></span>
                                        <span><i class="fa fa-users"></i> <?php echo e($booking->persons); ?> <?php echo e(Str::plural('Person', $booking->persons)); ?></span>
                                    </div>
                                    <div class="mt-2 pt-2 border-top">
                                        <h5 class="theme mb-0">₹<?php echo e(number_format($booking->total_amount, 2)); ?> <small class="text-muted">Paid</small></h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Help Card -->
                            <div class="sidebar-item bordernone bg-white rounded box-shadow overflow-hidden p-3 mb-4">
                                <h4>Need Booking Help?</h4>
                                <div class="sidebar-module-inner">
                                    <p class="mb-2">Have questions about your booking? We're here to help 24/7.</p>
                                    <ul class="help-list">
                                        <li class="border-b pb-1 mb-1"><span class="font-weight-bold">Phone</span>: +91 7743963339</li>
                                        <li class="border-b pb-1 mb-1"><span class="font-weight-bold">Email</span>: info@tripigotales.com</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Why Book With Us -->
                            <div class="sidebar-item bg-white rounded box-shadow overflow-hidden p-3 mb-4">
                                <h4>Why Book With Us?</h4>
                                <div class="sidebar-module-inner">
                                    <ul class="featured-list-sm">
                                        <li class="border-b pb-2 mb-2">
                                            <h6 class="mb-0">No Hidden Charges</h6>
                                            The price you see is the price you pay — transparent and upfront.
                                        </li>
                                        <li class="border-b pb-2 mb-2">
                                            <h6 class="mb-0">Flexible Cancellation</h6>
                                            Free cancellation up to 48 hours before the tour start date.
                                        </li>
                                        <li class="border-b pb-2 mb-2">
                                            <h6 class="mb-0">Instant Confirmation</h6>
                                            Your booking is confirmed instantly after successful payment.
                                        </li>
                                        <li>
                                            <h6 class="mb-0">Secure Payments</h6>
                                            All payments are processed securely via Razorpay.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Booking Confirmation ends -->

<?php echo $__env->make('frontend.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="<?php echo e(asset('js/jquery-3.5.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/particles.js')); ?>"></script>
<script src="<?php echo e(asset('js/particlerun.js')); ?>"></script>
<script src="<?php echo e(asset('js/plugin.js')); ?>"></script>
<script src="<?php echo e(asset('js/main.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-swiper.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-nav.js')); ?>"></script>
<?php /**PATH C:\Omkar Dhamdhere\Tejas Project Frelance\TripigoTales\resources\views/frontend/bookingSuccess.blade.php ENDPATH**/ ?>