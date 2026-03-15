<?php 
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Tour;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\ContactUsSubmission;
use App\Models\ContactInquiry;
use App\Models\Review;
use App\Models\TourBooking;
use App\Models\BookingAudit;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\OtpMail;
use App\Mail\ResetPasswordMail;
use Carbon\Carbon;

class FrontendAuthController extends Controller
{

    public function index()
    {
        $tours = \Illuminate\Support\Facades\Cache::remember('home_tours', 3600, function () {
            return Tour::where('status', 1)->latest()->get();
        });

        $discountedTours = \Illuminate\Support\Facades\Cache::remember('home_discountedTours', 3600, function () {
            return Tour::where('status', 1)
                ->where('discount_status', 1)
                ->whereNotNull('special_discount')
                ->where('special_discount', '>', 0)
                ->latest()
                ->get();
        });

        $categories = \Illuminate\Support\Facades\Cache::remember('home_categories', 3600, function () {
            return Category::where('status', 1)
                ->whereNull('parent_id')
                ->withCount('allTours')
                ->get();
        });

        $blogs = collect();
        if (Schema::hasTable('blogs')) {
            $blogs = \Illuminate\Support\Facades\Cache::remember('home_blogs', 3600, function () {
                return Blog::where('status', 1)
                    ->orderByDesc('published_date')
                    ->latest()
                    ->take(3)
                    ->get();
            });
        }

        $sliders = collect();
        if (Schema::hasTable('sliders')) {
            $sliders = \Illuminate\Support\Facades\Cache::remember('home_sliders', 3600, function () {
                return Slider::with('buttons')
                    ->where('status', 1)
                    ->orderBy('sort_order')
                    ->get();
            });
        }

        $testimonials = collect();
        if (Schema::hasTable('testimonials')) {
            $testimonials = \Illuminate\Support\Facades\Cache::remember('home_testimonials', 3600, function () {
                return Testimonial::where('status', 1)
                    ->orderBy('sort_order')
                    ->get();
            });
        }

        $tourDurations = \Illuminate\Support\Facades\Cache::remember('home_tourDurations', 3600, function () {
            return Tour::where('status', 1)
                ->whereNotNull('tour_duration')
                ->where('tour_duration', '!=', '')
                ->select('tour_duration')
                ->distinct()
                ->orderBy('tour_duration')
                ->pluck('tour_duration');
        });

        return view('welcome', compact('tours', 'discountedTours', 'blogs', 'categories', 'sliders', 'testimonials', 'tourDurations'));
    }


    // show login form
    public function loginForm()
    {
        return view('frontend.login');
    }

    // show register form
    public function registerForm()
    {
        return view('frontend.register');
    }

    // register submit
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // assign frontend role
        $user->assignRole('user');

        // Generate OTP
        $otp = rand(100000, 999999);
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP Mail
        Mail::to($user->email)->send(new OtpMail($otp));

