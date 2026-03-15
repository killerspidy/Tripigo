@include('frontend.partials.header')

<style>
@media (max-width: 767px) {
    .bg-white.rounded.box-shadow {
        margin-bottom: 20px !important;
    }
    .col-md-3 img, .col-md-3 .bg-secondary {
        min-height: 180px !important;
        border-radius: 8px 8px 0 0;
    }
    .col-md-6.p-4 {
        padding: 1.5rem !important;
    }
    .col-md-3.p-4.border-start {
        border-start: none !important;
        border-top: 1px solid #eee;
        padding: 1.5rem !important;
        align-items: flex-start !important;
    }
    .col-md-3.p-4.border-start .text-center {
        text-align: left !important;
        margin-bottom: 1rem !important;
    }
    .badge {
        font-size: 12px !important;
    }
    h5.mb-0 {
        font-size: 1.1rem;
    }
}
</style>

    <!-- BreadCrumb Starts -->
    <section class="breadcrumb-main pb-20 pt-14" style="background-image: url({{ asset('images/bg/bg1.jpg') }});">
        <div class="section-shape section-shape1 top-inherit bottom-0" style="background-image: url({{ asset('images/shape8.png') }});"></div>
        <div class="breadcrumb-outer">
            <div class="container">
                <div class="breadcrumb-content text-center">
                    <h1 class="mb-3">My Bookings</h1>
                    <nav aria-label="breadcrumb" class="d-block">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Bookings</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="dot-overlay"></div>
    </section>
    <!-- BreadCrumb Ends -->

    <!-- Bookings Section -->
    <section class="trending pt-6 pb-6 bg-lgrey">
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($bookings->count() > 0)
                <div class="row">
                    @foreach($bookings as $booking)
                        <div class="col-lg-12 mb-4">
                            <div class="bg-white rounded box-shadow overflow-hidden">
                                <div class="row g-0">
                                    <!-- Tour Image -->
                                    <div class="col-md-3">
                                        @if($booking->tour && $booking->tour->image)
                                            <img src="{{ asset($booking->tour->image) }}" alt="{{ $booking->tour->title ?? '' }}" class="w-100 h-100" style="object-fit: cover; min-height: 200px;">
                                        @else
                                            <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center" style="min-height: 200px;">
                                                <i class="fa fa-image text-white fa-3x"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Booking Details -->
                                    <div class="col-md-6 p-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <h5 class="mb-0 me-3">
                                                @if($booking->tour)
                                                    <a href="{{ route('frontend.tour.detail', $booking->tour->slug) }}">{{ $booking->tour->title }}</a>
                                                @else
                                                    <span class="text-muted">Tour no longer available</span>
                                                @endif
                                            </h5>
                                            @if($booking->status === 'paid')
                                                <span class="badge bg-success text-white px-2 py-1">Paid</span>
                                            @elseif($booking->status === 'pending')
                                                <span class="badge bg-warning text-dark px-2 py-1">Pending</span>
                                            @elseif($booking->status === 'failed')
                                                <span class="badge bg-danger text-white px-2 py-1">Failed</span>
                                            @elseif($booking->status === 'cancelled')
                                                <span class="badge bg-secondary text-white px-2 py-1">Cancelled</span>
                                            @elseif($booking->status === 'refunded')
                                                <span class="badge bg-info text-white px-2 py-1">Refunded</span>
                                            @endif
                                        </div>

                                        @if($booking->tour && $booking->tour->location)
                                            <p class="mb-1 text-muted"><i class="icon-location-pin"></i> {{ $booking->tour->location }}</p>
                                        @endif

                                        <div class="row mt-3">
                                            <div class="col-sm-6 mb-2">
                                                <small class="text-muted d-block">Travel Dates</small>
                                                <strong>
                                                    {{ $booking->from_date ? $booking->from_date->format('d M Y') : 'N/A' }} 
                                                    &ndash; 
                                                    {{ $booking->to_date ? $booking->to_date->format('d M Y') : 'N/A' }}
                                                </strong>
                                            </div>
                                            <div class="col-sm-3 mb-2">
                                                <small class="text-muted d-block">Duration</small>
                                                <strong>{{ $booking->days ? $booking->days . ' ' . Str::plural('Day', $booking->days) : 'N/A' }}</strong>
                                            </div>
                                            <div class="col-sm-3 mb-2">
                                                <small class="text-muted d-block">Persons</small>
                                                <strong>{{ $booking->persons }}</strong>
                                            </div>
                                        </div>

                                        <div class="mt-2">
                                            <small class="text-muted">Booking ID: #{{ $booking->id }}</small>
                                            <small class="text-muted ms-3">Booked on: {{ $booking->created_at->format('d M Y, h:i A') }}</small>
                                        </div>
                                    </div>

                                    <!-- Price & Actions -->
                                    <div class="col-md-3 p-4 d-flex flex-column justify-content-center align-items-center border-start">
                                        <div class="text-center mb-3">
                                            <small class="text-muted d-block">Total Amount</small>
                                            <h4 class="theme mb-0">₹{{ number_format($booking->total_amount, 2) }}</h4>
                                            <small class="text-muted">₹{{ number_format($booking->price_per_person, 2) }} x {{ $booking->persons }} {{ Str::plural('person', $booking->persons) }}</small>
                                        </div>

                                        @if($booking->status === 'paid')
                                            <a href="{{ route('frontend.booking.success', $booking->slug) }}" class="nir-btn w-100 text-center mb-2" style="font-size: 13px;">
                                                <i class="fa fa-eye"></i> View Details
                                            </a>
                                        @elseif($booking->status === 'pending')
                                            <button type="button" class="nir-btn w-100 mb-2 btn-retry-payment" 
                                                data-slug="{{ $booking->slug }}" 
                                                style="font-size: 13px; border: none;">
                                                <i class="fa fa-credit-card"></i> Pay Now
                                            </button>
                                        @endif

                                        @if($booking->canBeCancelled())
                                            <button type="button" class="btn btn-outline-danger w-100 btn-cancel-booking mb-2" 
                                                data-slug="{{ $booking->slug }}" 
                                                data-policy="{{ $booking->getRefundEligibilityText() }}"
                                                style="font-size: 13px; border-radius: 25px;">
                                                <i class="fa fa-times-circle"></i> Cancel Booking
                                            </button>
                                        @endif

                                        @if($booking->tour)
                                            <a href="{{ route('frontend.tour.detail', $booking->tour->slug) }}" class="nir-btn-black w-100 text-center" style="font-size: 13px;">
                                                <i class="fa fa-info-circle"></i> Tour Details
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $bookings->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fa fa-suitcase-rolling" style="font-size: 80px; color: #ccc;"></i>
                    </div>
                    <h3 class="mb-2">No Bookings Yet</h3>
                    <p class="text-muted mb-4">You haven't booked any tours yet. Start exploring our amazing tours!</p>
                    <a href="{{ route('frontend.tour') }}" class="nir-btn">
                        <i class="fa fa-search"></i> Explore Tours
                    </a>
                </div>
            @endif

        </div>
    </section>

    <!-- Cancellation Modal -->
    <div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="cancelBookingForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Cancel Booking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info mb-3" id="policyMessage"></div>
                        <div class="mb-3">
                            <label class="form-label">Reason for Cancellation</label>
                            <textarea name="cancellation_reason" class="form-control" rows="3" required placeholder="Please tell us why you are cancelling..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Confirm Cancellation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        </div>
    </section>
    <!-- Bookings Section ends -->

