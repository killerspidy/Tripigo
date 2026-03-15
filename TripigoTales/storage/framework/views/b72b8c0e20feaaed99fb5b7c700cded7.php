  <aside class="left-sidebar">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <?php if(auth()->user()->can('view dashboard')): ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('admin.dashboard')); ?>" aria-expanded="false">
                                    <i class="icon-Car-Wheel"></i>
                                    <span class="hide-menu">Dashboards </span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('view categories')): ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                       aria-expanded="false">
                                    <i class="icon-Box"></i>
                                    <span class="hide-menu">Categories</span>
                                </a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <li class="sidebar-item">
                                        <a href="<?php echo e(route('categories.index')); ?>" class="sidebar-link">
                                            <i class="mdi mdi-folder"></i>
                                            <span class="hide-menu">Categories (Destinations)</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="<?php echo e(route('subcategories.index')); ?>" class="sidebar-link">
                                            <i class="mdi mdi-folder-multiple"></i>
                                            <span class="hide-menu">Subcategories (Travel Types)</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('view tours')): ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('tours.index')); ?>" aria-expanded="false">
                                    <i class="icon-Map"></i>
                                    <span class="hide-menu">Tours </span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('view tasks')): ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('tasks.index')); ?>" aria-expanded="false">
                                    <i class="icon-Check"></i>
                                    <span class="hide-menu">Tasks</span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('view blogs')): ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('blogs.index')); ?>" aria-expanded="false">
                                    <i class="icon-Book"></i>
                                    <span class="hide-menu">Blogs </span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('view galleries')): ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('galleries.index')); ?>" aria-expanded="false">
                                    <i class="icon-Photo"></i>
                                    <span class="hide-menu">Galleries </span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('view sliders')): ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('sliders.index')); ?>" aria-expanded="false">
                                    <i class="mdi mdi-creation"></i>
                                    <span class="hide-menu">Sliders </span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('view testimonials')): ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('testimonials.index')); ?>" aria-expanded="false">
                                    <i class="icon-Shopping-Bag"></i>
                                    <span class="hide-menu">Testimonials </span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('view coupons')): ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('coupons.index')); ?>" aria-expanded="false">
                                    <i class="icon-Receipt-2"></i>
                                    <span class="hide-menu">Coupons </span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('view coupons')): ?>
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('admin.faq.inquiries')); ?>" aria-expanded="false">
                                        <i class="mdi mdi-apple-safari"></i>
                                        <span class="hide-menu">Faq Inquiries</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('view contact inquiries')): ?>
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('admin.contact-us.index')); ?>" aria-expanded="false">
                                        <i class="icon-Map"></i>
                                        <span class="hide-menu">Contact Us</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('view reviews')): ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('reviews.index')); ?>" aria-expanded="false">
                                    <i class="icon-Star"></i>
                                    <span class="hide-menu">Reviews</span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('admin.bookings.index')); ?>" aria-expanded="false">
                                    <i class="icon-Receipt"></i>
                                    <span class="hide-menu">Bookings</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('addons.index')); ?>" aria-expanded="false">
                                    <i class="icon-Files"></i>
                                    <span class="hide-menu">Add-ons</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark" href="<?php echo e(route('settings.index')); ?>" aria-expanded="false">
                                    <i class="icon-Settings"></i>
                                    <span class="hide-menu">Global Settings</span>
                                </a>
                            </li>

                            <?php if(auth()->user()->can('view users') || auth()->user()->can('view roles')): ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                       aria-expanded="false">
                                    <i class="icon-Add-User"></i>
                                    <span class="hide-menu">Users</span>
                                </a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <?php if(auth()->user()->can('view users')): ?>
                                    <li class="sidebar-item">
                                        <a href="<?php echo e(route('users.index')); ?>" class="sidebar-link">
                                            <i class="mdi mdi-account-box"></i>
                                            <span class="hide-menu">Users</span>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(auth()->user()->can('view roles')): ?>
                                    <li class="sidebar-item">
                                        <a href="<?php echo e(route('roles.index')); ?>" class="sidebar-link">
                                            <i class="mdi mdi-account-network"></i>
                                            <span class="hide-menu">Roles</span>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->

                <!-- Sidebar footer-->
                <div class="sidebar-footer bg-dark">
                    <a href="<?php echo e(route('logout')); ?>" class="sidebar-link waves-effect bg-dark text-danger font-bold d-flex align-items-center" title="Logout">
                        <i class="ti-power-off m-r-10"></i>
                        <span class="hide-menu">Logout</span>
                    </a>
                </div>
                <!-- End Sidebar footer-->
        </aside><?php /**PATH C:\new travel\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>