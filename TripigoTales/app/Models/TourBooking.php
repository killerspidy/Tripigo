<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TourBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'user_id',
        'slug',
        'from_date',
        'to_date',
        'days',
        'persons',
        'price_per_person',
        'total_amount',
        'status',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'subtotal',
        'addons_amount',
        'discount_amount',
        'coupon_id',
        'gst_amount',
        'cancelled_at',
        'cancellation_reason',
        'refund_id',
        'refund_status',
        'refund_amount'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->slug)) {
                $booking->slug = static::generateUniqueSlug();
            }
        });

        static::deleting(function ($booking) {
            // Delete related records that might block deletion
            $booking->travelers()->delete();
            $booking->bookingAddons()->delete();
            $booking->audits()->delete();
        });
    }

    /**
     * Generate a unique booking slug: TT-YYYYMMDD-XXXXX
     */
    protected static function generateUniqueSlug(): string
    {
        $date = Carbon::now()->format('Ymd');
        do {
            $slug = 'TT-' . $date . '-' . strtoupper(Str::random(5));
        } while (static::where('slug', $slug)->exists());

        return $slug;
    }

    /**
     * Use slug for public route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
        'cancelled_at' => 'datetime',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function travelers()
    {
        return $this->hasMany(BookingTraveler::class, 'tour_booking_id');
    }

    public function bookingAddons()
    {
        return $this->hasMany(BookingAddon::class, 'tour_booking_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function audits()
    {
        return $this->hasMany(BookingAudit::class, 'tour_booking_id');
    }

    /**
     * Check if the tour can still be cancelled by the user.
     * Policy: At least 24 hours before the scheduled start.
     */
    public function canBeCancelled()
    {
        if (!$this->from_date || !in_array($this->status, ['paid', 'pending'])) {
            return false;
        }

        // Using Carbon to check if the tour start date is more than 24 hours away from now
        return now()->diffInHours($this->from_date, false) >= 24;
    }

    /**
     * Get the refund eligibility message for the user.
     */
    public function getRefundEligibilityText()
    {
        if ($this->status === 'pending') {
            return "This booking is not yet paid. Cancellation will simply void the booking.";
        }

        if ($this->canBeCancelled()) {
            return "You are eligible for a refund according to our policy. Refunds are typically processed within 5-7 business days.";
        }

        return "This booking is within the 24-hour window and is no longer eligible for cancellation via the dashboard.";
    }
}
