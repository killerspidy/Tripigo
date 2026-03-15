 <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin1" style="display: flex !important; flex-direction: row !important; align-items: center !important; flex-wrap: nowrap !important;">
                    <!-- Logo + Title (always visible) -->
                    <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('admin.dashboard')); ?>" style="flex: 1; min-width: 0;">
                        <b class="logo-icon flex-shrink-0">
                            <img src="<?php echo e(asset('images/favicon.png')); ?>" alt="homepage" class="dark-logo" style="height: 35px !important; width: auto !important; max-width: 35px;" />
                        </b>
                        <span class="text-white font-bold m-l-10" style="font-size: 1.1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Admin Dashboard</span>
                    </a>
                    <!-- Mobile: expanded topbar toggler -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light flex-shrink-0" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                    <!-- Mobile: sidebar toggler (hamburger) -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none flex-shrink-0" href="javascript:void(0)">
                        <i class="ti-menu"></i>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                                <i class="sl-icon-menu font-20"></i>
                            </a>
                        </li>


                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="m-r-10 d-none d-md-block text-muted font-medium"><?php echo e(auth()->user()->name); ?></span>
                                    <img src="<?php echo e(asset('images/user-avatar.jpg')); ?>" alt="user" class="rounded-circle" width="35" height="35" style="object-fit: cover; border: 2px solid #eee;">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10" style="border-radius: 12px 12px 0 0;">
                                    <div class="m-r-10">
                                        <img src="<?php echo e(asset('images/user-avatar.jpg')); ?>" alt="user" class="img-circle" width="60" height="60" style="object-fit: cover; border: 2px solid rgba(255,255,255,0.2);">
                                    </div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0 text-white"><?php echo e(auth()->user()->name); ?></h4>
                                        <p class=" m-b-0 opacity-7 text-white" style="font-size: 0.85rem;"><?php echo e(auth()->user()->email); ?></p>
                                    </div>
                                </div>
                                <a class="dropdown-item p-10" href="<?php echo e(route('logout')); ?>">
                                    <i class="fa fa-power-off m-r-10 m-l-5 text-danger"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header><?php /**PATH C:\new travel\resources\views/admin/partials/header.blade.php ENDPATH**/ ?>