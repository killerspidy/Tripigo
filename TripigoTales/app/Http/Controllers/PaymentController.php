<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourBooking;
use App\Models\BookingTraveler;
use App\Models\BookingAddon;
use App\Models\Addon;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Resolve pricing logic for a tour booking.
     */
    private function resolvePricing($tour, $persons, $requestAddons, $couponCode = null)
    {
        // 1. Base Tour Cost: single price per person × number of persons
        $rate = $tour->price ?? 0;
        $subtotal = $rate * $persons;

        // 2. Add-ons Cost
        $addonsAmount = 0;
        $processedAddons = [];
        if (is_array($requestAddons)) {
            foreach ($requestAddons as $addonReq) {
                if (isset($addonReq['id']) && isset($addonReq['quantity']) && $addonReq['quantity'] > 0) {
                    $addon = Addon::with('tours')->find($addonReq['id']);
                    if ($addon && ($addon->tours->isEmpty() || $addon->tours->contains('id', $tour->id))) {
                        $addonsAmount += ($addon->price * $addonReq['quantity']);
                        $processedAddons[] = [
                            'addon_id' => $addon->id,
                            'price' => $addon->price,
                            'quantity' => $addonReq['quantity']
                        ];
                    }
                }
            }
        }

        $grossTotal = $subtotal + $addonsAmount;

        // 3. Discount
        $discountAmount = 0;
        $coupon = null;
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)
                ->where('status', 1)
                ->first(); // Note: lockForUpdate() is used during actual checkout, not pure calculation

            if ($coupon) {
                // Validate Expiry
                $isExpired = $coupon->expiry_date && Carbon::now()->startOfDay()->gt(Carbon::parse($coupon->expiry_date)->startOfDay());
                // Validate Usage Limit
                $isLimitReached = $coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit;

                if (!$isExpired && !$isLimitReached && $grossTotal >= $coupon->min_amount) {
                    if ($coupon->discount_type === 'percentage') {
                        $discountAmount = ($grossTotal * $coupon->discount) / 100;
                    } else {
                        $discountAmount = $coupon->discount;
                    }
                } else {
                    $coupon = null; // Invalidate for calculation purposes if rules fail
                }
            }
        }

        $amountAfterDiscount = max(0, $grossTotal - $discountAmount);

        // 4. GST
        $gstAmount = 0;
        $gstEnabled = \App\Models\Setting::where('key', 'gst_enabled')->value('value');
        $gstPercentage = \App\Models\Setting::where('key', 'gst_percentage')->value('value') ?? 0;

        if ($gstEnabled == '1') {
            $gstAmount = $amountAfterDiscount * ($gstPercentage / 100);
        }

        // 5. Final Total
        $finalTotal = $amountAfterDiscount + $gstAmount;

        return [
            'subtotal' => $subtotal,
            'addons_amount' => $addonsAmount,
            'discount_amount' => $discountAmount,
            'gst_amount' => $gstAmount,
            'final_total' => $finalTotal,
            'coupon' => $coupon,
            'processed_addons' => $processedAddons
        ];
    }

    /**
     * Calculate Price endpoint for frontend AJAX
     */
    public function calculatePrice(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'persons' => 'required|integer|min:1',
            'addons'  => 'nullable|array',
            'coupon'  => 'nullable|string'
        ]);

        $tour = Tour::findOrFail($request->tour_id);
        $pricing = $this->resolvePricing($tour, $request->persons, $request->addons ?? [], $request->coupon);

        return response()->json([
            'success' => true,
            'pricing' => [
                'subtotal' => round($pricing['subtotal'], 2),
                'addons_amount' => round($pricing['addons_amount'], 2),
                'discount_amount' => round($pricing['discount_amount'], 2),
                'gst_amount' => round($pricing['gst_amount'], 2),
                'final_total' => round($pricing['final_total'], 2),
            ]
        ]);
    }

    /**
     * Create Razorpay order & booking record.
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'tour_id'   => 'required|exists:tours,id',
            'from_date' => 'nullable|date',
            'to_date'   => 'nullable|date|after_or_equal:from_date',
            'persons'   => 'required|integer|min:1',
            'travelers' => 'nullable|array',
            'addons'    => 'nullable|array',
            'coupon'    => 'nullable|string',
            'name'      => 'required|string|max:100|regex:/^[a-zA-Z\s\-\']+$/',
            'email'     => 'required|email|max:150',
            'phone'     => 'required|string|size:10|regex:/^[0-9]{10}$/',
            'travelers' => 'required|array|min:1',
            'travelers.*.name'   => 'required|string|max:100|regex:/^[a-zA-Z\s\-\']+$/',
            'travelers.*.gender' => 'required|in:Male,Female,Other',
            'travelers.*.dob'    => 'required|date|before:today',
            'travelers.*.email'  => 'required|email|max:150',
            'travelers.*.phone'  => 'required|string|size:10|regex:/^[0-9]{10}$/',
        ], [
            'name.regex' => 'The name may only contain letters and spaces.',
            'phone.regex' => 'Please enter a valid 10-digit phone number.',
            'travelers.*.name.regex' => 'Traveler names may only contain letters and spaces.',
            'travelers.*.phone.regex' => 'Each traveler must have a valid 10-digit phone number.',
        ]);

        $tour = Tour::findOrFail($request->tour_id);

        $from = $request->from_date ? Carbon::parse($request->from_date) : null;
        
        // --- CALENDAR VALIDATION (Tour Schedule-Aware) ---
        if ($from) {
            $dateStr     = $from->toDateString();
            $schedType   = $tour->schedule_type ?? 'weekly';
            $blockedDates = is_array($tour->available_dates) ? $tour->available_dates : [];

            // 1. Must be in the future (not past)
            if ($from->lt(Carbon::today())) {
                return response()->json(['message' => 'Tour date cannot be in the past.'], 422);
            }

            // 2. Must be within 6 months from today
            if ($from->gt(Carbon::today()->addMonths(6))) {
                return response()->json(['message' => 'Tour date must be within the next 6 months.'], 422);
            }

            // 3. Schedule-type specific check
            if ($schedType === 'weekly') {
                $allowedDays = is_array($tour->schedule_days) ? $tour->schedule_days : [5];
                if (!in_array($from->dayOfWeek, $allowedDays)) {
                    $dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                    $allowed  = implode(', ', array_map(fn($d) => $dayNames[$d], $allowedDays));
                    return response()->json(['message' => "This tour is only available on: {$allowed}."], 422);
                }
            } elseif ($schedType === 'specific') {
                $specificDates = is_array($tour->specific_dates) ? $tour->specific_dates : [];
                if (!in_array($dateStr, $specificDates)) {
                    return response()->json(['message' => 'The selected date is not available for this tour.'], 422);
                }
            }
            // 'open' → any future date is valid, no further check needed

            // 4. Is it in blocked/closed dates?
            if (in_array($dateStr, $blockedDates)) {
                return response()->json(['message' => 'This date is not available for booking.'], 422);
            }
        } else {
            return response()->json(['message' => 'Please select a travel date.'], 422);
        }

        $to   = $request->to_date ? Carbon::parse($request->to_date) : null;
        // If 'to_date' is not provided, calculate it based on duration if possible
        if (!$to && $from && $tour->tour_duration) {
            $duration = (int)$tour->tour_duration;
            if ($duration > 1) {
                $to = (clone $from)->addDays($duration - 1);
            } else {
                $to = clone $from;
            }
        }
        $days = ($from && $to) ? $from->diffInDays($to) + 1 : null;

        $user = Auth::guard('user')->user();

        try {
            DB::beginTransaction();

            // Lock coupon for update if provided
            $couponCode = $request->coupon;
            if ($couponCode) {
                $checkCoupon = Coupon::where('code', $couponCode)->where('status', 1)->lockForUpdate()->first();
            }

            $pricing = $this->resolvePricing($tour, $request->persons, $request->addons ?? [], $couponCode);
            $totalAmount = $pricing['final_total'];

            if ($totalAmount <= 0) {
                DB::rollBack();
                return response()->json(['message' => 'Invalid total amount calculated.'], 422);
            }
            
            // Check if coupon failed validation during resolvePricing despite existing
            if ($couponCode && !$pricing['coupon']) {
                DB::rollBack();
                return response()->json(['message' => 'Coupon is invalid, expired, or requirements not met.'], 422);
            }

            $booking = TourBooking::create([
                'tour_id'          => $tour->id,
                'user_id'          => $user?->id,
                'from_date'        => $from?->toDateString(),
                'to_date'          => $to?->toDateString(),
                'days'             => $days,
                'persons'          => $request->persons,
                'price_per_person' => $tour->price ?? 0,
                'subtotal'         => $pricing['subtotal'],
                'addons_amount'    => $pricing['addons_amount'],
                'discount_amount'  => $pricing['discount_amount'],
                'coupon_id'        => $pricing['coupon'] ? $pricing['coupon']->id : null,
                'gst_amount'       => $pricing['gst_amount'],
                'total_amount'     => $totalAmount,
                'status'           => 'pending',
            ]);

            if (is_array($request->travelers)) {
                foreach ($request->travelers as $traveler) {
                    if (!empty($traveler['name'])) {
                        BookingTraveler::create([
                            'tour_booking_id' => $booking->id,
                            'name'            => $traveler['name'],
                            'dob'             => $traveler['dob'] ?? null,
                            'gender'          => $traveler['gender'] ?? null,
                            'email'           => $traveler['email'] ?? null,
                            'phone'           => '+91 ' . ($traveler['phone'] ?? ''),
                        ]);
                    }
                }
            }

            // Save Addons Pivot
            foreach ($pricing['processed_addons'] as $addonData) {
                BookingAddon::create([
                    'tour_booking_id' => $booking->id,
                    'addon_id'        => $addonData['addon_id'],
                    'price'           => $addonData['price'],
                    'quantity'        => $addonData['quantity']
                ]);
            }

            // NOTE: Coupon usage is incremented ONLY after payment is verified (in verify())

            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $order = $api->order->create([
                'amount'   => (int) round($totalAmount * 100),
                'currency' => 'INR',
                'receipt'  => 'BOOKING_' . $booking->id,
                'notes'    => [
                    'tour_id'    => (string) $tour->id,
                    'booking_id' => (string) $booking->id,
                ],
            ]);

            $booking->update([
                'razorpay_order_id' => $order['id'],
            ]);

            DB::commit();

            return response()->json([
                'key'        => config('services.razorpay.key'),
                'order_id'   => $order['id'],
                'amount'     => $totalAmount * 100,
                'currency'   => 'INR',
                'booking_id' => $booking->id,
                'customer'   => [
                    'name'  => $user?->name ?? 'Guest',
                    'email' => $user?->email ?? null,
                    'phone' => $user?->phone ?? null,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Creation Failed: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while creating order.'], 500);
        }
    }

    /**
     * Retry payment for a pending booking.
     */
    public function retryPayment(Request $request, $slug)
    {
        $user = Auth::guard('user')->user();
        $booking = TourBooking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('slug', $slug)
            ->firstOrFail();

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            // If we already have an order ID, we can try to reuse it or create a new one if needed.
            // For simplicity and to ensure the amount matches current record, we create a fresh order.
            $order = $api->order->create([
                'amount'   => (int) round($booking->total_amount * 100),
                'currency' => 'INR',
                'receipt'  => 'BOOKING_RETRY_' . $booking->id,
                'notes'    => [
                    'tour_id'    => (string) $booking->tour_id,
                    'booking_id' => (string) $booking->id,
                ],
            ]);

            $booking->update([
                'razorpay_order_id' => $order['id'],
            ]);

            return response()->json([
                'key'        => config('services.razorpay.key'),
                'order_id'   => $order['id'],
                'amount'     => $booking->total_amount * 100,
                'currency'   => 'INR',
                'booking_id' => $booking->id,
                'customer'   => [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => str_replace('+91 ', '', $user->phone),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Order Retry Failed: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while re-initializing payment.'], 500);
        }
    }
    /**
     * Verify Razorpay signature and mark booking as paid.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'booking_id'          => 'required|exists:tour_bookings,id',
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id'   => 'required|string',
            'razorpay_signature'  => 'required|string',
        ]);

        $booking = TourBooking::findOrFail($request->booking_id);

        if ($booking->razorpay_order_id !== $request->razorpay_order_id) {
            return response()->json(['message' => 'Order mismatch.'], 422);
        }

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $attributes = [
            'razorpay_signature'  => $request->razorpay_signature,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_order_id'   => $request->razorpay_order_id,
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);

            DB::transaction(function () use ($booking, $request) {
                $booking->update([
                    'status'              => 'paid',
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature'  => $request->razorpay_signature,
                ]);

                // Increment coupon usage only after successful payment
                if ($booking->coupon_id) {
                    $coupon = \App\Models\Coupon::lockForUpdate()->find($booking->coupon_id);
                    if ($coupon) {
                        // Optional: Issue a refund/warning here if usage_limit is breached.
                        // For now we just increment safely.
                        $coupon->increment('used_count');
                    }
                }
            });

            // Send Notification Emails
            try {
                // To User
                if ($booking->user && $booking->user->email) {
                    \Illuminate\Support\Facades\Mail::to($booking->user->email)->send(new \App\Mail\BookingConfirmed($booking));
                }
                // To Admin
                $adminEmail = \App\Models\Setting::where('key', 'admin_email')->value('value') ?? config('mail.from.address');
                \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\AdminBookingNotification($booking));
            } catch (\Exception $mailEx) {
                Log::error('Booking notification emails failed: ' . $mailEx->getMessage());
            }

            return response()->json([
                'success'    => true,
                'redirectTo' => route('frontend.booking.success', $booking->slug),
            ]);
        } catch (SignatureVerificationError $e) {
            Log::error('Razorpay signature verification failed: ' . $e->getMessage());
            $booking->update(['status' => 'failed']);
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.',
            ], 422);
        }
    }
}
