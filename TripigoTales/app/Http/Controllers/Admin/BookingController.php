<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourBooking;
use App\Models\BookingAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * List all bookings with optional filters.
     */
    public function index(Request $request)
    {
        $query = TourBooking::with(['tour', 'user', 'travelers'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('razorpay_payment_id', 'like', "%{$search}%")
                  ->orWhere('razorpay_order_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('tour', function ($tq) use ($search) {
                      $tq->where('title', 'like', "%{$search}%");
                  });
            });
        }

        $bookings = $query->paginate(15)->withQueryString();

        $stats = [
            'total'   => TourBooking::count(),
            'paid'    => TourBooking::where('status', 'paid')->count(),
            'pending' => TourBooking::where('status', 'pending')->count(),
            'failed'  => TourBooking::where('status', 'failed')->count(),
            'revenue' => TourBooking::where('status', 'paid')->sum('total_amount'),
        ];

        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    /**
     * Show a single booking's full details.
     */
    public function show($slug)
    {
        $booking = TourBooking::with([
            'tour',
            'user',
            'travelers',
            'bookingAddons.addon',
            'coupon',
        ])->where('slug', $slug)->firstOrFail();

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update booking status (e.g. mark as cancelled).
     */
    public function updateStatus(Request $request, $slug)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed,cancelled,refunded,user_cancelled,awaiting_refund',
        ]);

        $booking = TourBooking::where('slug', $slug)->firstOrFail();
        $oldStatus = $booking->status;
        $booking->update(['status' => $request->status]);

        // Audit Logging
        BookingAudit::create([
            'tour_booking_id' => $booking->id,
            'user_id' => Auth::id(), // Admin ID
            'action' => 'admin_status_update',
            'old_value' => $oldStatus,
            'new_value' => $request->status,
            'metadata' => [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]
        ]);

        return redirect()->back()->with('success', "Booking #{$booking->id} status updated to {$request->status}.");
    }

    /**
     * Delete a booking record.
     */
    public function destroy($slug)
    {
        $booking = TourBooking::where('slug', $slug)->firstOrFail();
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', "Booking #{$booking->id} deleted successfully.");
    }

    /**
     * Process refund via Razorpay.
     */
    public function processRefund(Request $request, $slug)
    {
        $booking = TourBooking::where('slug', $slug)->firstOrFail();

        if ($booking->status !== 'awaiting_refund') {
            return back()->with('error', 'Refund can only be processed for bookings awaiting refund.');
        }

        if (empty($booking->razorpay_payment_id)) {
            return back()->with('error', 'Razorpay Payment ID not found for this booking.');
        }

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            $payment = $api->payment->fetch($booking->razorpay_payment_id);
            
            // Initiate refund
            $refundAmount = $booking->total_amount;
            $refund = $payment->refund([
                'amount' => (int) round($refundAmount * 100), // amount in paise
                'notes' => [
                    'booking_id' => $booking->id,
                    'reason' => $booking->cancellation_reason ?? 'User requested cancellation',
                ]
            ]);

            $booking->update([
                'status' => 'refunded',
                'refund_id' => $refund['id'],
                'refund_status' => 'processed',
                'refund_amount' => $refundAmount,
            ]);

            // Audit Logging
            BookingAudit::create([
                'tour_booking_id' => $booking->id,
                'user_id' => Auth::id(), // Admin ID
                'action' => 'admin_refund_processed',
                'old_value' => 'awaiting_refund',
                'new_value' => 'refunded',
                'metadata' => [
                    'refund_id' => $refund['id'],
                    'amount' => $refundAmount,
                    'ip' => $request->ip()
                ]
            ]);

            return back()->with('success', "Refund processed successfully. Refund ID: {$refund['id']}");

        } catch (\Exception $e) {
            Log::error('Razorpay Refund Error: ' . $e->getMessage());
            return back()->with('error', 'Razorpay Refund Error: ' . $e->getMessage());
        }
    }
}
