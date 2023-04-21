<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }
    public function contents()
    {
        return $this->hasMany(Content::class);
    }

}
