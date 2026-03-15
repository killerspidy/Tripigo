<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderButton extends Model
{
    use HasFactory;

    protected $fillable = ['slider_id', 'label', 'link', 'style', 'sort_order'];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }
}
