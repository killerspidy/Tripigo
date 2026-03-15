<?php $__env->startSection('title','Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Welcome back  -->
        <div class="row m-b-30">
            <div class="col-lg-12">
                <div class="card bg-white" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-body p-30">
                        <div class="d-flex align-items-center">
                            <div class="m-r-25">
                                <div class="position-relative">
                                    <img src="<?php echo e(asset('images/user-avatar.jpg')); ?>" alt="user" width="80" height="80" class="rounded-circle user-avatar-mobile" style="object-fit: cover; border: 4px solid #f1f1f1;" />
                                    <span class="position-absolute" style="bottom: 5px; right: 5px; width: 15px; height: 15px; background: #28a745; border-radius: 50%; border: 3px solid #fff;"></span>
                                </div>
                            </div>
                            <div>
                                <h2 class="m-b-5 font-bold">Welcome back, <?php echo e(auth()->user()->name); ?>!</h2>
                                <p class="text-muted m-b-0"><i class="ti-calendar m-r-5"></i> <?php echo e(date('l, d F Y')); ?></p>
                            </div>
                            <div class="ml-auto d-none d-lg-block">
                                <a href="<?php echo e(route('logout')); ?>" class="btn btn-outline-danger btn-rounded px-4">
                                    <i class="ti-power-off m-r-5"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Summary -->
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center m-b-15">
                            <div class="bg-success text-white p-10 rounded-circle m-r-15 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="ti-shopping-cart font-20"></i>
                            </div>
                            <h6 class="card-subtitle m-b-0 text-muted font-medium">Total Products</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-between m-b-15">
                            <h2 class="m-b-0 font-bold" style="color: #2c3e50;">86</h2>
                            <span class="badge badge-pill badge-light-success text-success font-medium"><i class="ti-arrow-up"></i> 12.5%</span>
                        </div>
                        <div class="progress" style="height: 5px; background: rgba(0,0,0,0.03);">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 86%;" aria-valuenow="86" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center m-b-15">
                            <div class="bg-info text-white p-10 rounded-circle m-r-15 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="ti-timer font-20"></i>
                            </div>
                            <h6 class="card-subtitle m-b-0 text-muted font-medium">Pending Orders</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-between m-b-15">
                            <h2 class="m-b-0 font-bold" style="color: #2c3e50;">40</h2>
                            <span class="badge badge-pill badge-light-info text-info font-medium"><i class="ti-minus"></i> 0.0%</span>
                        </div>
                        <div class="progress" style="height: 5px; background: rgba(0,0,0,0.03);">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center m-b-15">
                            <div class="bg-danger text-white p-10 rounded-circle m-r-15 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="ti-package font-20"></i>
                            </div>
                            <h6 class="card-subtitle m-b-0 text-muted font-medium">Product A</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-between m-b-15">
                            <h2 class="m-b-0 font-bold" style="color: #2c3e50;">56</h2>
                            <span class="badge badge-pill badge-light-danger text-danger font-medium"><i class="ti-arrow-down"></i> 5.2%</span>
                        </div>
                        <div class="progress" style="height: 5px; background: rgba(0,0,0,0.03);">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 56%;" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center m-b-15">
                            <div class="bg-dark text-white p-10 rounded-circle m-r-15 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="ti-wallet font-20"></i>
                            </div>
                            <h6 class="card-subtitle m-b-0 text-muted font-medium">Revenue</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-between m-b-15">
                            <h2 class="m-b-0 font-bold" style="color: #2c3e50;">$1.2k</h2>
                            <span class="badge badge-pill badge-light-primary text-primary font-medium"><i class="ti-arrow-up"></i> 2.1%</span>
                        </div>
                        <div class="progress" style="height: 5px; background: rgba(0,0,0,0.03);">
                            <div class="progress-bar bg-dark" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row">
            <div class="col-lg-4">
                <div class="card bg-gradient-primary text-white" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                    <div class="card-body">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h4 class="card-title text-white">Bandwidth usage</h4>
                                <h6 class="text-white opacity-7"><?php echo e(date('F Y')); ?></h6>
                            </div>
                            <div class="ml-auto">
                                <i class="ti-pie-chart font-30 opacity-7"></i>
                            </div>
                        </div>
                        <div class="row m-t-30 align-items-center">
                            <div class="col-12">
                                <h1 class="font-bold text-white m-b-0">50 GB</h1>
                                <p class="text-white opacity-7 m-b-0">Current consumption</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card bg-gradient-info text-white" style="background: linear-gradient(135deg, #36b9cc 0%, #1a8a9a 100%);">
                    <div class="card-body">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h4 class="card-title text-white">Download count</h4>
                                <h6 class="text-white opacity-7"><?php echo e(date('F Y')); ?></h6>
                            </div>
                            <div class="ml-auto">
                                <i class="ti-download font-30 opacity-7"></i>
                            </div>
                        </div>
                        <div class="row m-t-30 align-items-center">
                            <div class="col-12">
                                <h1 class="font-bold text-white m-b-0">14,506</h1>
                                <p class="text-white opacity-7 m-b-0">Total downloads</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex no-block align-items-center m-b-20">
                            <h4 class="card-title m-b-0">Product Sale</h4>
                        </div>
                        <div id="visitor" style="height:223px; width:100%;"></div>
                        <div class="row m-t-30 m-b-15">
                            <div class="col-4 text-center">
                                <h4 class="m-b-0 font-bold">60%</h4>
                                <small class="text-muted">Iphone</small>
                            </div>
                            <div class="col-4 text-center">
                                <h4 class="m-b-0 font-bold">28%</h4>
                                <small class="text-muted">Samsung</small>
                            </div>
                            <div class="col-4 text-center">
                                <h4 class="m-b-0 font-bold">12%</h4>
                                <small class="text-muted">One+</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title m-b-0">Last Month Income</h4>
                        <div id="income" class="m-t-30" style="height: 280px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-success-transparent { background: rgba(40, 167, 69, 0.1); }
        .bg-info-transparent { background: rgba(23, 162, 184, 0.1); }
        .bg-danger-transparent { background: rgba(220, 53, 69, 0.1); }
        .bg-dark-transparent { background: rgba(52, 58, 64, 0.1); }
        .opacity-7 { opacity: 0.7; }
        .p-30 { padding: 30px !important; }
        .m-b-30 { margin-bottom: 30px !important; }
        .m-r-25 { margin-right: 25px !important; }
        .font-bold { font-weight: 700; }
        .btn-rounded { border-radius: 50px; }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Omkar Dhamdhere\Tejas Project Frelance\TripigoTales\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>