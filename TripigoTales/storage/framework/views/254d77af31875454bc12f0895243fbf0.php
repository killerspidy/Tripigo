<?php echo $__env->make('frontend.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-calendar {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
        border: 1px solid #eee !important;
    }
    .flatpickr-day.selected, .flatpickr-day.selected:hover {
        background: #18a9a1 !important;
        border-color: #18a9a1 !important;
    }
    .flatpickr-day.today {
        border-color: #18a9a1 !important;
        color: #18a9a1 !important;
    }
    .flatpickr-day.today.selected {
        color: #fff !important;
        background: #18a9a1 !important;
    }
    .flatpickr-months .flatpickr-month {
        background: #18a9a1 !important;
        color: #fff !important;
        fill: #fff !important;
    }
    .flatpickr-current-month .flatpickr-monthDropdown-months {
        background: #18a9a1 !important;
    }
    .flatpickr-weekday {
        background: #f8f9fa !important;
        color: #18a9a1 !important;
        font-weight: bold !important;
    }
    #travel_date_display {
        background: #fff;
        cursor: pointer;
        font-weight: 600;
        color: #333;
    }
    .traveler-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .traveler-card:hover {
        box-shadow: 0 6px 12px rgba(0,0,0,0.05);
        border-color: #18a9a1;
    }
    .traveler-card-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #eee;
    }
    .traveler-number {
        background: #18a9a1;
        color: #fff;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        margin-right: 12px;
    }
    .traveler-card-title {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0;
        font-size: 1.1rem;
    }
    .form-label-custom {
        font-size: 0.85rem;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 6px;
        display: block;
    }
    .form-control, .form-select {
        border-radius: 8px !important;
        border: 1px solid #d1d5db !important;
        padding: 10px 15px !important;
        font-size: 0.95rem !important;
        height: auto !important;
        transition: border-color 0.2s, box-shadow 0.2s !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: #18a9a1 !important;
        box-shadow: 0 0 0 3px rgba(24, 169, 161, 0.1) !important;
        outline: none !important;
    }
    .form-control[readonly] {
        background-color: #f3f4f6 !important;
        color: #6b7280 content !important;
        cursor: not-allowed;
    }
    .input-group-text {
        background: #f9fafb !important;
        border: 1px solid #d1d5db !important;
        border-radius: 8px 0 0 8px !important;
        color: #4b5563 !important;
        font-weight: 600 !important;
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
    .input-group .form-control {
        border-radius: 0 8px 8px 0 !important;
    }
    .theme-prefix {
        background: #18a9a1 !important;
        color: #fff !important;
        border-color: #18a9a1 !important;
    }
    #total_amount {
        background: #ecfdf5 !important;
        color: #065f46 !important;
        border: 1px solid #a7f3d0 !important;
        font-size: 1.2rem !important;
        padding: 12px !important;
    }
    .traveler-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .traveler-card:hover {
        border-color: #18a9a1;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .traveler-card-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f3f4f6;
    }
    .mobile-sticky-footer {
        position: fixed;
        bottom: -100px;
        left: 0;
        right: 0;
        background: #fff;
        padding: 12px 20px;
        box-shadow: 0 -5px 20px rgba(0,0,0,0.15);
        z-index: 1000;
        transition: bottom 0.4s ease-in-out;
        display: none;
    }
    .mobile-sticky-footer.show {
        bottom: 0;
    }
    @media (max-width: 991px) {
        .mobile-sticky-footer {
            display: flex !important;
        }
    }
    
    /* Add-on Quantity Selector Styles */
    .addon-qty-group {
        display: flex !important;
        align-items: center !important;
        background: #fff !important;
        border: 2px solid #18a9a1 !important;
        border-radius: 8px !important;
        overflow: hidden !important;
        height: 36px !important;
        max-height: 36px !important;
        box-shadow: 0 2px 4px rgba(24, 169, 161, 0.1) !important;
        width: 110px !important;
        min-width: 110px !important;
        max-width: 110px !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .addon-qty-btn {
        background: #18a9a1 !important;
        border: none !important;
        color: #fff !important;
        width: 32px !important;
        min-width: 32px !important;
        max-width: 32px !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        transition: all 0.2s !important;
        font-weight: bold !important;
        font-size: 1.2rem !important;
        padding: 0 !important;
        margin: 0 !important;
        line-height: 1 !important;
    }
    .addon-qty-btn:hover {
        background: #148e87 !important;
        color: #fff !important;
    }
    .addon-qty-input {
        width: 42px !important;
        min-width: 42px !important;
        max-width: 42px !important;
        border: none !important;
        text-align: center !important;
        font-size: 1rem !important;
        font-weight: 700 !important;
        padding: 0 !important;
        margin: 0 !important;
        color: #2c3e50 !important;
        -moz-appearance: textfield !important;
        background: transparent !important;
        box-shadow: none !important;
        height: 100% !important;
    }
    .addon-qty-input::-webkit-outer-spin-button,
    .addon-qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
        margin: 0 !important;
    }
