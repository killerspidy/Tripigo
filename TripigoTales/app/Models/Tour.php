<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'title', 'slug', 'location', 'language', 'star_rating', 'image', 'gallery_images', 'pdf', 'status', 'special_discount', 'discount_status',
        'category_id', 'subcategory_id', 'tour_duration',
        'price',
        'available_dates',
        'schedule_type', 'schedule_days', 'specific_dates',
        'day', 'max_people', 'min_age', 'bedroom',
        'friday_date', 'pickup', 'departure_time',
        'description', 'what_to_expect',
        'price_includes', 'departure_return_location', 'travel_plan'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($tour) {
            if (empty($tour->slug) || $tour->isDirty('title')) {
                $tour->slug = static::generateUniqueSlug($tour->title, $tour->id);
            }
        });

        static::deleting(function ($tour) {
            // Delete related records that might block deletion
            $tour->bookings()->get()->each->delete();
            $tour->reviews()->get()->each->delete();
            $tour->addons()->detach();
        });
    }

    protected static function generateUniqueSlug($title, $id = null)
    {
        $slug = \Illuminate\Support\Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    protected $casts = [
        'price_includes'          => 'array',
        'day'                     => 'array',
        'what_to_expect'          => 'array',
        'departure_return_location' => 'array',
        'travel_plan'             => 'array',
        'gallery_images'          => 'array',
        'status'                  => 'boolean',
        'available_dates'         => 'array',
        'schedule_days'           => 'array',
        'specific_dates'          => 'array',
    ];


    // Tour.php
public function category(){
    return $this->belongsTo(Category::class,'category_id');
}

public function subcategory(){
    return $this->belongsTo(Category::class,'subcategory_id');
}

public function addons()
    {
        return $this->belongsToMany(Addon::class, 'addon_tour');
    }

    public function bookings()
    {
        return $this->hasMany(TourBooking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