        // Redirect to OTP verification page instead of logging in
        return redirect()->route('frontend.otp.verify')->with('email', $user->email);
    }

    // show OTP verification form
    public function verifyOtpForm()
    {
        $email = session('email');
        if (!$email) {
            return redirect()->route('frontend.login');
        }
        return view('frontend.verify_otp', compact('email'));
    }

    // verify OTP submit
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->otp !== $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
            return back()->with('error', 'Invalid or expired OTP.')->with('email', $request->email);
        }

        // Mark as verified
        $user->update([
            'email_verified_at' => Carbon::now(),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        // Auto login
        Auth::guard('user')->login($user);

        return redirect('/')->with('success', 'Email verified and logged in successfully!');
    }

    // resend OTP
    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at) {
            return redirect()->route('frontend.login')->with('success', 'Email already verified.');
        }

        $otp = rand(100000, 999999);
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

        return back()->with('success', 'New OTP sent to your email.')->with('email', $user->email);
    }

    // login submit
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if account exists
        $userExists = User::where('email', $request->email)->exists();
        if (!$userExists) {
            return back()
                ->with('error', 'account_not_found')
                ->withInput($request->only('email'));
        }

        // attempt login using 'user' guard
        if (Auth::guard('user')->attempt($request->only('email','password'))) {
            $user = Auth::guard('user')->user();
            
            // Check if email is verified
            if (is_null($user->email_verified_at)) {
                $user->update([
                    'otp' => rand(100000, 999999),
                    'otp_expires_at' => Carbon::now()->addMinutes(10),
                ]);
                Mail::to($user->email)->send(new OtpMail($user->otp));
                
                Auth::guard('user')->logout();
                return redirect()->route('frontend.otp.verify')->with('email', $user->email)->with('error', 'Please verify your email first. A new OTP has been sent.');
            }

           return redirect('/');
        }

        return back()->with('error','Invalid password. Please try again.')->withInput($request->only('email'));
    }

    // Forgot Password Form
    public function forgotPasswordForm()
    {
        return view('frontend.forgot_password');
    }

    // Send Reset OTP
    public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();

        // Prevent Google users from resetting password
        if (!is_null($user->google_id)) {
            return back()->with('error', 'Password reset is not available for Google accounts. Please login using Google.');
        }

        $otp = rand(100000, 999999);
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new ResetPasswordMail($otp));

        return redirect()->route('frontend.password.reset', ['email' => $user->email])
            ->with('success', 'A 6-digit reset code has been sent to your email.');
    }

    // Reset Password Form
    public function resetPasswordForm($email)
    {
        return view('frontend.reset_password', compact('email'));
    }

    // Reset Password Submit
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->otp !== $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
            return back()->with('error', 'Invalid or expired code.')->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        return redirect()->route('frontend.login')->with('success', 'Password reset successfully. You can now login.');
    }

    /**
     * Redirect to Google for authentication.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback: create or login user.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect()->route('frontend.login')->with('error', 'Unable to login with Google. Please try again.');
        }

        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            Auth::guard('user')->login($user);
            return redirect('/');
        }

        // Check if user exists with same email (link accounts)
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);
            Auth::guard('user')->login($user);
            return redirect('/');
        }

        // Create new user
        $user = User::create([
            'name' => $googleUser->getName() ?? $googleUser->getEmail(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'password' => Hash::make(Str::random(24)),
        ]);

        $user->assignRole('user');
        Auth::guard('user')->login($user);

        return redirect('/');
    }

    // dashboard
    public function dashboard()
    {
        return view('frontend.dashboard');
    }

    // logout
   public function logout()
    {
        Auth::guard('user')->logout();
        return redirect('/');
    }

    // Profile Edit
    public function profileEdit()
    {
        $user = Auth::guard('user')->user();
        return view('frontend.profile.edit', compact('user'));
    }

    // Profile Update
    public function profileUpdate(Request $request)
    {
        $user = Auth::guard('user')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'pincode' => $request->pincode,
        ]);

        return redirect()->route('frontend.profile.edit')
            ->with('success', 'Profile updated successfully!');
    }

    // Password Change Form
    public function passwordChangeForm()
    {
        $user = Auth::guard('user')->user();
        
        // Prevent Gmail users from accessing password change
        if (!is_null($user->google_id)) {
            return redirect('/')->with('error', 'Password change is not available for Google accounts.');
        }

        return view('frontend.password.change');
    }

    // Password Update
    public function passwordUpdate(Request $request)
    {
        $user = Auth::guard('user')->user();

        // Prevent Gmail users from changing password
        if (!is_null($user->google_id)) {
            return redirect('/')->with('error', 'Password change is not available for Google accounts.');
        }

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('frontend.password.change')
            ->with('success', 'Password changed successfully!');
    }


    /**
     * Show logged-in user's booking history.
     */
    public function myBookings()
    {
        $user = Auth::guard('user')->user();
        $bookings = TourBooking::with('tour')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('frontend.myBookings', compact('bookings', 'user'));
    }

    public function aboutus()
    {
        return view('frontend.aboutus');
    }

    public function contactus()
    {
        return view('frontend.contactus');
    }

    public function faq()
    {
        return view('frontend.faq');
    }

    public function tour(Request $request)
    {
        $query = Tour::where('status', 1);

        if ($request->filled('destination')) {
            $query->where('category_id', $request->destination);
        }
        if ($request->filled('travel_type')) {
            $query->where('subcategory_id', $request->travel_type);
        }
        if ($request->filled('tour_duration')) {
            $query->where(function ($q) use ($request) {
                $q->where('tour_duration', $request->tour_duration)
                  ->orWhere('day', $request->tour_duration);
            });
        }

        $sort = $request->get('sort', '');
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $tours = $query->get();

        $categories = Category::where('status', 1)->orderBy('name')->get();

        $searchParams = [
            'destination' => $request->get('destination'),
            'travel_type'  => $request->get('travel_type'),
            'tour_duration' => $request->get('tour_duration'),
        ];

        return view('frontend.tour', compact('tours', 'categories', 'sort', 'searchParams'));
    }

    public function tourDetail($slug){
    $tour = Tour::where('slug', $slug)->firstOrFail();
    // Ensure gallery_images is properly loaded as array
    if (is_string($tour->gallery_images)) {
        $tour->gallery_images = json_decode($tour->gallery_images, true) ?? [];
    }
    
    // Get approved reviews for this tour
    $reviews = Review::where('tour_id', $tour->id)
        ->where('is_approved', true)
        ->with('user')
        ->latest()
        ->get();

    $reviewCount = $reviews->count();
    $avgRating   = $reviews->avg('rating') ?? 0;
    
    return view('frontend.tourDetails', compact('tour', 'reviews', 'reviewCount', 'avgRating'));
}

    /**
     * Separate booking page for a tour (Razorpay).
     */
    public function bookTour($slug)
    {
        // Redirect guests to login before they can book
        if (!Auth::guard('user')->check()) {
            return redirect()->route('frontend.login')
                ->with('error', 'Please log in to book a tour.');
        }

        $tour = Tour::with(['category', 'subcategory', 'addons'])->where('slug', $slug)->firstOrFail();
        $user = Auth::guard('user')->user();
        $reviewCount = Review::where('tour_id', $tour->id)->where('is_approved', true)->count();
        $avgRating   = Review::where('tour_id', $tour->id)->where('is_approved', true)->avg('rating') ?? 0;

        // Fetch addons: those with no specific tour assigned (global) OR those linked to this tour via pivot
        $addons = \App\Models\Addon::whereDoesntHave('tours')
            ->orWhereHas('tours', fn($q) => $q->where('tours.id', $tour->id))
            ->get();

        return view('frontend.tourBooking', compact('tour', 'user', 'reviewCount', 'avgRating', 'addons'));
    }

    /**
     * Booking success / confirmation page after payment.
     */
    public function bookingSuccess($slug)
    {
        $booking = TourBooking::with(['tour', 'user'])->where('slug', $slug)->firstOrFail();
        if ($booking->status !== 'paid') {
            return redirect()->route('frontend.tour.detail', optional($booking->tour)->slug ?? $booking->tour_id)
                ->with('error', 'This booking is not confirmed.');
        }
        $authUser = Auth::guard('user')->user();
        if ($authUser && $booking->user_id && $booking->user_id != $authUser->id) {
            return redirect()->route('home')->with('error', 'Unauthorized.');
        }
        $tour = $booking->tour;
        $user = $booking->user;
        return view('frontend.bookingSuccess', compact('booking', 'tour', 'user'));
    }

    public function submitReview(Request $request)
    {
        // Check if user is logged in
        if (!Auth::guard('user')->check()) {
            return back()->with('error', 'Please login to submit a review.');
        }

        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|min:10',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::guard('user')->user();

        Review::create([
            'tour_id' => $request->tour_id,
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'is_approved' => false, // Requires admin approval
        ]);

        return back()->with('success', 'Your review has been submitted and is pending approval.');
    }

    public function gallery()
    {
        // If galleries table isn't migrated yet, avoid breaking page.
        $galleries = collect();
        if (Schema::hasTable('galleries')) {
            $galleries = Gallery::latest()->paginate(12);
        }

        return view('frontend.gallery', compact('galleries'));
    }

    public function privacyPolicy()
    {
        return view('frontend.privacyPolicy');
    }

    public function termsAndConditions()
    {
        return view('frontend.termsAndConditions');
    }


    public function cancellationPolicy()
    {
        return view('frontend.cancellationPolicy');
    }

    public function blogs()
    {
        // If blogs table isn't migrated yet, avoid breaking page.
        $blogs = collect();
        if (Schema::hasTable('blogs')) {
            $blogs = Blog::where('status', 1)
                ->orderByDesc('published_date')
                ->latest()
                ->paginate(12);
        }
        return view('frontend.blogs', compact('blogs'));
    }

    public function blogDetail($slug)
    {
        if (!Schema::hasTable('blogs')) {
            abort(404);
        }
        $blog = Blog::where('status', 1)->where('slug', $slug)->firstOrFail();
        return view('frontend.blogDetail', compact('blog'));
    }

    /**
     * Handle Contact Us form submission only (separate from FAQ).
     */
    public function submitContactForm(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:5000',
        ], [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'phone.required' => 'Phone number is required.',
            'message.required' => 'Please enter your message.',
        ]);

        try {
            $submission = ContactUsSubmission::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
            ]);

            $adminEmail = env('MAIL_ADMIN_EMAIL', config('mail.from.address', 'admin@tripigotales.com'));
            try {
                Mail::send('emails.contact-us-submission', [
                    'submission' => $submission,
                ], function ($message) use ($adminEmail, $submission) {
                    $message->to($adminEmail)
                        ->subject('New Contact Us: ' . $submission->first_name . ' ' . $submission->last_name);
                });
            } catch (\Exception $mailException) {
                Log::error('Failed to send contact us email: ' . $mailException->getMessage());
            }

            return redirect()->route('frontend.contactus')
                ->with('success', 'Thank you for your message! We will contact you soon.');
        } catch (\Exception $e) {
            Log::error('Contact Us form submission error: ' . $e->getMessage());
            return redirect()->route('frontend.contactus')
                ->with('error', 'Sorry, there was an error submitting your message. Please try again later.')
                ->withInput();
        }
    }

    /**
     * Handle FAQ page form submission (saves to contact_inquiries).
     */
    public function submitFaqForm(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'destination_id' => 'nullable|exists:categories,id',
            'message' => 'required|string|max:5000',
        ], [
            'full_name.required' => 'Full name is required.',
            'phone.required' => 'Phone number is required.',
            'email.required' => 'Email is required.',
            'message.required' => 'Please enter your message.',
        ]);

        try {
            $inquiry = ContactInquiry::create([
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'destination_id' => $request->destination_id,
                'message' => $request->message,
                'is_read' => false,
            ]);

            $adminEmail = env('MAIL_ADMIN_EMAIL', config('mail.from.address', 'admin@tripigotales.com'));
            $destinationName = $inquiry->destination ? $inquiry->destination->name : 'Not specified';
            try {
                Mail::send('emails.contact-inquiry', [
                    'inquiry' => $inquiry,
                    'destinationName' => $destinationName,
                ], function ($message) use ($adminEmail, $inquiry) {
                    $message->to($adminEmail)
                        ->subject('New FAQ Inquiry: ' . $inquiry->full_name);
                });
            } catch (\Exception $mailException) {
                Log::error('Failed to send FAQ inquiry email: ' . $mailException->getMessage());
            }

            return redirect()->route('frontend.faq')
                ->with('success', 'Thank you for your inquiry! We will contact you soon.');
        } catch (\Exception $e) {
            Log::error('FAQ form submission error: ' . $e->getMessage());
            return redirect()->route('frontend.faq')
                ->with('error', 'Sorry, there was an error submitting your inquiry. Please try again later.')
                ->withInput();
        }
    }

    /**
     * Cancel a booking by the user.
     */
    public function cancelBooking(Request $request, $slug)
    {
        $user = Auth::guard('user')->user();
        $booking = TourBooking::where('user_id', $user->id)->where('slug', $slug)->firstOrFail();

        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'This booking cannot be cancelled (must be at least 24 hours before tour start).');
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $oldStatus = $booking->status;
        $newStatus = ($booking->status === 'paid') ? 'awaiting_refund' : 'cancelled';

        $booking->update([
            'status' => $newStatus,
            'cancelled_at' => now(),
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        // Audit Logging
        BookingAudit::create([
            'tour_booking_id' => $booking->id,
            'user_id' => $user->id,
            'action' => 'user_cancellation',
            'old_value' => $oldStatus,
            'new_value' => $newStatus,
            'metadata' => [
                'reason' => $request->cancellation_reason,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]
        ]);

        $message = ($newStatus === 'awaiting_refund') 
            ? 'Your booking has been cancelled. A refund will be processed within 5-7 business days.'
            : 'Your booking has been cancelled successfully.';

        return redirect()->route('frontend.my.bookings')->with('success', $message);
    }
}
