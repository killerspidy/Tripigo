@include('frontend.partials.header')

  
 <section class="breadcrumb-main pb-20 pt-14"
        style="background-image: url('{{ asset('images/bg/bg1.jpg') }}')">

        <div class="section-shape section-shape1 top-inherit bottom-0"
            style="background-image: url('{{ asset('images/shape8.png') }}')">
        </div>

        <div class="breadcrumb-outer">
            <div class="container">
                <div class="breadcrumb-content text-center">
                    <h1 class="mb-3">CANCELLATION POLICY</h1>
                   
                </div>
            </div>
        </div>

        <div class="dot-overlay"></div>
    </section>

    <!-- BreadCrumb Ends -->

    <!-- about-us starts -->
    <section class="about-us pt-6"
        style="background-image: url('{{ asset('images/background_pattern.png') }}');
            background-position: bottom right">

        <div class="container">
            <div class="about-image-box">
                <div class="row d-flex align-items-center justify-content-between">

                    <div class="col-lg-8 ps-4">
                        <div class="about-content text-left text-lg-start">
                      

                            <p class="border-b mb-2 pb-2">
                   Effective Date: 15 February, 2026<br>
Last Updated: 15 February, 2026<br><br>

At Tripigo Tales, we understand that travel plans may change. Our cancellation policy is as follows:<br><br>

1. Cancellation Charges<br>
Domestic Tours:<br>

-30+ days before departure: 10% of total package cost<br>

-15–29 days before departure: 25%<br>

-7–14 days before departure: 50%<br>

-0–6 days before departure: 100% (No refund)<br><br>



2. Non-Refundable Components<br>

The following are non-refundable:<br>

-Flight tickets (as per airline policy)<br>

-Visa fees<br>

-Permit charges<br>

-Hotel peak season bookings<br><br>

3. No Show Policy<br>

-Failure to join the tour on departure date will be treated as No Show and 100% cancellation charges apply.<br><br>

4. Refund Processing<br>

-Refunds will be processed within 7–14 working days<br>

-Refunds will be credited to the original payment method<br><br>

5. Cancellation by Tripigo Tales<br>

-In rare cases where we cancel a tour:<br>

-Full refund will be provided<br>
OR<br>

-Alternative travel date/package offered<br>

                        </div>
                    </div>

      


                </div>
            </div>
        </div>

        <div class="white-overlay"></div>
    </section>
 @include('frontend.partials.footer')
    <!-- footer ends -->



   <!-- *Scripts* -->
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/fontawesome.min.js') }}"></script>
<script src="{{ asset('js/particles.js') }}"></script>
<script src="{{ asset('js/particlerun.js') }}"></script>
<script src="{{ asset('js/plugin.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/custom-swiper.js') }}"></script>
<script src="{{ asset('js/custom-nav.js') }}"></script>
  </body>
</html>