</style>

  <!-- BreadCrumb Starts -->
    <section class="breadcrumb-main pb-20 pt-14" style="background-image: url(<?php echo e(asset('images/bg/bg1.jpg')); ?>);">
        <div class="section-shape section-shape1 top-inherit bottom-0" style="background-image: url(<?php echo e(asset('images/shape8.png')); ?>);"></div>
        <div class="breadcrumb-outer">
            <div class="container">
                <div class="breadcrumb-content text-center">
               
                    <nav aria-label="breadcrumb" class="d-block">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                        
                            <li class="breadcrumb-item active" aria-current="page">Booking</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="dot-overlay"></div>
    </section>
    <!-- BreadCrumb Ends -->

    <!-- Booking Section starts -->
    <section class="trending pt-6 pb-0 bg-lgrey">
        <div class="container">
            <div class="row flex-column-reverse flex-lg-row">
                <div class="col-lg-8 mb-4">
                    <div class="payment-book">
                        <div class="booking-box">

                            <!-- Flash / JS Messages -->

                            <div id="booking-messages" class="alert" style="display:none;"></div>

                            <?php if(session('error')): ?>
                                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                            <?php endif; ?>
                            <?php if(session('success')): ?>
                                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                            <?php endif; ?>

                            <div class="customer-information mb-4">
                                <h3 class="border-b pb-2 mb-2">Traveller Information</h3>
                                <form id="tour-booking-form" class="mb-2">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="tour_id" value="<?php echo e($tour->id); ?>">
                                    <h5 class="mb-4 text-primary"><i class="fa fa-info-circle"></i> Let us know who you are</h5>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label-custom">Full Name</label>
                                                <input type="text" name="name" value="<?php echo e($user->name ?? ''); ?>" placeholder="Full Name" readonly class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label-custom">Email</label>
                                                <input type="email" name="email" value="<?php echo e($user->email ?? ''); ?>" placeholder="Email Address" readonly class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label-custom">Phone Number <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text theme-prefix">+91</span>
                                                    <input type="tel" id="placeholder_main_phone" name="phone"
                                                        value="<?php echo e(preg_replace('/^(\+91|91|0)/', '', $user->phone ?? '')); ?>"
                                                        placeholder="10-digit mobile number"
                                                        maxlength="10"
                                                        pattern="[0-9]{10}"
                                                        required
                                                        class="form-control"
                                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,10);">
                                                </div>
                                                <small class="text-muted mt-1 d-block">Enter 10-digit mobile number.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label-custom">Travel Date <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fa fa-calendar-alt text-theme"></i></span>
                                                    <input type="text" id="travel_date_display" class="form-control" placeholder="Select Date" readonly required>
                                                </div>
                                                <input type="hidden" id="from_date" name="from_date" value="<?php echo e($tour->friday_date); ?>">
                                                <input type="hidden" id="to_date" name="to_date">
                                                <input type="hidden" id="days" name="days" value="<?php echo e((int)$tour->tour_duration); ?>">
                                                <small class="text-muted mt-1 d-block">Pick your preferred departure date.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label-custom">No. of Persons <span class="text-danger">*</span></label>
                                                <select id="persons" name="persons" required class="form-select">
                                                    <option value="">Select Persons</option>
                                                    <?php for($p = 1; $p <= min(10, $tour->max_people ?? 10); $p++): ?>
                                                        <option value="<?php echo e($p); ?>"><?php echo e($p); ?> <?php echo e($p == 1 ? 'Person' : 'Persons'); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <label class="form-label-custom">Total Amount (₹)</label>
                                                <input type="text" id="total_amount" name="total_amount" readonly class="form-control fw-bold" style="color: #18a9a1 !important; font-size: 1.1rem !important; background-color: #f0fdf4 !important;" value="Calculated Dynamically">
                                            </div>
                                        </div>
                                    </div>

                                    <div id="dynamic-travelers-container" class="mt-3">
                                        <!-- Dynamic traveler fields will be appended here via JS -->
                                    </div>

                                    <?php if(isset($addons) && $addons->count() > 0): ?>
                                    <h5 class="mt-4 border-t pt-3">Optional Add-ons</h5>
                                    <div class="row" id="addons-container">
                                        <?php $__currentLoopData = $addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-12 mb-2">
                                                <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded border">
                                                    <div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input addon-checkbox" type="checkbox" id="addon_<?php echo e($addon->id); ?>" value="<?php echo e($addon->id); ?>" data-price="<?php echo e($addon->price); ?>">
                                                            <label class="form-check-label fw-bold" for="addon_<?php echo e($addon->id); ?>">
                                                                <?php echo e($addon->name); ?> <span class="text-success ms-1">(+₹<?php echo e(number_format($addon->price, 0)); ?>)</span>
                                                            </label>
                                                        </div>
                                                        <?php if($addon->description): ?>
                                                            <small class="text-muted d-block ms-4" style="line-height: 1.2;"><?php echo e($addon->description); ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="addon-qty-container ms-2" style="display:none; flex-shrink: 0;">
                                                        <div class="addon-qty-group">
                                                            <button type="button" class="addon-qty-btn minus-btn" data-id="<?php echo e($addon->id); ?>">-</button>
                                                            <input type="number" class="addon-qty-input addon-qty" name="addons[<?php echo e($index); ?>][quantity]" min="1" value="1" data-id="<?php echo e($addon->id); ?>" readonly>
                                                            <button type="button" class="addon-qty-btn plus-btn" data-id="<?php echo e($addon->id); ?>">+</button>
                                                        </div>
                                                        <input type="hidden" name="addons[<?php echo e($index); ?>][id]" value="<?php echo e($addon->id); ?>" class="addon-id-input" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php endif; ?>
                                    <input type="hidden" name="coupon" id="applied_coupon_input" value="">
                                </form>
                            </div>

                            <div class="customer-information mb-4 d-flex align-items-center bg-grey rounded p-3">
                                <i class="fa fa-grin-wink rounded fs-1 bg-theme white p-3"></i>
                                <div class="customer-info ps-3">
                                    <h6 class="mb-1">Good To Know:</h6>
                                    <small>Free cancellation up to 48 hours before the tour start date.</small>
                                </div>
                            </div>

                            <!-- Mobile Price Summary Card -->
                            <div class="customer-information mb-4 d-block d-lg-none bg-white rounded border p-3">
                                <h4 class="border-b pb-2 mb-3">Price Summary</h4>
                                <table class="w-100 mb-3">
                                    <tbody>
                                        <tr>
                                            <td class="py-1">Price per person</td>
                                            <td class="theme2 text-end py-1">₹<?php echo e(number_format($tour->price, 2)); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">Number of Travellers</td>
                                            <td class="theme2 text-end py-1 sidebar-persons">-</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1"><i class="fa fa-calendar-check theme"></i> Selected Date</td>
                                            <td class="theme2 text-end py-1 fw-bold sidebar-dates">-</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">Base Subtotal</td>
                                            <td class="theme2 text-end py-1 sidebar-subtotal"><strong>-</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">Add-ons Amount</td>
                                            <td class="theme2 text-end py-1 sidebar-addons-amount"><strong>-</strong></td>
                                        </tr>
                                        <tr class="sidebar-discount-row" style="display:none;">
                                            <td class="py-1 text-success">Discount Applied</td>
                                            <td class="text-success text-end py-1 sidebar-discount-amount"><strong>-</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">GST (5%)</td>
                                            <td class="theme2 text-end py-1 sidebar-gst-amount"><strong>-</strong></td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="bg-title">
                                        <tr>
                                            <th class="font-weight-bold white p-2">Amount to Pay</th>
                                            <th class="font-weight-bold white text-end p-2 sidebar-amount">₹0.00</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="bg-light rounded p-2 border">
                                    <h6 class="mb-2" style="font-size: 0.9rem;">Have a Promo Code?</h6>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control border coupon_code" placeholder="Enter code">
                                        <button type="button" class="btn btn-dark text-white apply-coupon-btn px-3">Apply</button>
                                    </div>
                                    <small class="d-block mt-1 coupon-message"></small>
                                </div>
                            </div>

                            <div class="customer-information card-information">
                                <h3 class="border-b pb-2 mb-2">Payment</h3>
                                <p class="mb-3 text-muted">Click the button below to proceed with secure payment via Razorpay.</p>
                                <div class="booking-terms border-t pt-3 mt-3">
                                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                                        <div class="form-group mb-3 mb-lg-0 w-100 pe-lg-3">
                                            <input type="checkbox" id="terms-agree" class="me-1">
                                            <small class="text-muted">By continuing, you agree to the
                                            <a href="<?php echo e(route('frontend.terms.and.conditions')); ?>" class="text-theme fw-semibold">Terms</a> and
                                            <a href="<?php echo e(route('frontend.cancellation.policy')); ?>" class="text-theme fw-semibold">Cancellation Policy</a>.</small>
                                        </div>
                                        <button type="button" id="pay-with-razorpay" class="nir-btn w-100 py-3 py-lg-2 d-none d-lg-block" style="max-width: 250px;" disabled>PAY NOW</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4 ps-ld-4">
                    <div class="sidebar-sticky">

                        <!-- Tour Details Card -->
                        <div class="sidebar-item bg-white rounded box-shadow overflow-hidden p-3 mb-4">
                            <h4>Your Booking Details</h4>
                            <div class="trend-full border-b pb-2 mb-2">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                       <div class="trend-item2 rounded">
                                            <a href="<?php echo e(route('frontend.tour.detail', $tour->slug)); ?>" style="background-image: url(<?php echo e($tour->image ? asset($tour->image) : asset('images/destination/destination17.jpg')); ?>);"></a>
                                             <div class="color-overlay"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-8 ps-0">
                                        <div class="trend-content position-relative">
                                            <div class="rating mb-1">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <span class="fa fa-star <?php echo e($i <= round($avgRating) ? 'checked' : ''); ?>"></span>
                                                <?php endfor; ?>
                                                <small><?php echo e($reviewCount); ?> <?php echo e(Str::plural('Review', $reviewCount)); ?></small>
                                            </div>
                                            <h5 class="mb-1"><a href="<?php echo e(route('frontend.tour.detail', $tour->slug)); ?>"><?php echo e($tour->title); ?></a></h5>
                                            <h6 class="theme mb-0"><i class="icon-location-pin"></i> <?php echo e($tour->location ?? 'N/A'); ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if($tour->category): ?>
                                <div class="mb-1"><small><i class="fa fa-tag"></i> <?php echo e($tour->category->name); ?></small></div>
                            <?php endif; ?>
                            <?php if($tour->tour_duration || $tour->day): ?>
                                <div class="mb-1"><small><i class="fa fa-clock"></i> Duration: <?php echo e($tour->tour_duration ?? (is_array($tour->day) ? count($tour->day) : $tour->day)); ?> Days</small></div>
                            <?php endif; ?>
                            <?php if($tour->max_people): ?>
                                <div class="mb-1"><small><i class="fa fa-users"></i> Max People: <?php echo e($tour->max_people); ?></small></div>
                            <?php endif; ?>
                            <?php if($tour->pickup): ?>
                                <div class="mb-1"><small><i class="fa fa-map-marker-alt"></i> Pickup: <?php echo e($tour->pickup); ?></small></div>
                            <?php endif; ?>
                            <?php if($tour->departure_time): ?>
                                <div class="mb-1"><small><i class="fa fa-plane-departure"></i> Departure: <?php echo e($tour->departure_time); ?></small></div>
                            <?php endif; ?>
                            <?php if($tour->language): ?>
                                <div class="mb-1"><small><i class="fa fa-language"></i> Language: <?php echo e($tour->language); ?></small></div>
                            <?php endif; ?>
                        </div>

                        <!-- Price Summary Card -->
                        <div class="sidebar-item bg-white rounded box-shadow overflow-hidden p-3 mb-4 d-none d-lg-block">
                            <h4>Price Summary</h4>
                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <td class="py-1">Price per person</td>
                                        <td class="theme2 text-end py-1">₹<?php echo e(number_format($tour->price, 2)); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">Number of Travellers</td>
                                        <td class="theme2 text-end py-1 sidebar-persons">-</td>
                                    </tr>
                                    <tr>
                                        <td class="py-1"><i class="fa fa-calendar-check theme"></i> Selected Date</td>
                                        <td class="theme2 text-end py-1 fw-bold sidebar-dates">-</td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">Base Subtotal</td>
                                        <td class="theme2 text-end py-1 sidebar-subtotal"><strong>-</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">Add-ons Amount</td>
                                        <td class="theme2 text-end py-1 sidebar-addons-amount"><strong>-</strong></td>
                                    </tr>
                                    <tr class="sidebar-discount-row" style="display:none;">
                                        <td class="py-1 text-success">Discount Applied</td>
                                        <td class="text-success text-end py-1 sidebar-discount-amount"><strong>-</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">GST (5%)</td>
                                        <td class="theme2 text-end py-1 sidebar-gst-amount"><strong>-</strong></td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-title">
                                    <tr>
                                        <th class="font-weight-bold white p-2">Amount to Pay</th>
                                        <th class="font-weight-bold white text-end p-2 sidebar-amount">₹0.00</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="sidebar-item bg-white rounded box-shadow overflow-hidden p-3 mt-3 border">
                                <h6>Have a Promo Code?</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control border coupon_code" placeholder="Enter code">
                                    <button type="button" class="btn btn-dark text-white apply-coupon-btn">Apply</button>
                                </div>
                                <small class="d-block mt-2 coupon-message"></small>
                            </div>
                        </div>

                        <?php if($tour->discount_status && $tour->special_discount > 0): ?>
                        <!-- Discount Card -->
                        <div class="sidebar-item bg-white rounded box-shadow overflow-hidden p-3 mb-4">
                            <h4 class="text-success"><i class="fa fa-tag"></i> Special Offer</h4>
                            <p class="mb-0"><?php echo e($tour->special_discount); ?>% discount available on this tour!</p>
                        </div>
                        <?php endif; ?>

                        <!-- Help Card -->
                        <div class="sidebar-item bg-white rounded box-shadow overflow-hidden p-3">
                            <h4>Need Help?</h4>
                            <p class="mb-1"><i class="fa fa-phone"></i> +91 7743963339</p>
                            <p class="mb-0"><i class="fa fa-envelope"></i> info@tripigotales.com</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Booking Section ends -->

    <!-- Mobile Sticky Footer for Payment -->
    <div class="mobile-sticky-footer d-flex justify-content-between align-items-center border-top">
        <div>
            <small class="text-muted d-block" style="font-size: 0.75rem;">Amount to Pay</small>
            <span class="fw-bold fs-5 text-theme sidebar-amount">₹0.00</span>
        </div>
        <button type="button" id="pay-with-razorpay-mobile" class="nir-btn py-2 px-4 shadow-sm" disabled>PAY NOW</button>
    </div>

