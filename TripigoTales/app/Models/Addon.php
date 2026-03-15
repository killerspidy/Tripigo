<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description'];

    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'addon_tour');
    }
}
