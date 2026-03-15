<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Travelin - Travel Tour Booking HTML Templates</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('images/favicon.png')); ?>" />

<!-- Bootstrap core CSS -->
<link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />

<!-- Custom CSS -->
<link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet" type="text/css" />

<!-- Plugin CSS -->
<link href="<?php echo e(asset('css/plugin.css')); ?>" rel="stylesheet" type="text/css" />

<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo e(asset('css/fontawesome.min.css')); ?>" />

<!-- Line Icons -->
<link rel="stylesheet" href="<?php echo e(asset('fonts/line-icons.css')); ?>" type="text/css" />

  </head>
<body>
  <!-- Preloader -->
    <div id="preloader" style="display: none !important;">
      <div id="status" style="display: none !important;"></div>
    </div>
    <!-- Preloader Ends -->
<?php echo $__env->make('frontend.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<main style="padding:20px;">
    <?php echo $__env->yieldContent('content'); ?>
</main>

<?php echo $__env->make('frontend.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- *Scripts* -->
<script src="<?php echo e(asset('js/jquery-3.5.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/fontawesome.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/particles.js')); ?>"></script>
<script src="<?php echo e(asset('js/particlerun.js')); ?>"></script>
<script src="<?php echo e(asset('js/plugin.js')); ?>"></script>
<script src="<?php echo e(asset('js/main.js')); ?>?v=2"></script>
<script src="<?php echo e(asset('js/custom-swiper.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-nav.js')); ?>"></script>

</body>
</html>
<?php /**PATH C:\travel update website\working\resources\views/frontend/layouts/app.blade.php ENDPATH**/ ?>