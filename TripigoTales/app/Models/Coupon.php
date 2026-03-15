<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'discount', 'status',
        'expiry_date', 'usage_limit', 'used_count', 'min_amount', 'discount_type'
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'status' => 'boolean',
        'expiry_date' => 'date',
        'min_amount' => 'decimal:2',
    ];
}
