<?php echo $__env->make('frontend.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  
    <!-- BreadCrumb Starts -->
    <section class="breadcrumb-main pb-20 pt-14"
        style="background-image: url('<?php echo e(asset('images/bg/bg1.jpg')); ?>')">

        <div class="section-shape section-shape1 top-inherit bottom-0"
            style="background-image: url('<?php echo e(asset('images/shape8.png')); ?>')">
        </div>

        <div class="breadcrumb-outer">
            <div class="container">
                <div class="breadcrumb-content text-center">
                    <h1 class="mb-3">About Us</h1>
                    <nav aria-label="breadcrumb" class="d-block">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo e(url('/')); ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                About Us
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="dot-overlay"></div>
    </section>

    <!-- BreadCrumb Ends -->

    <!-- about-us starts -->
    <section class="about-us pt-6"
        style="background-image: url('<?php echo e(asset('images/background_pattern.png')); ?>');
            background-position: bottom right">

        <div class="container">
            <div class="about-image-box">
                <div class="row d-flex align-items-center justify-content-between">

                    <div class="col-lg-6 ps-4">
                        <div class="about-content text-center text-lg-start">
                            <h2 class="theme d-inline-block mb-2">About Tripigo Tales</h2><br>
                     

                            <p class="border-b mb-2 pb-2">
                           At Tripigo Tales, we believe that travel is more than just visiting destinations — it’s about experiencing cultures, creating lifelong memories, and collecting stories worth sharing.<br><br>

Founded with a passion for exploration and personalized travel planning, Tripigo Tales is dedicated to designing seamless, memorable, and affordable travel experiences across India.<br><br>

Whether it’s a romantic honeymoon in the mountains, an adventurous road trip to Spiti, a relaxing beach holiday in Goa, or a luxury getaway — we turn your travel dreams into reality.<br><br>
                            </p>

                   
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4 pe-4">
                        <div class="about-image"
                            style="animation:none; background:transparent">
                            <img src="<?php echo e(asset('images/travel.png')); ?>" alt="About Travel">
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <!-- Counter -->
                        <div class="counter-main w-75 float-start z-index3 position-relative">
                            <div class="counter p-4 pb-0 box-shadow bg-white rounded mt-minus">
                                <div class="row">

                                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                                        <div class="counter-item border-end pe-4">
                                            <div class="counter-content">
                                                <h2 class="value mb-0 theme">4</h2>
                                                <span class="m-0">Years Experiences</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                                        <div class="counter-item border-end pe-4">
                                            <div class="counter-content">
                                                <h2 class="value mb-0 theme">70</h2>
                                                <span class="m-0">Tour Packages</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                                        <div class="counter-item border-end pe-4">
                                            <div class="counter-content">
                                                <h2 class="value mb-0 theme">350</h2>
                                                <span class="m-0">Happy Customers</span>
                                            </div>
                                        </div>
                                    </div>

                        

                                </div>
                            </div>
                        </div>
                        <!-- End Counter -->
                    </div>

                </div>
            </div>
        </div>

        <div class="white-overlay"></div>
    </section>
    <!-- about-us ends -->

 <section class="why-choose-us pb-0" style="background-image: url(images/sticker.png)">
      <div class="container">
        <div class="section-title mb-6 w-50 mx-auto text-center">
          <h5 class="theme1">Why Choose Us</h5>
          <h2>Your Trusted <span class="theme">Travel Partner</span></h2>
          <p>Leading The Way In Small Group Adventures For Over 4+ Years. Discover How We're Redefining The Future Of Travel.</p>
        </div>
        <div class="row justify-content-center align-items-start">
          <div class="col-md-4">
            <div class="d-flex flex-column gap-5">
              <div class="feature-box fbox-one d-flex justify-content-start align-items-center flex-row-reverse gap-3 text-end bg-lblue mb-3 px-3 py-2">
                <div class="feature-icon d-inline-flex p-3 bg-lblue2 white rounded-circle"><i class="fa fa-bell"></i></div>
                <div>
                  <h5>24/7 Travel Assistance</h5>
                  <p>We stay connected before, during and after your trip.</p>
                </div>
              </div>
              <div class="feature-box d-flex justify-content-start align-items-center flex-row-reverse gap-3 text-end bg-lyellow mt-3 px-3 py-2">
                <div class="feature-icon d-inline-flex p-3 bg-lyellow2 white rounded-circle"><i class="fa fa-check"></i></div>
                <div>
                  <h5>Transparent Pricing</h5>
                  <p>No hidden charges. What you see is what you pay.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 d-flex justify-content-center">
            <img src="images/girl-1.png" alt="Traveler" class="traveler-img w-75" />
          </div>
          <div class="col-md-4">
            <div class="d-flex flex-column gap-5">
              <div class="feature-box fbox-three d-flex justify-content-start align-items-center gap-3 bg-lyellow mb-3 px-3 py-2">
                <div class="feature-icon d-inline-flex p-3 bg-lyellow2 white rounded-circle"><i class="fa fa-shopping-bag"></i></div>
                <div>
                  <h5>Tailored Itineraries</h5>
                  <p>Tailor-made itineraries to suit your preferences and needs.</p>
                </div>
              </div>
              <div class="feature-box d-flex justify-content-start align-items-center gap-3 bg-lgreen mt-3 px-3 py-2">
                <div class="feature-icon d-inline-flex p-3 bg-lgreen2 white rounded-circle"><i class="fa fa-gift"></i></div>
                <div>
                  <h5>Exclusive Offers</h5>
                  <p>We provide exclusive travel offers designed just for you.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-4 justify-content-center">
          <div class="col-md-4">
            <div class="feature-box text-center bg-lblue px-3 py-2 mx-0">
              <div class="feature-icon d-inline-flex p-3 mb-2 bg-lblue2 white rounded-circle"><i class="fa fa-map"></i></div>
              <h5>Easy Bookings</h5>
              <p>We Provide Hassle-free bookings — that’s why travelers choose Tripigo Tales.</p>
            </div>
          </div>
        </div>
      </div>
    </section><br>
    <!-- about-us starts -->
    <section class="steps-to pt-0">
      <div class="container text-center">
        <!-- Section Header -->
        <div class="section-title mb-6 w-75 mx-auto text-center"><br><br>
          <h4 class="mb-1 theme1">Our Process</h4>
          <h2 class="mb-1">Simple Steps to Your <span class="theme">Dream Vacation</span></h2>
        </div>

        <!-- Steps Row -->
        <div class="row justify-content-center">
          <div class="col-md-4 step-card">
            <img src="images/illu3.png" alt="Search Destination" class="step-icon mb-3 w-75" />
            <h4 class="fw-semibold">Search Your Destination</h4>
            <p class="step-subtitle">Enter your desired location, travel dates, and preferences to explore available options.</p>
          </div>
          <div class="col-md-4 step-card">
            <img src="images/illu2.png" alt="Select Package" class="step-icon mb-3 w-75" />
            <h4 class="fw-semibold">Select Your Package</h4>
            <p class="step-subtitle">Browse curated offers and choose the travel package that suits your needs.</p>
          </div>
          <div class="col-md-4 step-card">
            <img src="images/illu1.png" alt="Complete Booking" class="step-icon mb-3 w-75" />
            <h4 class="fw-semibold">Complete Your Booking</h4>
            <p class="step-subtitle">Fill in your details, make payment, and receive your confirmation to start your adventure!</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Lists ends -->

    <!-- Discount action starts -->
    <section class="p-0">
      <div class="container">
        <div class="row offer-banner shadow-lg">
          <!-- Left Content -->
          <div class="col-md-6 d-flex align-items-center bg-map">
            <div class="offer-text w-100">
              <div class="white text-uppercase fw-semibold mb-2"><i class="icon-plane"></i> Offer For You</div>
              <h2 class="fw-bold theme1 mb-4">Discover Incredible Deals Just for You!</h2>
              <a href="contactus" class="nir-btn-white">Contact Us Now →</a>
            </div>
          </div>

          <!-- Right Image -->
          <div class="col-md-6 p-0">
            <img src="images/bg/bg6.jpg" alt="Travel Deal" class="img-fluid w-100 h-100" style="object-fit: cover" />
          </div>
        </div>
      </div>
    </section>
    <!-- Discount action Ends -->


    <!-- footer starts -->
 <?php echo $__env->make('frontend.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- footer ends -->



   <!-- *Scripts* -->
<script src="<?php echo e(asset('js/jquery-3.5.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/fontawesome.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/particles.js')); ?>"></script>
<script src="<?php echo e(asset('js/particlerun.js')); ?>"></script>
<script src="<?php echo e(asset('js/plugin.js')); ?>"></script>
<script src="<?php echo e(asset('js/main.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-swiper.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-nav.js')); ?>"></script>
  </body>
</html>
<?php /**PATH C:\travel update website\working\resources\views/frontend/aboutus.blade.php ENDPATH**/ ?>