<?php echo $__env->make('frontend.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="<?php echo e(asset('js/jquery-3.5.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/particles.js')); ?>"></script>
<script src="<?php echo e(asset('js/particlerun.js')); ?>"></script>
<script src="<?php echo e(asset('js/plugin.js')); ?>"></script>
<script src="<?php echo e(asset('js/main.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-swiper.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-nav.js')); ?>"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
(function () {
    const bookingForm = document.getElementById('tour-booking-form');
    let debounceTimer;

    const fromInput = document.getElementById('from_date');
    const toInput = document.getElementById('to_date');
    const personsInput = document.getElementById('persons');
    const daysInput = document.getElementById('days');
    const messagesBox = document.getElementById('booking-messages');
    const payButton = document.getElementById('pay-with-razorpay');
    const termsCheckbox = document.getElementById('terms-agree');

    const sidebarPersons = document.querySelectorAll('.sidebar-persons');
    const sidebarDates = document.querySelectorAll('.sidebar-dates');
    
    // New Calculation UI elements inside the DOM
    const totalInput = document.getElementById('total_amount'); // Readonly form input

    // Coupon UI
    const appliedCouponInput = document.getElementById('applied_coupon_input');
    const applyCouponBtns = document.querySelectorAll('.apply-coupon-btn');
    const couponMessages = document.querySelectorAll('.coupon-message');

    // Addons UI
    const addonCheckboxes = document.querySelectorAll('.addon-checkbox');
    const addonQtyInputs = document.querySelectorAll('.addon-qty');

    termsCheckbox.addEventListener('change', function () {
        payButton.disabled = !this.checked;
        const mobilePayBtn = document.getElementById('pay-with-razorpay-mobile');
        if (mobilePayBtn) mobilePayBtn.disabled = !this.checked;
    });

    function showMessage(type, text) {
        messagesBox.style.display = 'block';
        messagesBox.className = 'alert alert-' + type;
        messagesBox.innerText = text;
        window.scrollTo({ top: messagesBox.offsetTop - 100, behavior: 'smooth' });
    }

    function hideMessage() {
        messagesBox.style.display = 'none';
        messagesBox.className = '';
        messagesBox.innerText = '';
    }

    function formatDate(dateStr) {
        if (!dateStr) return '';
        var d = new Date(dateStr);
        return d.toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
    }

    // Handle Addon Checkbox toggles
    addonCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const container = this.closest('.d-flex').querySelector('.addon-qty-container');
            const hiddenIdInput = container.querySelector('.addon-id-input');
            const qtyInput = container.querySelector('.addon-qty');
            if (this.checked) {
                container.style.display = 'block';
                hiddenIdInput.disabled = false;
                qtyInput.disabled = false;
            } else {
                container.style.display = 'none';
                hiddenIdInput.disabled = true;
                qtyInput.disabled = true;
            }
            triggerCalculatePrice();
        });
    });

    // Handle Addon Qty Changes
    document.querySelectorAll('.minus-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentNode.querySelector('.addon-qty-input');
            let val = parseInt(input.value);
            if (val > 1) {
                input.value = val - 1;
                triggerCalculatePrice();
            }
        });
    });

    document.querySelectorAll('.plus-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentNode.querySelector('.addon-qty-input');
            let val = parseInt(input.value);
            input.value = val + 1;
            triggerCalculatePrice();
        });
    });

    // Handle Traveler Changes (Dynamic Fields)
    personsInput.addEventListener('change', function() {
        const persons = parseInt(this.value || '0', 10);
        sidebarPersons.forEach(el => el.innerText = persons > 0 ? persons : '-');
        
        const container = document.getElementById('dynamic-travelers-container');
        container.innerHTML = ''; // Clear existing

        if (persons > 0) {
            let html = '<h5 class="mb-4 text-primary"><i class="fa fa-users"></i> Traveller Information</h5>';
            html += '<div class="row g-4">';
            for(let i = 0; i < persons; i++) {
                html += `
                    <div class="col-lg-6 col-md-12">
                        <div class="traveler-card h-100">
                            <div class="traveler-card-header">
                                <span class="traveler-number">${i+1}</span>
                                <h6 class="traveler-card-title">Traveller ${i+1}</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label-custom">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="travelers[${i}][name]" class="form-control" required placeholder="Enter full name" oninput="this.value=this.value.replace(/[^a-zA-Z\\s]/g,'')">
                                </div>
                                <div class="col-12">
                                    <label class="form-label-custom">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="travelers[${i}][email]" class="form-control" required placeholder="email@example.com">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label-custom">Gender <span class="text-danger">*</span></label>
                                    <select name="travelers[${i}][gender]" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label-custom">DOB <span class="text-danger">*</span></label>
                                    <div class="input-group dob-picker-container">
                                        <span class="input-group-text" data-toggle style="cursor:pointer; background:#f9fafb;"><i class="fa fa-calendar-alt text-theme"></i></span>
                                        <input type="text" name="travelers[${i}][dob]" class="form-control dob-picker" required placeholder="Select" data-input readonly style="background:#fff !important;">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-custom">Phone Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text theme-prefix">+91</span>
                                        <input type="tel" name="travelers[${i}][phone]" class="form-control" required placeholder="10-digit number" pattern="[0-9]{10}" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,10);">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
            html += '</div>';
            container.innerHTML = html;

            // Initialize DOB pickers for each traveler
            flatpickr(".dob-picker-container", {
                wrap: true,
                clickOpens: true,
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                maxDate: "today",
                defaultDate: null
            });
        }
        triggerCalculatePrice();
    });

    // Date Logic
    function updateDays() {
        const fromVal = fromInput.value;
        const toVal = toInput.value;
        if (fromVal && toVal) {
            const fromDate = new Date(fromVal);
            const toDate = new Date(toVal);
            const diffMs = toDate - fromDate;
            if (diffMs < 0) {
                showMessage('danger', 'To date must be after or equal to from date.');
                daysInput.value = '';
                sidebarDates.forEach(el => el.innerText = '-');
                return;
            }
            const days = Math.floor(diffMs / (1000 * 60 * 60 * 24)) + 1;
            daysInput.value = days;
            if (fromVal === toVal || days === 1) {
                sidebarDates.forEach(el => el.innerText = formatDate(fromVal));
            } else {
                sidebarDates.forEach(el => el.innerText = formatDate(fromVal) + ' – ' + formatDate(toVal));
            }
        } else if (fromVal) {
            sidebarDates.forEach(el => el.innerText = formatDate(fromVal));
            daysInput.value = '';
        } else {
            sidebarDates.forEach(el => el.innerText = '-');
            daysInput.value = '';
        }
    }
    fromInput.addEventListener('change', updateDays);
    toInput.addEventListener('change', updateDays);

    // Multiple Coupon logic
    applyCouponBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const container = this.closest('.input-group');
            const codeInput = container.querySelector('.coupon_code');
            const code = codeInput.value.trim();
            
            if(!code) {
                couponMessages.forEach(msg => {
                    msg.className = 'd-block mt-2 text-danger coupon-message';
                    msg.innerText = 'Please enter a coupon code.';
                });
                return;
            }
            appliedCouponInput.value = code;
            couponMessages.forEach(msg => {
                msg.className = 'd-block mt-2 text-info coupon-message';
                msg.innerText = 'Verifying coupon...';
            });
            
            // Sync all inputs so they show the same text
            document.querySelectorAll('.coupon_code').forEach(input => {
                if (input !== codeInput) input.value = code;
            });

            triggerCalculatePrice(true);
        });
    });

    // AJAX Pricing Calculation Function
    function triggerCalculatePrice(isCouponAction = false) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const persons = parseInt(personsInput.value || '0', 10);
            if (persons <= 0) return; // Wait until persons is selected

            const formData = new FormData(bookingForm);
            
            fetch("<?php echo e(route('booking.calculate.price')); ?>", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const p = data.pricing;
                    document.querySelectorAll('.sidebar-subtotal').forEach(el => el.innerHTML = '<strong>₹' + p.subtotal.toFixed(2) + '</strong>');
                    document.querySelectorAll('.sidebar-addons-amount').forEach(el => el.innerHTML = '<strong>₹' + p.addons_amount.toFixed(2) + '</strong>');
                    
                    if (p.discount_amount > 0) {
                        document.querySelectorAll('.sidebar-discount-row').forEach(el => el.style.display = 'table-row');
                        document.querySelectorAll('.sidebar-discount-amount').forEach(el => el.innerHTML = '<strong>-₹' + p.discount_amount.toFixed(2) + '</strong>');
                        if(isCouponAction) {
                            couponMessages.forEach(msg => {
                                msg.className = 'd-block mt-2 text-success fw-bold coupon-message';
                                msg.innerText = 'Coupon applied successfully!';
                            });
                        }
                    } else {
                        document.querySelectorAll('.sidebar-discount-row').forEach(el => el.style.display = 'none');
                        if(isCouponAction) {
                            couponMessages.forEach(msg => {
                                msg.className = 'd-block mt-2 text-danger coupon-message';
                                msg.innerText = 'Coupon invalid, expired, or requirements not met.';
                            });
                            appliedCouponInput.value = ''; // Reset invalid coupon
                            document.querySelectorAll('.coupon_code').forEach(input => input.value = ''); // clear inputs
                        } else if(appliedCouponInput.value) {
                             // Coupon was applied but requirements suddenly didn't match (e.g. quantity changed dropping price below min)
                             couponMessages.forEach(msg => {
                                 msg.className = 'd-block mt-2 text-warning coupon-message';
                                 msg.innerText = 'Coupon criteria no longer met.';
                             });
                             appliedCouponInput.value = ''; 
                             document.querySelectorAll('.coupon_code').forEach(input => input.value = ''); // clear inputs
                        }
                    }

                    document.querySelectorAll('.sidebar-gst-amount').forEach(el => el.innerHTML = '<strong>₹' + p.gst_amount.toFixed(2) + '</strong>');
                    document.querySelectorAll('.sidebar-amount').forEach(el => el.innerHTML = '₹' + p.final_total.toFixed(2));
                    
                    totalInput.value = p.final_total.toFixed(2); // Readonly form input display update
                }
            }).catch(err => {
                console.error("Pricing Calculation Error: ", err);
            });
        }, 400); // 400ms debounce
    }

    // Initialize Flatpickr for Travel Date
    <?php
        $scheduleType  = $tour->schedule_type  ?? 'weekly';
        $scheduleDays  = is_array($tour->schedule_days)  ? $tour->schedule_days  : [5];
        $specificDates = is_array($tour->specific_dates) ? $tour->specific_dates : [];
        $blockedDates  = is_array($tour->available_dates) ? $tour->available_dates : [];
    ?>

    const scheduleType  = <?php echo json_encode($scheduleType, 15, 512) ?>;
    const scheduleDays  = <?php echo json_encode($scheduleDays, 15, 512) ?>;
    const specificDates = <?php echo json_encode($specificDates, 15, 512) ?>;
    const blockedDates  = <?php echo json_encode($blockedDates, 15, 512) ?>;

    // Build enabled date list based on schedule type
    function getEnabledDates() {
        const today   = new Date();
        today.setHours(0,0,0,0);
        const endDate = new Date();
        endDate.setMonth(endDate.getMonth() + 6);

        if (scheduleType === 'specific') {
            // Only the admin-defined dates, minus blocked ones
            return specificDates.filter(d => !blockedDates.includes(d));
        }

        if (scheduleType === 'open') {
            // All future dates are allowed — return null (flatpickr handles it via minDate)
            return null;
        }

        // 'weekly' — build all matching weekdays for next 6 months
        const enabled = [];
        let cursor = new Date(today);
        while (cursor <= endDate) {
            const dow = cursor.getDay();
            if (scheduleDays.includes(dow)) {
                const y = cursor.getFullYear();
                const m = String(cursor.getMonth() + 1).padStart(2, '0');
                const d = String(cursor.getDate()).padStart(2, '0');
                const dateStr = `${y}-${m}-${d}`;
                if (!blockedDates.includes(dateStr)) {
                    enabled.push(dateStr);
                }
            }
            cursor.setDate(cursor.getDate() + 1);
        }
        return enabled;
    }

    const enabledDates = getEnabledDates();

    // Build Flatpickr config dynamically
    const calendarConfig = {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        minDate: "today",
        onChange: function(selectedDates, dateStr) {
            fromInput.value = dateStr;
            updateDays();
            triggerCalculatePrice();
        }
    };

    if (scheduleType === 'open') {
        // Block specific closed dates
        if (blockedDates.length) calendarConfig.disable = blockedDates;
    } else {
        // enable-list for weekly or specific
        calendarConfig.enable = enabledDates;
    }

    const travelDatePicker = flatpickr("#travel_date_display", calendarConfig);

    // Auto-select first enabled date
    if (enabledDates && enabledDates.length > 0) {
        travelDatePicker.setDate(enabledDates[0], true);
        fromInput.value = enabledDates[0];
        updateDays();
        triggerCalculatePrice();
    }

    // Razorpay Submit Logic
    function setPayButtonsState(disabled, text) {
        document.querySelectorAll('#pay-with-razorpay, #pay-with-razorpay-mobile').forEach(btn => {
            btn.disabled = disabled;
            if (text) btn.innerText = text;
        });
    }

    document.querySelectorAll('#pay-with-razorpay, #pay-with-razorpay-mobile').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            hideMessage();
            if (!termsCheckbox.checked) {
                showMessage('danger', 'Please agree to the Terms and Conditions.');
                return;
            }
            if (!personsInput.value) {
                showMessage('danger', 'Please select the number of persons.');
                return;
            }
            
            // Validate dynamically created traveler fields
            let travelersValid = true;
            const requiredTravelerFields = document.querySelectorAll('#dynamic-travelers-container input[required]');
            requiredTravelerFields.forEach(field => {
                if(!field.value.trim()) travelersValid = false;
            });
            if(!travelersValid) {
                showMessage('danger', 'Please fill out all required Traveler details.');
                return;
            }

            var phoneField = document.getElementById('placeholder_main_phone');
            if (!phoneField || phoneField.value.trim().length !== 10) {
                showMessage('danger', 'Please enter a valid 10-digit phone number.');
                return;
            }
            
            setPayButtonsState(true, 'PROCESSING...');

            const formData = new FormData(bookingForm);
            fetch("<?php echo e(route('booking.razorpay.order')); ?>", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            })
            .then(function (r) {
                if (!r.ok) {
                    return r.text().then(function (text) {
                        try { var json = JSON.parse(text); throw json; }
                        catch (e) { if (e.message) throw e; throw { message: 'Server error (' + r.status + '). Please try again.' }; }
                    });
                }
                return r.json().then(function (data) { return { ok: true, data: data }; });
            })
            .then(function (res) {
                var data = res.data;
                if (!data.key || !data.order_id) {
                    showMessage('danger', data.message || 'Unable to create order.');
                    setPayButtonsState(false, 'PAY NOW');
                    return;
                }
                var options = {
                    key: data.key,
                    amount: data.amount,
                    currency: data.currency,
                    name: 'TripigoTales',
                    description: <?php echo json_encode($tour->title); ?>,
                    order_id: data.order_id,
                    handler: function (response) {
                        setPayButtonsState(true, 'VERIFYING...');
                        
                        var csrfToken = bookingForm.querySelector('input[name=_token]').value;
                        fetch("<?php echo e(route('booking.razorpay.verify')); ?>", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                booking_id: data.booking_id,
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_signature: response.razorpay_signature
                            })
                        })
                        .then(function (r) {
                            return r.text().then(function (text) {
                                try { return JSON.parse(text); }
                                catch (e) { throw { message: 'Invalid server response (' + r.status + '). Please contact support.' }; }
                            });
                        })
                        .then(function (v) {
                            if (v.success) {
                                setPayButtonsState(true, 'REDIRECTING...');
                                window.location.href = v.redirectTo || "<?php echo e(route('frontend.tour.detail', $tour->slug)); ?>";
                            } else {
                                showMessage('danger', v.message || 'Payment verification failed.');
                                setPayButtonsState(false, 'PAY NOW');
                            }
                        })
                        .catch(function (err) {
                            showMessage('danger', (err && err.message) || 'Payment verification error. Please contact support.');
                            setPayButtonsState(false, 'PAY NOW');
                        });
                    },
                    modal: {
                        ondismiss: function () {
                            setPayButtonsState(!termsCheckbox.checked, 'PAY NOW');
                        }
                    },
                    theme: { color: '#18a9a1' }
                };
                if (data.customer) {
                    options.prefill = {
                        name: data.customer.name || '',
                        email: data.customer.email || '',
                        contact: data.customer.phone || ''
                    };
                }
                var rzp = new Razorpay(options);
                rzp.open();
            })
            .catch(function (err) {
                showMessage('danger', (err && err.message) || 'Could not initiate payment. Please try again.');
                setPayButtonsState(!termsCheckbox.checked, 'PAY NOW');
            });
        });
    });

    // Mobile Sticky Footer Scroll Logic
    const stickyFooter = document.querySelector('.mobile-sticky-footer');
    if (stickyFooter) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300 && window.innerWidth < 992) {
                stickyFooter.classList.add('show');
            } else {
                stickyFooter.classList.remove('show');
            }
        });
    }

    // Auto-trigger recalc initially if persons exists
    if(personsInput.value > 0) {    
        personsInput.dispatchEvent(new Event('change'));
    }
})();
</script>
		
		<?php /**PATH C:\travel update website\working\resources\views/frontend/tourBooking.blade.php ENDPATH**/ ?>