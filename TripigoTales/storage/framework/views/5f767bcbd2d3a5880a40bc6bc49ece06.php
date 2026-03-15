<?php echo $__env->make('frontend.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
.share-book-inline {
    margin: 15px 0;
}

.share-btn-inline {
    display: flex;
    align-items: center;
    padding: 10px 18px;
    border-radius: 50px;
    background: #f4f6f8;
}

.share-label {
    font-weight: 600;
    margin-right: 12px;
    color: #666;
}

.share-icons {
    display: flex;
    gap: 10px;
}

.share-icons .icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 15px;
    text-decoration: none;
    transition: 0.3s;
}

.share-icons .icon:hover {
    transform: scale(1.1);
}

.icon.fb { background: #1877F2; }
.icon.ig {
    background: linear-gradient(45deg, #f09433, #dc2743, #bc1888);
}
.icon.wa { background: #25D366; }

.book-btn-inline {
    padding: 12px 36px;
    border-radius: 50px;
    font-size: 17px;
    font-weight: 600;
    color: #fff;
    text-decoration: none;

    /* 🔥 NEW COLOR */
    background: linear-gradient(135deg, #0aa6a6, #0f766e);

    box-shadow: 0 8px 20px rgba(15, 118, 110, 0.35);
    transition: 0.3s;
}

.book-btn-inline:hover {
    transform: translateY(-2px);
    color: #fff;
    box-shadow: 0 12px 26px rgba(15, 118, 110, 0.45);
}



</style>
  
 <!-- BreadCrumb Starts -->  
<section class="breadcrumb-main pb-20 pt-14" 
    style="background-image: url('<?php echo e(asset('images/bg/bg1.jpg')); ?>');">
    
    <div class="section-shape section-shape1 top-inherit bottom-0" 
         style="background-image: url('<?php echo e(asset('images/shape8.png')); ?>');">
    </div>

    <div class="breadcrumb-outer">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <h1 class="mb-3">Tour Details</h1>
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(url('/')); ?>">Home</a>
                        </li>
                      
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="dot-overlay"></div>
</section>
<!-- BreadCrumb Ends -->

    <!-- top Destination starts -->
    <section class="trending pt-6 pb-0 bg-lgrey">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-content">
                        <div id="highlight">
                            <div class="single-full-title border-b mb-2 pb-2">
                                <div class="single-title">
                                    <h2 class="mb-1"><?php echo e($tour->title); ?></h2>
                                    <div class="rating-main d-md-flex align-items-center">
                                        <p class="mb-0 me-2"><i class="icon-location-pin"></i> <?php echo e($tour->location); ?></p>
                                        <div class="rating me-2">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <?php if($i <= $tour->star_rating): ?>
                                                    <span class="fa fa-star checked"></span>
                                                <?php else: ?>
                                                    <span class="fa-regular fa-star"></span>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="description-images mb-4">
                                <img src="<?php echo e($tour->image ? asset($tour->image) : asset('/images/trending/trending10.jpg')); ?>" alt="" class="w-100 rounded" width="700" height="430">
                            </div>
           <h5>Description:</h5>
                            <div class="description mb-2">
                             <p><?php echo $tour->description; ?></p>
                            </div>

                            <div class="tour-includes mb-4">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><i class="fa fa-home pink mr-1" aria-hidden="true"></i> <?php echo e($tour->tour_duration ?? 0); ?></td>
                                            <td><i class="fa fa-location pink mr-1" aria-hidden="true"></i> Stay Type : <?php echo e($tour->bedroom); ?></td>
                                            <td><i class="fa fa-file-alt pink mr-1" aria-hidden="true"></i><a href="<?php echo e(asset($tour->pdf)); ?>" target="_blank"> Itinerary</a></td>
                                       
                                        </tr>
                                        
                                        <tr>
                                            <td><i class="fa fa-user pink mr-1" aria-hidden="true"></i> Min Age : <?php echo e($tour->min_age); ?>+</td>
                                            <td><i class="fa fa-map-signs pink mr-1" aria-hidden="true"></i> Transportation : <?php echo e($tour->pickup); ?></td>
                                            <td><i class="fa fa-language pink mr-1" aria-hidden="true"></i> Language - <?php echo e($tour->language ?? '-'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="description mb-2">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 mb-2">
                                     <div class="desc-box bg-grey p-4 rounded">
                                        <h5 class="mb-2">Things to Carry</h5>
                                        <ul>
                                            <?php if(!empty($tour->day)): ?>
                                                <?php
                                                    $day = is_array($tour->day) 
                                                        ? $tour->day 
                                                        : explode(',', $tour->day);
                                                ?>
                                                <?php $__currentLoopData = $day; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="d-block pb-1">
                                                        <i class="fa fa-check pink mr-1"></i>
                                                        <?php echo e(is_string($item) ? trim($item) : $item); ?>

                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 mb-2">
                                      <div class="desc-box bg-grey p-4 rounded">
                                        <h5 class="mb-2">What to Expect</h5>
                                        <ul>
                                            <?php if(!empty($tour->what_to_expect)): ?>
                                                <?php
                                                    $whatToExpect = is_array($tour->what_to_expect) 
                                                        ? $tour->what_to_expect 
                                                        : explode(',', $tour->what_to_expect);
                                                ?>
                                                <?php $__currentLoopData = $whatToExpect; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="d-block pb-1">
                                                        <i class="fa fa-check pink mr-1"></i>
                                                        <?php echo e(is_string($item) ? trim($item) : $item); ?>

                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    </div>
                                  <div class="col-lg-6 col-md-6 mb-2">
                                    <div class="desc-box bg-grey p-4 rounded">
                                        <h5 class="mb-2">Inclusions</h5>
                                        <ul>
                                            <?php if(!empty($tour->price_includes)): ?>
                                                <?php
                                                    $priceIncludes = is_array($tour->price_includes) 
                                                        ? $tour->price_includes 
                                                        : explode(',', $tour->price_includes);
                                                ?>
                                                <?php $__currentLoopData = $priceIncludes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="d-block pb-1">
                                                        <i class="fa fa-check pink mr-1"></i>
                                                        <?php echo e(is_string($item) ? trim($item) : $item); ?>

                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>

                                   <div class="col-lg-6 col-md-6 mb-2">
                                    <div class="desc-box bg-grey p-4 rounded">
                                        <h5 class="mb-2">Exclusions</h5>
                                        <ul>
                                            <?php if(!empty($tour->departure_return_location)): ?>
                                                <?php
                                                    $departureLocations = is_array($tour->departure_return_location) 
                                                        ? $tour->departure_return_location 
                                                        : explode(',', $tour->departure_return_location);
                                                ?>
                                                <?php $__currentLoopData = $departureLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="d-block pb-1">
                                                        <i class="fa fa-times-circle  pink mr-1"></i>
                                                        <?php echo e(is_string($location) ? trim($location) : $location); ?>

                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <li>No departure/return location available</li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>

                                </div>
                            </div>

                        </div>
                        <?php
                            $plans = $tour->travel_plan ?? [];
                        ?>
                        <?php if(!empty($plans)): ?>
                        <div  id="iternary"  class="accrodion-grp faq-accrodion mb-4" data-grp-name="faq-accrodion"> <h5>Itinerary:</h5>
                          <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="accrodion <?php echo e($index === 0 ? 'active' : ''); ?>">
                                <div class="accrodion-title rounded">
                                     <h5 class="mb-0">
                                        <?php echo e($plan['question'] ?? 'Travel Plan'); ?>

                                     </h5>
                                </div>
                                <div class="accrodion-content">
                                    <div class="inner">
                                        <p><?php echo e($plan['answer'] ?? ''); ?></p>
                                    </div><!-- /.inner -->
                                </div>
                            </div>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </div>
                        <?php endif; ?>

                        <!-- <div  id="single-review" class="single-review mb-4">
                            <h4>Average Reviews</h4>
                            <div class="row d-flex align-items-center">
                                <div class="col-lg-4 col-md-4">
                                    <div class="review-box bg-title text-center py-4 p-2 rounded">
                                        <h2 class="mb-1 white"><span>2.2</span>/5</h2>
                                        <h4 class="white mb-1">"Feel so much worst than thinking"</h4>
                                        <p class="mb-0 white font-italic">From 40 Reviews</p>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8">
                                    <div class="review-progress">
                                        <div class="progress-item mb-1">
                                            <p class="mb-0">Cleanliness</p>
                                            <div class="progress rounded">
                                                <div class="progress-bar bg-theme" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
                                                    <span class="sr-only">40% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress-item mb-1">
                                            <p class="mb-0">Facilities</p>
                                            <div class="progress rounded">
                                                <div class="progress-bar bg-theme" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%">
                                                    <span class="sr-only">30% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress-item mb-1">
                                            <p class="mb-0">Value for money</p>
                                            <div class="progress rounded">
                                                <div class="progress-bar bg-theme" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:60%">
                                                    <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress-item mb-1">
                                            <p class="mb-0">Service</p>
                                            <div class="progress rounded">
                                                <div class="progress-bar bg-theme" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress-item">
                                            <p class="mb-0">Location</p>
                                            <div class="progress rounded">
                                                <div class="progress-bar bg-theme" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:45%">
                                                    <span class="sr-only">45% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                         <!-- our teams starts -->
                        <section class="offer_deals p-0"><h5>Attractions:</h5>
                        <div class="container">
                            <div class="deal-section row align-items-center">
                            

                            <!-- Right Black Section -->
                            <div class="deal-right col-lg-12">
                                <div class="deal-title mb-4">
                            
                                </div>
                                <div class="row promo-slider slick_arrows">
                                <?php
                                    $galleryImages = is_array($tour->gallery_images) ? $tour->gallery_images : [];
                                    // If no gallery images, show main image as fallback
                                    if (empty($galleryImages) && $tour->image) {
                                        $galleryImages = [$tour->image];
                                    }
                                ?>
                                
                                <?php $__empty_1 = true; $__currentLoopData = $galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $galleryImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if(!empty($galleryImage)): ?>
                                    <div class="card-deal p-3">
                                       
                                            <div class="box-shadow bg-white p-2 rounded">
                                                <img src="<?php echo e(asset($galleryImage)); ?>" class="rounded" alt="<?php echo e($tour->title); ?>" style="width: 100%; height: 200px; object-fit: cover;" />
                                              
                                            </div>
                                    
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    
                                    <?php if($tour->image): ?>
                                    <div class="card-deal p-3">
                                        <a href="<?php echo e(route('frontend.tour.detail', $tour->slug)); ?>">
                                            <div class="box-shadow bg-white p-2 rounded">
                                                <img src="<?php echo e(asset($tour->image)); ?>" class="rounded" alt="<?php echo e($tour->title); ?>" style="width: 100%; height: 200px; object-fit: cover;" />
                                                <div class="card-body-deal d-flex justify-content-between align-items-center mt-2">
                                                    <div>
                                                        <h5 class="mb-1"><?php echo e(mb_strlen($tour->title) > 20 ? mb_substr($tour->title, 0, 20) . '...' : $tour->title); ?></h5>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                </div>
                            </div>
                            </div>
                        </div>
                        </section>
                        <!-- our teams Ends -->


                        <!-- Reviews Section -->
                        <div id="single-review" class="single-comments single-box mb-4">
                            <h5 class="border-b pb-2 mb-2">
                                Showing <?php echo e($reviews->count()); ?> verified guest <?php echo e($reviews->count() == 1 ? 'comment' : 'comments'); ?>

                            </h5>
                            
                            <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="comment-box mb-3">
                                <div class="comment-image">
                                    <?php if($review->user && $review->user->avatar): ?>
                                        <img src="<?php echo e($review->user->avatar); ?>" alt="<?php echo e($review->name); ?>" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                                    <?php else: ?>
                                        <div style="width: 60px; height: 60px; border-radius: 50%; background: #18a9a1; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold; font-size: 20px;">
                                            <?php echo e(strtoupper(substr($review->name, 0, 1))); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="comment-content rounded">
                                    <h5 class="mb-1"><?php echo e($review->name); ?></h5>
                                    <p class="comment-date"><?php echo e($review->created_at->format('F d, Y \a\t g:i a')); ?></p>
                                    <div class="comment-rate">
                                        <div class="rating mar-right-15">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <?php if($i <= $review->rating): ?>
                                                    <span class="fa fa-star checked"></span>
                                                <?php else: ?>
                                                    <span class="fa-regular fa-star"></span>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>    
                                    
                                    <p class="comment"><?php echo e($review->comment); ?></p>
                                    
                                    <?php if($review->admin_reply): ?>
                                    <div class="admin-reply bg-light p-3 rounded mt-2 mb-2" style="border-left: 3px solid #18a9a1;">
                                        <strong>Admin Reply:</strong>
                                        <p class="mb-0"><?php echo e($review->admin_reply); ?></p>
                                    </div>
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-muted">No reviews yet. Be the first to review this tour!</p>
                            <?php endif; ?>
                        </div>

                        <!-- Write A Review Form - Only visible if user is logged in -->
                        <?php if(auth()->guard('user')->check()): ?>
                        <div id="single-add-review" class="single-add-review">
                            <h4>Write A Review</h4>
                            
                            <?php if(session('success')): ?>
                                <div class="alert alert-success mb-3">
                                    <?php echo e(session('success')); ?>

                                </div>
                            <?php endif; ?>
                            
                            <?php if(session('error')): ?>
                                <div class="alert alert-danger mb-3">
                                    <?php echo e(session('error')); ?>

                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" action="<?php echo e(route('frontend.review.submit')); ?>" class="no-prevent-default">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="tour_id" value="<?php echo e($tour->id); ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <input type="text" name="name" placeholder="Name" value="<?php echo e(auth('user')->user()->name); ?>" required>
                                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <small class="text-danger"><?php echo e($message); ?></small>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <input type="email" name="email" placeholder="Email" value="<?php echo e(auth('user')->user()->email); ?>" required>
                                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <small class="text-danger"><?php echo e($message); ?></small>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-2">
                                            <label class="mb-2">Rating</label>
                                            <div class="rating-input mb-2">
                                                <input type="radio" name="rating" id="star5" value="5">
                                                <label for="star5" class="fa-regular fa-star"></label>

                                                <input type="radio" name="rating" id="star4" value="4">
                                                <label for="star4" class="fa-regular fa-star"></label>

                                                <input type="radio" name="rating" id="star3" value="3">
                                                <label for="star3" class="fa-regular fa-star"></label>

                                                <input type="radio" name="rating" id="star2" value="2">
                                                <label for="star2" class="fa-regular fa-star"></label>

                                                <input type="radio" name="rating" id="star1" value="1">
                                                <label for="star1" class="fa-regular fa-star"></label>
                                            </div>

                                            <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <small class="text-danger d-block"><?php echo e($message); ?></small>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-2">
                                            <textarea name="comment" placeholder="Comment" rows="5" required><?php echo e(old('comment')); ?></textarea>
                                            <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <small class="text-danger"><?php echo e($message); ?></small>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-btn">
                                            <button type="submit" class="nir-btn">Submit Review</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php else: ?>
                        <div class="single-add-review text-center p-4 bg-light rounded">
                            <p class="mb-3">Please <a href="<?php echo e(route('frontend.login')); ?>">login</a> to write a review.</p>
                        </div><br>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-4 ps-lg-4">
                    <div class="sidebar-sticky sticky1">
                        
   <?php
    $tourUrl = url()->current();
    $shareText = urlencode("Check out this amazing tour: {$tour->title}");
?>

<div class="share-book-inline d-flex align-items-center gap-3 flex-wrap">

    
    <div class="share-btn-inline">
        <span class="share-label">Share</span>

        <div class="share-icons">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e($tourUrl); ?>"
               target="_blank" class="icon fb">
                <i class="fab fa-facebook-f"></i>
            </a>

            <a href="javascript:void(0)"
               onclick="copyToClipboard('<?php echo e($tourUrl); ?>'); alert('Link copied for Instagram');"
               class="icon ig">
                <i class="fab fa-instagram"></i>
            </a>

            <a href="https://wa.me/?text=<?php echo e($shareText); ?>%20<?php echo e($tourUrl); ?>"
               target="_blank" class="icon wa">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </div>

    
    <a href="<?php echo e(route('frontend.tour.book', $tour->slug)); ?>" class="book-btn-inline">
        Book Now
    </a>

</div>




                        <div class="tabs-navbar bg-lgrey mb-4 bordernone rounded overflow-hidden">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul id="tabs" class="nav nav-tabs bordernone mb-0">
                                        <li class="active">
                                            <a data-toggle="tab" href="#highlight" class="rounded box-shadow mb-2 border-all">Highlight</a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#iternary" class="rounded box-shadow mb-2 border-all">Iternary</a>
                                        </li>
                                  
                                        <li>
                                            <a data-toggle="tab" href="#single-review" class="rounded box-shadow mb-2 border-all" onclick="document.getElementById('single-review').scrollIntoView({behavior: 'smooth'});">Reviews</a>
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
    <!-- top Destination ends -->

    <!-- Discount action starts -->
    
    <!-- partner ends -->
    <!-- footer starts -->
 <?php echo $__env->make('frontend.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- footer ends -->



   <!-- *Scripts* -->
<script src="<?php echo e(asset('js/jquery-3.5.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>

<!-- <script src="<?php echo e(asset('js/fontawesome.min.js')); ?>"></script> -->
<script src="<?php echo e(asset('js/particles.js')); ?>"></script>
<script src="<?php echo e(asset('js/particlerun.js')); ?>"></script>
<script src="<?php echo e(asset('js/plugin.js')); ?>"></script>
<script src="<?php echo e(asset('js/main.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-swiper.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-nav.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-accordian.js')); ?>"></script>


<script>
function copyToClipboard(text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() {
            console.log('Link copied to clipboard');
        });
    } else {
        // Fallback for older browsers
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            console.log('Link copied to clipboard');
        } catch (err) {
            console.error('Failed to copy:', err);
        }
        document.body.removeChild(textArea);
    }
}
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.rating-input input');
    const labels = document.querySelectorAll('.rating-input label');

    function updateStars(value) {
        labels.forEach((label, index) => {
            const starValue = 5 - index;
            if (starValue <= value) {
                label.classList.remove('fa-regular');
                label.classList.add('fa-solid');
            } else {
                label.classList.remove('fa-solid');
                label.classList.add('fa-regular');
            }
        });
    }

    inputs.forEach(input => {
        input.addEventListener('change', function () {
            updateStars(this.value);
        });
    });
});
</script>


<style>
.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 8px;
    align-items: center;
}
.rating-input input[type="radio"] {
    display: none;
}
.rating-input label {
    cursor: pointer;
    font-size: 24px;
    color: #ddd;
    transition: color 0.2s;
    user-select: none;
}
.rating-input label:hover {
    color: #ffc107 !important;
}
.rating-input label.fas {
    color: #ffc107;
}
.rating-input label.far {
    color: #ddd;
}
</style>
  </body>
</html>
<?php /**PATH C:\travel update website\working\resources\views/frontend/tourDetails.blade.php ENDPATH**/ ?>