<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAddon extends Model
{
    use HasFactory;

    protected $fillable = ['tour_booking_id', 'addon_id', 'quantity', 'price'];

    public function booking()
    {
        return $this->belongsTo(TourBooking::class, 'tour_booking_id');
    }

    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }
}