@include('frontend.partials.footer')

<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/particles.js') }}"></script>
<script src="{{ asset('js/particlerun.js') }}"></script>
<script src="{{ asset('js/plugin.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/custom-swiper.js') }}"></script>
<script src="{{ asset('js/custom-nav.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
$(document).ready(function() {
    // Toastr Configuration
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
    };

    // Show session alerts as toasts
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    // Cancel Booking Logic
    $('.btn-cancel-booking').on('click', function() {
        const slug = $(this).data('slug');
        const policy = $(this).data('policy');
        const $modal = $('#cancelBookingModal');
        
        $modal.find('#policyMessage').text(policy);
        $modal.find('form').attr('action', `/user/booking/${slug}/cancel`);
        $modal.modal('show');
    });

    $('#cancelBookingForm').on('submit', function(e) {
        // We can keep it as normal form submit or change to AJAX. 
        // Plan says "AJAX response handling with Toast notifications".
        // Let's implement AJAX for a smoother experience.
        e.preventDefault();
        const $form = $(this);
        const $btn = $form.find('button[type="submit"]');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $btn.prop('disabled', true).text('Processing...');
                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(res) {
                        $('#cancelBookingModal').modal('hide');
                        Swal.fire('Cancelled!', 'Your booking has been cancelled.', 'success')
                        .then(() => location.reload());
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).text('Confirm Cancellation');
                        toastr.error(xhr.responseJSON?.message || 'Failed to cancel booking.');
                    }
                });
            }
        });
    });

    // Retry Payment Logic
    $('.btn-retry-payment').on('click', function() {
        const bookingSlug = $(this).data('slug');
        const $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Initializing...');

        $.ajax({
            url: `/user/booking/${bookingSlug}/retry-payment`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                const options = {
                    "key": response.key,
                    "amount": response.amount,
                    "currency": response.currency,
                    "name": "Tripigo Tales",
                    "description": "Tour Booking Payment",
                    "order_id": response.order_id,
                    "handler": function (paymentResponse){
                        verifyPayment(paymentResponse, response.booking_id);
                    },
                    "prefill": {
                        "name": response.customer.name,
                        "email": response.customer.email,
                        "contact": response.customer.phone
                    },
                    "theme": {
                        "color": "#21918d"
                    },
                    "modal": {
                        "ondismiss": function(){
                            $btn.prop('disabled', false).html('<i class="fa fa-credit-card"></i> Pay Now');
                        }
                    }
                };
                const rzp1 = new Razorpay(options);
                rzp1.open();
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html('<i class="fa fa-credit-card"></i> Pay Now');
                toastr.error(xhr.responseJSON?.message || 'Failed to initialize payment.');
            }
        });
    });

    function verifyPayment(paymentResponse, bookingId) {
        $.ajax({
            url: "{{ route('booking.razorpay.verify') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                booking_id: bookingId,
                razorpay_payment_id: paymentResponse.razorpay_payment_id,
                razorpay_order_id: paymentResponse.razorpay_order_id,
                razorpay_signature: paymentResponse.razorpay_signature
            },
            success: function(res) {
                if (res.success) {
                    window.location.href = res.redirectTo;
                } else {
                    toastr.error(res.message || 'Payment verification failed.');
                    setTimeout(() => location.reload(), 2000);
                }
            },
            error: function() {
                toastr.error('An error occurred during verification.');
                setTimeout(() => location.reload(), 2000);
            }
        });
    }
});
</script>
