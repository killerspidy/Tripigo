<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTraveler extends Model
{
    use HasFactory;
    protected $fillable = ['tour_booking_id', 'name', 'dob', 'gender', 'email', 'phone'];
    public function booking()
    {
        return $this->belongsTo(TourBooking::class, 'tour_booking_id');
    }
}
