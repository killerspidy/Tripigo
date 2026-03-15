<?php echo $__env->make('frontend.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  
<!-- BreadCrumb Starts -->  
    <section class="breadcrumb-main pb-20 pt-14" style="background-image: url(images/bg/bg1.jpg);">
        <div class="section-shape section-shape1 top-inherit bottom-0" style="background-image: url(images/shape8.png);"></div>
        <div class="breadcrumb-outer">
            <div class="container">
                <div class="breadcrumb-content text-center">
                    <h1 class="mb-3">Gallery One</h1>
                    <nav aria-label="breadcrumb" class="d-block">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Gallery One</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="dot-overlay"></div>
    </section>
    <!-- BreadCrumb Ends --> 

    <!-- Gallery starts -->
    <div class="gallery pt-6 pb-0">
        <div class="container">
            <div class="section-title mb-6 text-center w-75 mx-auto">
                <h4 class="mb-1 theme1">Our Gallery</h4>
                <h2 class="mb-1">Some Beautiful <span class="theme">Snapshoots</span></h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
            </div>
            <?php if(isset($galleries) && $galleries->count() > 0): ?>
              <div class="list-results d-flex align-items-center justify-content-between mb-4">
                  <div class="list-results-sort">
                      <p class="m-0">
                          Showing <?php echo e($galleries->firstItem() ?? 0); ?>-<?php echo e($galleries->lastItem() ?? 0); ?> of <?php echo e($galleries->total()); ?> photos
                      </p>
                  </div>
              </div>
            <?php endif; ?>
            <div class="row">
                <?php $__empty_1 = true; $__currentLoopData = $galleries ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <?php
                    $img = $gallery->image ? asset($gallery->image) : asset('images/trending/trending1.jpg');
                  ?>
                  <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                      <div class="gallery-item mb-4 rounded overflow-hidden">
                          <div class="gallery-image">
                              <img src="<?php echo e($img); ?>" alt="image" style="width:100%; height:300px; object-fit:cover;">
                          </div>
                          <div class="gallery-content">
                              <h5 class="white text-center position-absolute bottom-0 pb-4 left-50 mb-0 w-100">
                                  <?php echo e($gallery->title); ?>

                              </h5>
                              <ul>
                                  <li>
                                      <a href="<?php echo e($img); ?>" data-lightbox="gallery" data-title="<?php echo e($gallery->title); ?>">
                                          <i class="fa fa-eye"></i>
                                      </a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <div class="col-12">
                      <div class="text-center py-5">
                          <h3 class="mb-3">No Gallery Photos Found</h3>
                          <p class="mb-0">Please add photos from Admin → Galleries.</p>
                      </div>
                  </div>
                <?php endif; ?>
            </div>
            <?php if(isset($galleries) && method_exists($galleries, 'hasPages') && $galleries->hasPages()): ?>
              <div class="row mt-4">
                <div class="col-12 text-center">
                  <?php echo e($galleries->links()); ?>

                </div>
              </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Gallery Ends -->

   <!-- Discount action starts -->
    <section class="discount-action pt-0" style="background-image:url(images/section-bg1.png); background-position:center;">
        <div class="container">
            <div class="call-banner rounded pt-10 pb-14">
                <div class="call-banner-inner w-75 mx-auto text-center px-5">
                    <div class="trend-content-main">
                        <div class="trend-content mb-5 pb-2 px-5">
                            <h5 class="mb-1 theme">Love Where Your're Going</h5>
                            <h2><a href="detail-fullwidth.html">Explore Your Life, <span class="theme1"> Travel Where You Want!</span></a></h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                        <div class="video-button text-center position-relative">
                             <div class="call-button text-center">
                                <button type="button" class="play-btn js-video-button" data-video-id="152879427" data-channel="vimeo">
                                    <i class="fa fa-play bg-blue"></i>
                                </button>
                            </div>
                            <div class="video-figure"></div>
                        </div>
                    </div>
                </div>
            </div>     
        </div>    
        <div class="white-overlay"></div>
        <div class="white-overlay"></div>
        <div class="section-shape  top-inherit bottom-0" style="background-image: url(images/shape6.png);"></div>
    </section>
    <!-- Discount action Ends -->

    <!-- partner starts -->
    <section class="our-partner pb-6 pt-6">
        <div class="container">
            <div class="section-title mb-6 w-75 mx-auto text-center">
                <h4 class="mb-1 theme1">Our Partners</h4>
                <h2 class="mb-1">Our Awesome <span class="theme">partners</span></h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
            </div>
            <div class="row align-items-center partner-in partner-slider">
                <div class="col-md-3 col-sm-6">
                    <div class="partner-item p-4 py-2 rounded bg-lgrey">
                        <img src="images/cl-1.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="partner-item p-4 py-2 rounded bg-lgrey">
                        <img src="images/cl-5.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="partner-item p-4 py-2 rounded bg-lgrey">
                        <img src="images/cl-2.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="partner-item p-4 py-2 rounded bg-lgrey">
                        <img src="images/cl-3.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="partner-item p-4 py-2 rounded bg-lgrey">
                        <img src="images/cl-4.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="partner-item p-4 py-2 rounded bg-lgrey">
                        <img src="images/cl-5.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- partner ends -->
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
<?php /**PATH C:\travel update website\working\resources\views/frontend/gallery.blade.php ENDPATH**/ ?>