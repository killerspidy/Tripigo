@include('frontend.partials.header')

  
 <section class="breadcrumb-main pb-20 pt-14"
        style="background-image: url('{{ asset('images/bg/bg1.jpg') }}')">

        <div class="section-shape section-shape1 top-inherit bottom-0"
            style="background-image: url('{{ asset('images/shape8.png') }}')">
        </div>

        <div class="breadcrumb-outer">
            <div class="container">
                <div class="breadcrumb-content text-center">
                    <h1 class="mb-3">Terms & Conditions</h1>
                   
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

These Terms & Conditions govern your use of Tripigo Tales website and services.<br><br>

1. Booking & Payments<br>

-A booking is confirmed only after receipt of advance payment.<br>

-Full payment must be made before tour commencement.<br>

-Prices are subject to availability and change without prior notice.<br><br>

2. Pricing & Inclusions<br>

-Tour prices include only services specifically mentioned in the package.<br>

-Not included unless specified:<br>

-Airfare (if not mentioned)<br>

-Personal expenses<br>

-Travel insurance<br>

-Optional activities<br>

-Government taxes (if applicable)<br><br>

3. Travel Documents<br>

-Customers are responsible for:<br>

-Valid passport<br>

-Visa<br>

-Required permits<br>

-Government ID<br>

-Tripigo Tales is not liable for denied boarding due to incomplete documentation.<br><br>

4. Changes & Modifications<br>

-Any modification requested after booking may incur additional charges.<br>

-Tripigo Tales reserves the right to modify itinerary due to weather, safety, or operational reasons.<br><br>

5. Liability<br>

-Tripigo Tales acts as a travel organizer and is not liable for:<br>

-Natural disasters<br>

-Flight cancellations<br>

-Political disturbances<br>

-Accidents or personal injury<br>

-Loss of personal belongings<br>

-Travel insurance is strongly recommended.<br><br>

6. Conduct<br>

-We reserve the right to terminate services if a traveler engages in misconduct, illegal activity, or behavior affecting other travelers.<br><br>

7. Force Majeure<br>

-Tripigo Tales is not responsible for failure to perform services due to unforeseen circumstances beyond control.<br>

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
