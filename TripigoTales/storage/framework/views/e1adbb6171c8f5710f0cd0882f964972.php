<?php echo $__env->make('frontend.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  
 <!-- BreadCrumb Starts -->  
<section class="breadcrumb-main pb-20 pt-14" 
    style="background-image: url('<?php echo e(asset('images/bg/bg1.jpg')); ?>');">
    
    <div class="section-shape section-shape1 top-inherit bottom-0" 
         style="background-image: url('<?php echo e(asset('images/shape8.png')); ?>');">
    </div>

    <div class="breadcrumb-outer">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <h1 class="mb-3">Blog Details</h1>
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(url('/')); ?>">Home</a>
                        </li>
                         <li class="breadcrumb-item">
                            <a href="<?php echo e(route('frontend.blogs')); ?>">Blogs</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?php echo e($blog->title); ?>

                        </li>
                     
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="dot-overlay"></div>
</section>
<!-- BreadCrumb Ends -->
    <!-- Blog Detail starts -->
    <section class="trending pt-6 pb-6 bg-lgrey">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="trend-item rounded box-shadow bg-white p-4">
                        <?php if($blog->image): ?>
                        <div class="trend-image mb-4">
                            <img 
                                src="<?php echo e(asset($blog->image)); ?>" 
                                alt="<?php echo e($blog->title); ?>" 
                                style="width:100%; height:400px; object-fit:cover; border-radius:8px;"
                            />
                        </div>
                        <?php endif; ?>

                        <div class="trend-meta bg-theme white px-3 py-2 rounded mb-3 d-inline-block mt-4">
                            <div class="entry-author">
                                <i class="icon-calendar"></i>
                                <span class="fw-bold">
                                    <?php if($blog->published_date): ?>
                                        <?php echo e($blog->published_date->format('d M Y')); ?>

                                    <?php else: ?>
                                        <?php echo e($blog->created_at->format('d M Y')); ?>

                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>

                        <?php if($blog->author): ?>
                            <h5 class="theme mb-3"><i class="icon-user"></i> <?php echo e($blog->author); ?></h5>
                        <?php endif; ?>

                        <h2 class="mb-3"><?php echo e($blog->title); ?></h2>

                        <?php if($blog->description): ?>
                            <div class="blog-content" style="line-height: 1.8; font-size: 16px;">
                                <?php echo $blog->description; ?>

                            </div>
                        <?php endif; ?>

                        <div class="mt-4 pt-4 border-top d-flex justify-content-between align-items-center">
                            <a href="<?php echo e(route('frontend.blogs')); ?>" class="nir-btn">
                                <i class="fa fa-arrow-left"></i> Back to Blogs
                            </a>
                            <div class="social-share">
                                <?php
                                    $blogUrl = route('frontend.blog.detail', $blog->slug);
                                    $shareText = urlencode("Check out this amazing blog: {$blog->title}");
                                ?>
                                <a href="https://wa.me/?text=<?php echo e($shareText); ?> <?php echo e($blogUrl); ?>" 
                                   target="_blank" 
                                   class="btn btn-sm btn-primary me-1">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar-sticky">
                        <div class="trend-item rounded box-shadow bg-white p-4 mb-4">
                            <h4 class="mb-3">Recent Blogs</h4>
                            <?php
                                $recentBlogs = collect();
                                if (\Illuminate\Support\Facades\Schema::hasTable('blogs')) {
                                    $recentBlogs = \App\Models\Blog::where('status', 1)
                                        ->where('id', '!=', $blog->id)
                                        ->latest()
                                        ->take(5)
                                        ->get();
                                }
                            ?>
                            <?php $__empty_1 = true; $__currentLoopData = $recentBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="mb-3 pb-3 border-bottom">
                                    <h6 class="mb-1">
                                        <a href="<?php echo e(route('frontend.blog.detail', $recent->slug)); ?>">
                                            <?php echo e(\Illuminate\Support\Str::limit($recent->title, 50)); ?>

                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <?php if($recent->published_date): ?>
                                            <?php echo e($recent->published_date->format('d M Y')); ?>

                                        <?php else: ?>
                                            <?php echo e($recent->created_at->format('d M Y')); ?>

                                        <?php endif; ?>
                                    </small>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-muted mb-0">No recent blogs</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Detail Ends -->

<?php echo $__env->make('frontend.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
<?php /**PATH C:\travel update website\working\resources\views/frontend/blogDetail.blade.php ENDPATH**/ ?>