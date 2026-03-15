<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_booking_id',
        'user_id',
        'action',
        'old_value',
        'new_value',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function tourBooking()
    {
        return $this->belongsTo(TourBooking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
