<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    Protected $guarded = [];
    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
