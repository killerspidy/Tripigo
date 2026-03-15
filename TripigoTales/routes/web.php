<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FrontendAuthController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\PaymentController;
use App\Models\Category;

// login
Route::redirect('/login', '/');
Route::get('/login413216',[AuthController::class,'loginForm'])->name('login');
Route::post('/login413216',[AuthController::class,'login'])->middleware('throttle:5,1');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

// public routes
Route::get('front/get-subcategories/{id}', function($id){
    $list = Category::where('status', 1)->where('parent_id', $id)->orderBy('name')->get(['id', 'name']);
    return response()->json($list);
})->name('public.get.subcategories');

Route::middleware(['auth','role:admin|employee|user'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('admin/faq-inquiries', [GalleryController::class, 'feqList'])->name('admin.faq.inquiries');
    Route::get('admin/contact-us', [GalleryController::class, 'contactUsIndex'])->name('admin.contact-us.index');

    // Task Routes
    Route::get('admin/tasks', [TaskController::class, 'index'])->name('tasks.index')->middleware('permission:view tasks');
    Route::get('admin/tasks/create', [TaskController::class, 'create'])->name('tasks.create')->middleware('permission:create tasks');
    Route::post('admin/tasks/store', [TaskController::class, 'store'])->name('tasks.store')->middleware('permission:create tasks');
    Route::get('admin/tasks/edit/{id}', [TaskController::class, 'edit'])->name('tasks.edit')->middleware('permission:edit tasks');
    Route::post('admin/tasks/update/{id}', [TaskController::class, 'update'])->name('tasks.update')->middleware('permission:edit tasks');
    Route::delete('admin/tasks/delete/{id}', [TaskController::class, 'destroy'])->name('tasks.delete')->middleware('permission:delete tasks');

    // Categories (Parent Categories Only)
    Route::get('admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('admin/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('admin/categories/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('admin/categories/update/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('admin/categories/delete/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Subcategories (Child Categories)
    Route::get('admin/subcategories', [CategoryController::class, 'subcategoriesIndex'])->name('subcategories.index');
    Route::get('admin/subcategories/create', [CategoryController::class, 'subcategoriesCreate'])->name('subcategories.create');
    Route::post('admin/subcategories/store', [CategoryController::class, 'subcategoriesStore'])->name('subcategories.store');
    Route::get('admin/subcategories/edit/{category}', [CategoryController::class, 'subcategoriesEdit'])->name('subcategories.edit');
    Route::put('admin/subcategories/update/{category}', [CategoryController::class, 'subcategoriesUpdate'])->name('subcategories.update');
    Route::delete('admin/subcategories/delete/{category}', [CategoryController::class, 'subcategoriesDestroy'])->name('subcategories.destroy');

    Route::get('admin/tours', [TourController::class, 'index'])->name('tours.index');
    Route::get('admin/tours/create',[TourController::class,'create'])->name('tours.create');
    Route::post('admin/tours/store', [TourController::class,'store'])->name('tours.store');
    Route::get('admin/tours/edit/{slug}', [TourController::class, 'edit'])->name('tours.edit');
    Route::put('admin/tours/update/{slug}', [TourController::class, 'update'])->name('tours.update');

    Route::delete('admin/tours/delete/{slug}', [TourController::class, 'destroy'])->name('tours.delete');
    Route::get('admin/tours/export-archive', [TourController::class, 'exportArchive'])->name('tours.export-archive');
    Route::post('admin/tours/import-archive', [TourController::class, 'importArchive'])->name('tours.import-archive');

    Route::get('admin/get-subcategories/{id}', function($id){
        return Category::where('parent_id',$id)->get();
    })->name('frontend.subcategories');

    // Blog Routes
    Route::get('admin/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('admin/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('admin/blogs/store', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('admin/blogs/edit/{slug}', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('admin/blogs/update/{slug}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('admin/blogs/delete/{slug}', [BlogController::class, 'destroy'])->name('blogs.delete');
    Route::get('admin/blogs/export', [BlogController::class, 'export'])->name('blogs.export');
    Route::post('admin/blogs/import', [BlogController::class, 'import'])->name('blogs.import');
    Route::get('admin/blogs/export-archive', [BlogController::class, 'exportArchive'])->name('blogs.export-archive');
    Route::post('admin/blogs/import-archive', [BlogController::class, 'importArchive'])->name('blogs.import-archive');

    // Gallery Routes
    Route::get('admin/galleries', [GalleryController::class, 'index'])->name('galleries.index');
    Route::get('admin/galleries/create', [GalleryController::class, 'create'])->name('galleries.create');
    Route::post('admin/galleries/store', [GalleryController::class, 'store'])->name('galleries.store');
    Route::get('admin/galleries/edit/{id}', [GalleryController::class, 'edit'])->name('galleries.edit');
    Route::put('admin/galleries/update/{id}', [GalleryController::class, 'update'])->name('galleries.update');
    Route::delete('admin/galleries/delete/{id}', [GalleryController::class, 'destroy'])->name('galleries.delete');

    // Slider Routes
    Route::get('admin/sliders', [SliderController::class, 'index'])->name('sliders.index')->middleware('permission:view sliders');
    Route::get('admin/sliders/create', [SliderController::class, 'create'])->name('sliders.create')->middleware('permission:create sliders');
    Route::post('admin/sliders/store', [SliderController::class, 'store'])->name('sliders.store')->middleware('permission:create sliders');
    Route::get('admin/sliders/edit/{id}', [SliderController::class, 'edit'])->name('sliders.edit')->middleware('permission:edit sliders');
    Route::put('admin/sliders/update/{id}', [SliderController::class, 'update'])->name('sliders.update')->middleware('permission:edit sliders');
    Route::delete('admin/sliders/delete/{id}', [SliderController::class, 'destroy'])->name('sliders.delete')->middleware('permission:delete sliders');

    // Testimonial Routes
    Route::get('admin/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index')->middleware('permission:view testimonials');
    Route::get('admin/testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create')->middleware('permission:create testimonials');
    Route::post('admin/testimonials/store', [TestimonialController::class, 'store'])->name('testimonials.store')->middleware('permission:create testimonials');
    Route::get('admin/testimonials/edit/{id}', [TestimonialController::class, 'edit'])->name('testimonials.edit')->middleware('permission:edit testimonials');
    Route::put('admin/testimonials/update/{id}', [TestimonialController::class, 'update'])->name('testimonials.update')->middleware('permission:edit testimonials');
    Route::delete('admin/testimonials/delete/{id}', [TestimonialController::class, 'destroy'])->name('testimonials.delete')->middleware('permission:delete testimonials');

    // Coupon Routes
    Route::get('admin/coupons', [CouponController::class, 'index'])->name('coupons.index')->middleware('permission:view coupons');
    Route::get('admin/coupons/create', [CouponController::class, 'create'])->name('coupons.create')->middleware('permission:create coupons');
    Route::post('admin/coupons/store', [CouponController::class, 'store'])->name('coupons.store')->middleware('permission:create coupons');
    Route::get('admin/coupons/edit/{id}', [CouponController::class, 'edit'])->name('coupons.edit')->middleware('permission:edit coupons');
    Route::put('admin/coupons/update/{id}', [CouponController::class, 'update'])->name('coupons.update')->middleware('permission:edit coupons');
    Route::delete('admin/coupons/delete/{id}', [CouponController::class, 'destroy'])->name('coupons.delete')->middleware('permission:delete coupons');

    // User Management Routes (require view users permission)
    Route::middleware(['permission:view users'])->group(function () {
        Route::get('admin/users', [UserController::class, 'index'])->name('users.index');
        Route::get('admin/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('admin/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('admin/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('admin/users/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('admin/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
    });

    // Role Management Routes (require view roles permission)
    Route::middleware(['permission:view roles'])->group(function () {
        Route::get('admin/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('admin/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('admin/roles/store', [RoleController::class, 'store'])->name('roles.store');
        Route::get('admin/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('admin/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('admin/roles/delete/{id}', [RoleController::class, 'destroy'])->name('roles.delete');
    });

    // Review Management Routes (require view reviews permission)
    Route::middleware(['permission:view reviews'])->group(function () {
        Route::get('admin/reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::post('admin/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve')->middleware('permission:approve reviews');
        Route::post('admin/reviews/{id}/reject', [ReviewController::class, 'reject'])->name('reviews.reject')->middleware('permission:approve reviews');
        Route::post('admin/reviews/{id}/reply', [ReviewController::class, 'reply'])->name('reviews.reply')->middleware('permission:reply reviews');
        Route::delete('admin/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.delete')->middleware('permission:delete reviews');
    });

    // Booking Management Routes
    Route::get('admin/bookings', [BookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('admin/bookings/{slug}', [BookingController::class, 'show'])->name('admin.bookings.show');
    Route::post('admin/bookings/{slug}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.updateStatus');
    Route::post('admin/bookings/{slug}/refund', [BookingController::class, 'processRefund'])->name('admin.bookings.refund');
    Route::get('admin/bookings/{slug}/invoice', [InvoiceController::class, 'download'])->name('admin.bookings.invoice');
    Route::delete('admin/bookings/{slug}', [BookingController::class, 'destroy'])->name('admin.bookings.destroy');

    // Addon Routes
    Route::get('admin/addons', [AddonController::class, 'index'])->name('addons.index');
    Route::get('admin/addons/create', [AddonController::class, 'create'])->name('addons.create');
    Route::post('admin/addons/store', [AddonController::class, 'store'])->name('addons.store');
    Route::get('admin/addons/edit/{addon}', [AddonController::class, 'edit'])->name('addons.edit');
    Route::put('admin/addons/update/{addon}', [AddonController::class, 'update'])->name('addons.update');
    Route::delete('admin/addons/delete/{addon}', [AddonController::class, 'destroy'])->name('addons.destroy');

    // Global Settings
    Route::get('admin/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('admin/settings', [SettingController::class, 'update'])->name('settings.update');
});

Route::middleware(['auth','role:employee'])->group(function () {
    Route::get('/employee/dashboard', function () {
        return view('employee.dashboard');
    })->name('employee.dashboard');
});



Route::get('/', [FrontendAuthController::class, 'index'])->name('home');


// frontend auth
Route::prefix('user')->group(function () {
    Route::get('/login', [FrontendAuthController::class,'loginForm'])->name('frontend.login');
    Route::post('/login', [FrontendAuthController::class,'login']);

    Route::get('/auth/google', [FrontendAuthController::class,'redirectToGoogle'])->name('frontend.google.redirect');
    Route::get('/auth/google/callback', [FrontendAuthController::class,'handleGoogleCallback'])->name('frontend.google.callback');

    Route::get('/register', [FrontendAuthController::class,'registerForm'])->name('frontend.register');
    Route::post('/register', [FrontendAuthController::class,'register']);

    Route::get('/verify-otp', [FrontendAuthController::class,'verifyOtpForm'])->name('frontend.otp.verify');
    Route::post('/verify-otp', [FrontendAuthController::class,'verifyOtp']);
    Route::post('/resend-otp', [FrontendAuthController::class,'resendOtp'])->name('frontend.otp.resend')->middleware('throttle:5,1');

    Route::get('/password/reset', [FrontendAuthController::class,'forgotPasswordForm'])->name('frontend.password.request');
    Route::post('/password/email', [FrontendAuthController::class,'sendResetOtp'])->name('frontend.password.email')->middleware('throttle:5,1');
    Route::get('/password/reset/{email}', [FrontendAuthController::class,'resetPasswordForm'])->name('frontend.password.reset');
    Route::post('/password/reset', [FrontendAuthController::class,'resetPassword'])->name('frontend.password.update.otp');

    Route::middleware(['auth:user'])->group(function () {
        Route::get('/dashboard', [FrontendAuthController::class,'dashboard'])->name('frontend.dashboard');
        Route::get('/logout', [FrontendAuthController::class,'logout'])->name('frontend.logout');
        
        // Profile routes
        Route::get('/profile/edit', [FrontendAuthController::class,'profileEdit'])->name('frontend.profile.edit');
        Route::post('/profile/update', [FrontendAuthController::class,'profileUpdate'])->name('frontend.profile.update');
        Route::get('/password/change', [FrontendAuthController::class,'passwordChangeForm'])->name('frontend.password.change');
        Route::post('/password/update', [FrontendAuthController::class,'passwordUpdate'])->name('frontend.password.update');

        // Booking history
        Route::get('/my-bookings', [FrontendAuthController::class, 'myBookings'])->name('frontend.my.bookings');
        Route::post('/booking/{slug}/cancel', [FrontendAuthController::class, 'cancelBooking'])->name('frontend.booking.cancel');
        Route::post('/booking/{slug}/retry-payment', [PaymentController::class, 'retryPayment'])->name('frontend.booking.retryPayment');

        // Booking & payment (Razorpay)
        Route::post('/booking/calculate-price', [PaymentController::class, 'calculatePrice'])->name('booking.calculate.price');
        Route::post('/booking/razorpay/order', [PaymentController::class, 'createOrder'])->name('booking.razorpay.order');
        Route::post('/booking/razorpay/verify', [PaymentController::class, 'verify'])->name('booking.razorpay.verify');
    });
});


Route::get('/aboutus', [FrontendAuthController::class,'aboutus'])->name('frontend.aboutus');
Route::get('/contactus', [FrontendAuthController::class,'contactus'])->name('frontend.contactus');
Route::get('/Faq', [FrontendAuthController::class,'faq'])->name('frontend.faq');
Route::post('/contact/submit', [FrontendAuthController::class,'submitContactForm'])->name('frontend.contact.submit')->middleware('throttle:5,1');
Route::post('/faq/submit', [FrontendAuthController::class,'submitFaqForm'])->name('frontend.faq.submit')->middleware('throttle:5,1');
Route::get('/gallary', [FrontendAuthController::class,'gallery'])->name('frontend.gallery');
Route::get('/tour', [FrontendAuthController::class,'tour'])->name('frontend.tour');
Route::get('/tour/details/{slug}', [FrontendAuthController::class,'tourDetail'])->name('frontend.tour.detail');
Route::get('/tour/{slug}/book', [FrontendAuthController::class,'bookTour'])
    ->name('frontend.tour.book')
    ->middleware('auth:user');
Route::get('/booking/success/{slug}', [FrontendAuthController::class,'bookingSuccess'])
    ->name('frontend.booking.success')
    ->middleware('auth:user');

// Backward compatibility: Redirect old ID-based booking URLs to slug URLs
Route::get('/booking/success/id/{id}', function($id) {
    $booking = \App\Models\TourBooking::findOrFail($id);
    return redirect()->route('frontend.booking.success', $booking->slug)->setStatusCode(301);
})->middleware('auth:user');
Route::post('/tour/review/submit', [FrontendAuthController::class,'submitReview'])->name('frontend.review.submit');
Route::get('/blogs', [FrontendAuthController::class,'blogs'])->name('frontend.blogs');
Route::get('/blog/details/{slug}', [FrontendAuthController::class,'blogDetail'])->name('frontend.blog.detail');
Route::get('/privacy-policy', [FrontendAuthController::class,'privacyPolicy'])->name('frontend.privacy.policy');
Route::get('/terms-and-conditions', [FrontendAuthController::class,'termsAndConditions'])->name('frontend.terms.and.conditions');
Route::get('/Cancellation-policy', [FrontendAuthController::class,'cancellationPolicy'])->name('frontend.cancellation.policy');


Route::get('/category/{slug}', [CategoryController::class, 'catTour'])->name('category.tours');