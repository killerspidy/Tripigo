<?php echo $__env->make('frontend.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
  /* Share button */
.share-inline-btn {
    display: flex;
    gap: 6px;
}

.share-inline-btn a {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
}

.share-inline-btn a:nth-child(1) { background: #1877F2; } /* Facebook */
.share-inline-btn a:nth-child(2) { 
    background: linear-gradient(45deg,#f09433,#dc2743,#bc1888);
}
.share-inline-btn a:nth-child(3) { background: #25D366; }

/* Book Now button */
.book-btn-inline {
    padding: 8px 22px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 14px;
    color: #fff;
    background: linear-gradient(135deg, #0aa6a6, #0f766e);
    box-shadow: 0 6px 15px rgba(15,118,110,.35);
    text-decoration: none;
    transition: 0.3s;
}

.book-btn-inline:hover {
    transform: translateY(-2px);
    color: #fff;
}

</style>
    <!-- banner starts -->
    <section class="banner overflow-hidden">
      <div class="slider top50">
        <div class="swiper-container">
          <div class="swiper-wrapper">
            <?php $__empty_1 = true; $__currentLoopData = $sliders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="swiper-slide">
              <div class="slide-inner">
                <div class="slide-image" style="background-image: url(<?php echo e($slide->image ? asset($slide->image) : asset('images/slider/1.jpg')); ?>)"></div>
                <div class="swiper-content">
                  <?php if($slide->subtitle): ?>
                  <div class="entry-meta mb-2">
                    <h5 class="entry-category mb-0 white"><?php echo e($slide->subtitle); ?></h5>
                  </div>
                  <?php endif; ?>
                  <h1 class="mb-2"><a href="<?php echo e($slide->buttons->first()?->link ?? '#'); ?>" class="white"><?php echo e($slide->title); ?></a></h1>
                  <?php if($slide->description): ?>
                  <p class="white mb-4"><?php echo e($slide->description); ?></p>
                  <?php endif; ?>
                  <?php if($slide->buttons->isNotEmpty()): ?>
                  <div class="slider-button d-flex justify-content-center flex-wrap">
                    <?php $__currentLoopData = $slide->buttons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $btn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($btn->link ?: '#'); ?>" class="<?php echo e($btn->style); ?> <?php echo e(!$loop->first ? 'ms-3' : ''); ?>"><?php echo e($btn->label); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                  <?php endif; ?>
                </div>
                <div class="dot-overlay"></div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="swiper-slide">
              <div class="slide-inner">
                <div class="slide-image" style="background-image: url(images/slider/1.jpg)"></div>
                <div class="swiper-content">
                  <div class="entry-meta mb-2">
                    <h5 class="entry-category mb-0 white">Road To Travel</h5>
                  </div>
                  <h1 class="mb-2"><a href="#" class="white">Begin Your Adventure With Us</a></h1>
                  <p class="white mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                  <a href="<?php echo e(route('frontend.contactus')); ?>" class="nir-btn">Make An Enquiry</a>
                </div>
                <div class="dot-overlay"></div>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <!-- Add Arrows -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </section>
    <!-- banner ends -->

    <!-- form main starts -->
    <div class="form-main">
      <div class="section-shape top-0" style="background-image: url(images/shape-pat.png)"></div>
      <div class="container">
        <div class="row align-items-center form-content rounded position-relative ms-5 me-5">
          <div class="col-lg-2 p-0">
            <h4 class="form-title form-title1 text-center p-4 py-5 white bg-theme mb-0 rounded-start d-lg-flex align-items-center">
              <i class="icon-location-pin fs-1 me-1"></i> Find Your Holidays
            </h4>
          </div>
          <div class="col-lg-10 px-4">
            <form method="get" action="<?php echo e(route('frontend.tour')); ?>" id="holidaySearchForm" class="form-content-in d-lg-flex align-items-center">
              <div class="form-group me-2">
                <div class="input-box">
                  <select name="destination" id="search-destination" class="form-select" style="min-width: 160px;">
                    <option value="">Destination</option>
                    <?php $__currentLoopData = ($categories ?? collect())->whereNull('parent_id')->sortBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
              </div>
              <div class="form-group me-2">
                <div class="input-box">
                  <select name="travel_type" id="search-travel-type" class="form-select" style="min-width: 160px;">
                    <option value="">Travel Type</option>
                  </select>
                </div>
              </div>
              <?php
                  use App\Models\Tour;

                  $tourDurations = Tour::whereNotNull('tour_duration')
                      ->select('tour_duration')
                      ->distinct()
                      ->orderBy('tour_duration')
                      ->pluck('tour_duration');
              ?>
               <div class="form-group me-2">
                  <div class="input-box">
                      <select name="tour_duration" class="form-select" style="min-width: 160px;">
                          <option value="">Tour Duration</option>

                          <?php $__currentLoopData = $tourDurations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $duration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($duration); ?>">
                                  <?php echo e($duration); ?> <?php echo e($duration == 1 ? 'Day' : 'Days'); ?>

                              </option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                      </select>
                  </div>
              </div>
              <div class="form-group mb-0 text-center">
                <button type="button" id="search-submit" class="nir-btn w-100"><i class="fa fa-search mr-2"></i> Search Now</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- form main ends -->
    <!-- about-us starts -->
    <section class="about-us pb-6 pt-10" style="background-image: url(images/shape4.png); background-position: center">
      <div class="container">
        <div class="section-title mb-6 w-50 mx-auto text-center">
          <h4 class="mb-1 theme1">Core Features</h4>
          <h2 class="mb-1">Find <span class="theme">Travel Perfection</span></h2>
       
        </div>

        <!-- why us starts -->
        <div class="why-us">
          <div class="why-us-box">
            <div class="row">
              <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="why-us-item p-5 pt-6 pb-6 border rounded bg-white">
                  <div class="why-us-content">
                    <div class="why-us-icon mb-1">
                      <i class="icon-flag theme"></i>
                    </div>
                    <h4>Tell Us What You want To Do</h4>
                  
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="why-us-item p-5 pt-6 pb-6 border rounded bg-white">
                  <div class="why-us-content">
                    <div class="why-us-icon mb-1">
                      <i class="icon-location-pin theme"></i>
                    </div>
                    <h4>Share Your Travel Locations</h4>
                
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="why-us-item p-5 pt-6 pb-6 border rounded bg-white">
                  <div class="why-us-content">
                    <div class="why-us-icon mb-1">
                      <i class="icon-directions theme"></i>
                    </div>
                    <h4>Share Your Travel Preference</h4>
             
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="why-us-item p-5 pt-6 pb-6 border rounded bg-white">
                  <div class="why-us-content">
                    <div class="why-us-icon mb-1">
                      <i class="icon-compass theme"></i>
                    </div>
                    <h4>Trusted Tour Agency</h4>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- why us ends -->
      </div>
      <div class="white-overlay"></div>
    </section>
    <!-- about-us starts -->
      <!-- top Destination starts -->
    <section class="trending pb-3 pt-0">
      <div class="container">
        <div class="section-title mb-6 w-50 mx-auto text-center">
          <h4 class="mb-1 theme1">Top Destinations</h4>
          <h2 class="mb-1">Explore <span class="theme">Top Destinations</span></h2>
         
        </div>
        <div class="row align-items-center">
          <div class="col-lg-7">
            <div class="row">
              <div class="col-lg-12 mb-4">
                <div class="trend-item1">
                  <div class="trend-image position-relative rounded">
                    <img src="images/destination/destination2.jpg" alt="image" />
                    <div class="trend-content d-flex align-items-center justify-content-between position-absolute bottom-0 p-4 w-100 z-index">
                      <div class="trend-content-title">
   
                        <h3 class="mb-0 white">Rajashthan</h3>
                      </div>
                      <span class="white bg-theme p-1 px-2 rounded">18 Tours</span>
                    </div>
                    <div class="color-overlay"></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 mb-4">
                <div class="trend-item1">
                  <div class="trend-image position-relative rounded">
                    <img src="images/destination/destination15.jpg" alt="image" />
                    <div class="trend-content d-flex align-items-center justify-content-between position-absolute bottom-0 p-4 w-100">
                      <div class="trend-content-title">
                     
                        <h3 class="mb-0 white">Kerela</h3>
                      </div>
                      <span class="white bg-theme p-1 px-2 rounded">15 Tours</span>
                    </div>
                    <div class="color-overlay"></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 mb-4">
                <div class="trend-item1">
                  <div class="trend-image position-relative rounded">
                    <img src="images/destination/destination16.jpg" alt="image" />
                    <div class="trend-content d-flex align-items-center justify-content-between position-absolute bottom-0 p-4 w-100 z-index">
                      <div class="trend-content-title">
            
                        <h3 class="mb-0 white">Gujarat</h3>
                      </div>
                      <span class="white bg-theme p-1 px-2 rounded">32 Tours</span>
                    </div>
                    <div class="color-overlay"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-5 mb-4">
            <div class="trend-item1">
              <div class="trend-image position-relative rounded">
                <img src="images/destination/destination1.jpg" alt="image" />
                <div class="trend-content d-flex align-items-center justify-content-between position-absolute bottom-0 p-4 w-100 z-index">
                  <div class="trend-content-title">
           
                    <h3 class="mb-0 white">Himachal Pradesh</h3>
                  </div>
                  <span class="white bg-theme p-1 px-2 rounded">15 Tours</span>
                </div>
                <div class="color-overlay"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- top Destination ends -->
    <!-- about-us ends -->

    <!-- top Destination starts -->

    <!-- top Destination ends -->
    
    <!-- top Destination ends -->

    <!-- best tour Starts -->
    <section class="trending bg-grey pt-17 pb-6">
      <div class="section-shape top-0" style="background-image: url(images/shape8.png)"></div>
      <div class="container">
        <div class="row align-items-center justify-content-between mb-6">
          <div class="col-lg-7">
            <div class="section-title text-center text-lg-start">
              <h4 class="mb-1 theme1">Top Pick</h4>
              <h2 class="mb-1">Best <span class="theme">Tour Packages</span></h2>
   
            </div>
          </div>
          <div class="col-lg-5"></div>
        </div>
        <div class="trend-box">
          <div class="row item-slider">
            <?php $__currentLoopData = $tours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
              <div class="trend-item rounded box-shadow bg-white">
                <div class="trend-image position-relative">
                  <img src="<?php echo e($tour->image ? asset($tour->image) : asset('/images/trending/trending10.jpg')); ?>" alt="image" class="" width="400" height="300" />
                  <div class="color-overlay"></div>
                </div>
                <div class="trend-content p-4 pt-5 position-relative">
                  <div class="trend-meta bg-theme white px-3 py-2 rounded">
                    <div class="entry-author">
                      <i class="icon-calendar"></i>
                      <span class="fw-bold"> <?php echo e($tour->tour_duration ?? 0); ?></span>
                    </div>
                  </div>
                  <h5 class="theme mb-1"><i class="flaticon-location-pin"></i> <?php echo e($tour->location); ?></h5>
                  <h3 class="mb-1"><a href="<?php echo e(route('frontend.tour.detail', $tour->slug)); ?>"><?php echo e($tour->title); ?></a></h3>
                  <div class="rating-main d-flex align-items-center pb-2">
                     <div class="rating">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php if($i <= $tour->star_rating): ?>
                                <span class="fa fa-star checked"></span>
                            <?php else: ?>
                                <span class="fa-regular fa-star"></span>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                  </div>
                   <p class="border-b pb-2 mb-2">
                      <?php echo e(\Illuminate\Support\Str::limit(strip_tags($tour->description), 200)); ?>

                   </p>
                   <div class="entry-meta">
                            <div class="d-flex align-items-center justify-content-between flex-nowrap">

                                
                                <p class="mb-0 d-flex align-items-center">
                                    <span class="theme fw-bold fs-5 me-1">₹<?php echo e($tour->price); ?></span>
                                    <span class="text-muted">/pax</span>
                                </p>
 <?php
    $tourUrl = url()->current();
    $shareText = urlencode("Check out this amazing tour: {$tour->title}");
?>
                                
                                <div class="d-flex align-items-center gap-2 ms-2">

                                    
                                    <div class="share-inline-btn d-flex align-items-center">
                                    
                                    
                                        <a href="https://wa.me/?text=<?php echo e($shareText); ?> <?php echo e(route('frontend.tour.detail', $tour->slug)); ?>" target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </div>

                                    
                                    <a href="<?php echo e(route('frontend.tour.detail', $tour->slug)); ?>" class="book-btn-inline">
                                      View
                                    </a>

                                </div>
                            </div>
                        </div>
                </div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
      
      </div>
    </section>
    <!-- best tour Ends -->

   <!-- offer Packages Starts -->
    
    <!-- offer Packages Ends -->

    <!-- testimonial starts -->
      <section class="testimonial pt-10 pb-20" style="background-image: url(images/bg/bg1.jpg)">
      <div class="container">
        <div class="testimonial-in">
          <div class="row align-items-center">
            <div class="col-lg-5">
              <div class="section-title">
                <h4 class="mb-1 theme1">Our Testimonials</h4>
                <h2 class="mb-1 white">Good Reviews By <span class="theme">Clients</span></h2>
            
              </div>
            </div>
            <div class="col-lg-7">
              <div class="row about-slider">
                <?php $__empty_1 = true; $__currentLoopData = $testimonials ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-sm-4 item">
                  <div class="testimonial-item1">
                    <div class="details d-flex">
                      <i class="fa fa-quote-left fs-1 mb-0"></i>
                      <div class="author-content ms-4">
                        <p class="mb-4 white fs-5 fw-normal"><?php echo e($testimonial->content); ?></p>
                        <div class="author-info d-flex align-items-center">
                    
                          <div class="author-title ms-3">
                            <h5 class="m-0 theme1">- <?php echo e($testimonial->client_name); ?></h5>
             
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-sm-4 item">
                  <div class="testimonial-item1">
                    <div class="details d-flex">
                      <i class="fa fa-quote-left fs-1 mb-0"></i>
                      <div class="author-content ms-4">
                        <p class="mb-4 white fs-5 fw-normal">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
                        <div class="author-info d-flex align-items-center">
                          <img src="<?php echo e(asset('images/testimonial/img1.jpg')); ?>" alt="" />
                          <div class="author-title ms-3">
                            <h5 class="m-0 theme1">Jared Erondu</h5>
                            <span class="white">Supervisor</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dot-overlay"></div>
    </section>
    <!-- offer Packages Ends -->
<section class="trending pb-0 pt-4">
      <div class="container">
        <div class="section-title mb-6 w-75 mx-auto text-center">
          <h4 class="mb-1 theme1">Top Offers</h4>
          <h2 class="mb-1">Special <span class="theme">Offers & Discount </span> Packages</h2>
   
        </div>
        <div class="trend-box">
          <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $discountedTours ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
              $originalPrice = (float) $tour->price;
              $discountPercent = (float) $tour->special_discount;
              $discountedPrice = $originalPrice * (100 - $discountPercent) / 100;
              $days = $tour->tour_duration ?? $tour->tour_duration ?? 0;
            ?>
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
              <div class="trend-item rounded box-shadow bg-white">
                <div class="trend-image position-relative">
                  <img src="<?php echo e($tour->image ? asset($tour->image) : asset('images/trending/trending1.jpg')); ?>" alt="<?php echo e($tour->title); ?>" class="" />
                  <div class="ribbon ribbon-top-left"><span class="fw-bold"><?php echo e(number_format($discountPercent, 0)); ?>% OFF</span></div>
                  <div class="color-overlay"></div>
                </div>
                <div class="trend-content p-4 pt-5 position-relative">
                  <div class="trend-meta bg-theme white px-3 py-2 rounded">
                    <div class="entry-author">
                      <i class="icon-calendar"></i>
                      <span class="fw-bold"> <?php echo e($days); ?></span>
                    </div>
                  </div>
                  <h5 class="theme mb-1"><i class="flaticon-location-pin"></i> <?php echo e($tour->location ?? '—'); ?></h5>
                  <h3 class="mb-1"><a href="<?php echo e(route('frontend.tour.detail', $tour->slug)); ?>"><?php echo e($tour->title); ?></a></h3>
                  <div class="rating-main d-flex align-items-center pb-2">
                    <div class="rating">
                      <?php for($i = 1; $i <= 5; $i++): ?>
                        <?php if($i <= ($tour->star_rating ?? 0)): ?>
                          <span class="fa fa-star checked"></span>
                        <?php else: ?>
                          <span class="fa-regular fa-star"></span>
                        <?php endif; ?>
                      <?php endfor; ?>
                    </div>
                  </div>
                  <p class="border-b pb-2 mb-2"><?php echo e(\Illuminate\Support\Str::limit(strip_tags($tour->description ?? $tour->what_to_expect ?? ''), 120)); ?></p>
                    <div class="entry-meta">
                            <div class="d-flex align-items-center justify-content-between flex-nowrap">
                      <?php if($originalPrice > $discountedPrice): ?>
                       <p class="mb-0 d-flex align-items-center"><del class="text-muted">₹<?php echo e(number_format($originalPrice, 0)); ?></del></p>
                      <?php endif; ?>
                      <p class="mb-0 d-flex align-items-center"><span class="theme fw-bold fs-4">₹<?php echo e(number_format($discountedPrice, 0)); ?></span> /Pax</p>  
                   <div class="d-flex align-items-right gap-1 ms-1">
                      <a href="<?php echo e(route('frontend.tour.detail', $tour->slug)); ?>" class="book-btn-inline">
                                      View
                                    </a></div>
                    </div>
                  </div>      
                </div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center py-5">
              <p class="text-muted mb-0">No discounted tours at the moment. Check back soon for special offers.</p>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
    <!-- our teams starts -->
   
    <!-- our teams Ends -->

    <!-- recent-articles starts -->
       <section class="trending recent-articles pb-6">
      <div class="container">
        <div class="section-title mb-6 w-75 mx-auto text-center">
           <h4 class="mb-1 theme1">Our Blogs</h4>
          <h2 class="mb-1">Recent <span class="theme">Articles & Posts</span></h2>
         
        </div>
        <div class="recent-articles-inner">
          <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $blogs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="col-lg-4 col-md-6">
               <div class="trend-item box-shadow bg-white p-2 mb-4 rounded">
                <div class="trend-image rounded">
                    <img
                      src="<?php echo e($blog->image ? asset($blog->image) : asset('images/trending/trending10.jpg')); ?>"
                      alt="image"
                      
                    />
                  </div>
         <div class="trend-content-main p-2">
                  <div class="trend-content">
                         <div class="d-flex justify-content-between align-items-center py-1">
                      <span class="d-inline-flex align-items-center gap-1 fs-9"> <i class="icon-user theme"></i>  <?php echo e($blog->author ?: 'Blog'); ?> </span>
                      <span class="d-inline-flex align-items-center gap-1 fs-9"> <i class="icon-calendar theme"></i>     <?php echo e($blog->published_date->format('d M Y')); ?> </span>
                    </div>
     
                     <h5 class="mb-0">
                        <a href="<?php echo e(route('frontend.blog.detail', $blog->slug)); ?>">
                          <?php echo e(\Illuminate\Support\Str::limit($blog->title, 70)); ?>

                        </a>
                      </h5>
          <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-light">
        <a href="<?php echo e(route('frontend.blog.detail', $blog->slug)); ?>" class="book-btn-inline">
                                       Read More <i class="fa fa-long-arrow-alt-right"></i>
                                    </a>

                    </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <div class="col-12">
                <p class="text-center mb-0">No blogs found.</p>
              </div>
            <?php endif; ?>
          </div>
          <?php if(isset($blogs) && $blogs->count() > 0): ?>
          <div class="col-lg-12 text-center mt-4">
            <a href="<?php echo e(route('frontend.blogs')); ?>" class="nir-btn">View All Blogs <i class="fa fa-long-arrow-alt-right"></i></a>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <!-- recent-articles ends -->

    <!-- partner starts -->
  
    <!-- partner ends -->

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
<script>
document.addEventListener('DOMContentLoaded', function() {
  var destSelect = document.getElementById('search-destination');
  var travelSelect = document.getElementById('search-travel-type');
  var subcategoriesUrl = "<?php echo e(url('/front/get-subcategories')); ?>";
  var tourSearchUrl = "<?php echo e(route('frontend.tour')); ?>";

  function loadTravelTypes(parentId) {
    travelSelect.innerHTML = '<option value="">Travel Type</option>';
    travelSelect.disabled = true;
    if (!parentId) return;

    fetch(subcategoriesUrl + '/' + parentId)
      .then(function(r) { return r.json(); })
      .then(function(list) {
        travelSelect.disabled = false;
        list.forEach(function(item) {
          var opt = document.createElement('option');
          opt.value = item.id;
          opt.textContent = item.name;
          travelSelect.appendChild(opt);
        });
      })
      .catch(function() {
        travelSelect.disabled = false;
      });
  }

  if (destSelect) {
    destSelect.addEventListener('change', function() {
      loadTravelTypes(this.value || null);
    });
    if (destSelect.value) loadTravelTypes(destSelect.value);
  }

  var searchBtn = document.getElementById('search-submit');
  var searchForm = document.getElementById('holidaySearchForm');
  if (searchBtn && searchForm) {
    searchBtn.addEventListener('click', function() {
      var dest = document.getElementById('search-destination');
      var travel = document.getElementById('search-travel-type');
      var duration = searchForm.querySelector('select[name="tour_duration"]');
      var params = [];
      if (dest && dest.value) params.push('destination=' + encodeURIComponent(dest.value));
      if (travel && travel.value && !travel.disabled) params.push('travel_type=' + encodeURIComponent(travel.value));
      if (duration && duration.value) params.push('tour_duration=' + encodeURIComponent(duration.value));
      var url = tourSearchUrl + (params.length ? '?' + params.join('&') : '');
      window.location.href = url;
    });
  }
});
</script>
  </body>
</html>
<?php /**PATH C:\travel update website\working\resources\views/welcome.blade.php ENDPATH**/ ?>